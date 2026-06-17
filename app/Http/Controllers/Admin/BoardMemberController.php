<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardMember;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BoardMemberController extends Controller
{
    public function index()
    {
        $years = BoardMember::select('year')
            ->selectRaw('COUNT(*) as total_members')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();
            
        $active_year = \App\Models\Setting::get('active_board_year');
            
        return view('admin.board-members.index', compact('years', 'active_year'));
    }

    public function show($year)
    {
        $boardMembers = BoardMember::with('department')->where('year', $year)->latest()->get();
        return view('admin.board-members.show', compact('boardMembers', 'year'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.board-members.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'year' => 'required|integer',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('board-members', 'public');
        }

        BoardMember::create($data);

        return redirect()->route('admin.board-members.index')->with('success', 'Pengurus berhasil ditambahkan.');
    }

    public function edit(BoardMember $boardMember)
    {
        $departments = Department::all();
        return view('admin.board-members.edit', compact('boardMember', 'departments'));
    }

    public function update(Request $request, BoardMember $boardMember)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'year' => 'required|integer',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            if ($boardMember->photo) {
                Storage::disk('public')->delete($boardMember->photo);
            }
            $data['photo'] = $request->file('photo')->store('board-members', 'public');
        }

        $boardMember->update($data);

        return redirect()->route('admin.board-members.index')->with('success', 'Pengurus berhasil diperbarui.');
    }

    public function destroy(BoardMember $boardMember)
    {
        if ($boardMember->photo) {
            Storage::disk('public')->delete($boardMember->photo);
        }
        $boardMember->delete();
        return redirect()->route('admin.board-members.index')->with('success', 'Pengurus berhasil dihapus.');
    }

    public function setActiveYear(Request $request)
    {
        $request->validate([
            'year' => 'required|integer',
        ]);

        \App\Models\Setting::set('active_board_year', $request->year);

        return back()->with('success', 'Tahun kepengurusan ' . $request->year . ' berhasil diaktifkan untuk halaman utama.');
    }
}
