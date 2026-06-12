<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PosterController extends Controller
{
    public function index()
    {
        $posters = Poster::withCount('votes')->latest()->paginate(10);
        return view('admin.posters.index', compact('posters'));
    }

    public function create()
    {
        return view('admin.posters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'    => 'required|string|max:255',
            'pembuat'  => 'required|string|max:255',
            'nim'      => 'nullable|string|max:20',
            'is_bidikmisi' => 'boolean',
            'deskripsi'=> 'nullable|string',
            'gambar'   => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['is_bidikmisi'] = $request->boolean('is_bidikmisi');

        $path = $request->file('gambar')->store('posters', 'public');
        $validated['gambar'] = $path;

        Poster::create($validated);
        return redirect()->route('admin.posters.index')
            ->with('success', 'Poster berhasil ditambahkan!');
    }

    public function edit(Poster $poster)
    {
        return view('admin.posters.edit', compact('poster'));
    }

    public function update(Request $request, Poster $poster)
    {
        $validated = $request->validate([
            'judul'    => 'required|string|max:255',
            'pembuat'  => 'required|string|max:255',
            'nim'      => 'nullable|string|max:20',
            'is_bidikmisi' => 'boolean',
            'deskripsi'=> 'nullable|string',
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['is_bidikmisi'] = $request->boolean('is_bidikmisi');

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($poster->gambar);
            $validated['gambar'] = $request->file('gambar')->store('posters', 'public');
        } else {
            unset($validated['gambar']);
        }

        $poster->update($validated);
        return redirect()->route('admin.posters.index')
            ->with('success', 'Poster berhasil diperbarui!');
    }

    public function destroy(Poster $poster)
    {
        Storage::disk('public')->delete($poster->gambar);
        $poster->delete();
        return back()->with('success', 'Poster berhasil dihapus!');
    }
}