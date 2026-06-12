<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BidikmisiMember;
use Illuminate\Http\Request;

class BidikmisiMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = BidikmisiMember::query();

        if ($search = $request->query('search')) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
        }

        $sort = $request->query('sort', 'latest');
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'nama_asc') {
            $query->orderBy('nama', 'asc');
        } elseif ($sort === 'nama_desc') {
            $query->orderBy('nama', 'desc');
        } else {
            $query->latest();
        }

        $members = $query->paginate(15)->withQueryString();
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:bidikmisi_members',
            'jurusan' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'universitas' => 'nullable|string|max:255',
        ]);

        if (empty($validated['universitas'])) {
            $validated['universitas'] = 'Universitas Amikom Yogyakarta';
        }

        BidikmisiMember::create($validated);
        return redirect()->route('admin.members.index')->with('success', 'Data Anggota Imadikom berhasil ditambahkan!');
    }

    public function edit(BidikmisiMember $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, BidikmisiMember $member)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:bidikmisi_members,nim,' . $member->id,
            'jurusan' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'universitas' => 'nullable|string|max:255',
        ]);

        if (empty($validated['universitas'])) {
            $validated['universitas'] = 'Universitas Amikom Yogyakarta';
        }

        $member->update($validated);
        return redirect()->route('admin.members.index')->with('success', 'Data Anggota Imadikom berhasil diperbarui!');
    }

    public function destroy(BidikmisiMember $member)
    {
        $member->delete();
        return back()->with('success', 'Data Anggota Imadikom berhasil dihapus!');
    }

    // API Endpoint for NIM checking
    public function checkNim($nim)
    {
        $exists = BidikmisiMember::where('nim', $nim)->exists();
        return response()->json(['is_bidikmisi' => $exists]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $file = fopen($path, 'r');
        
        $header = fgetcsv($file); // skip header
        
        while (($row = fgetcsv($file)) !== false) {
            if (count($row) >= 4) { // at least nim, nama, jurusan, fakultas
                BidikmisiMember::updateOrCreate(
                    ['nim' => $row[0]],
                    [
                        'nama' => $row[1],
                        'jurusan' => $row[2],
                        'fakultas' => $row[3],
                        'universitas' => isset($row[4]) && trim($row[4]) !== '' ? $row[4] : 'Universitas Amikom Yogyakarta',
                    ]
                );
            }
        }
        
        fclose($file);
        
        return back()->with('success', 'Data CSV berhasil diimpor!');
    }
}
