<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

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

        if ($this->getCloudinaryUrl()) {
            $validated['gambar'] = $this->uploadToCloudinary($request->file('gambar'));
        } else {
            $validated['gambar'] = $request->file('gambar')->store('posters', 'public');
        }

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
            if ($this->getCloudinaryUrl()) {
                $this->deleteFromCloudinary($poster->gambar);
                $validated['gambar'] = $this->uploadToCloudinary($request->file('gambar'));
            } else {
                Storage::disk('public')->delete($poster->gambar);
                $validated['gambar'] = $request->file('gambar')->store('posters', 'public');
            }
        } else {
            unset($validated['gambar']);
        }

        $poster->update($validated);
        return redirect()->route('admin.posters.index')
            ->with('success', 'Poster berhasil diperbarui!');
    }

    public function destroy(Poster $poster)
    {
        if ($this->getCloudinaryUrl()) {
            $this->deleteFromCloudinary($poster->gambar);
        } else {
            Storage::disk('public')->delete($poster->gambar);
        }
        
        $poster->delete();
        return back()->with('success', 'Poster berhasil dihapus!');
    }

    private function getCloudinaryUrl()
    {
        return env('CLOUDINARY_URL') ?? $_ENV['CLOUDINARY_URL'] ?? $_SERVER['CLOUDINARY_URL'] ?? null;
    }

    private function uploadToCloudinary($file)
    {
        $cloudinaryUrl = $this->getCloudinaryUrl();
        $parsedUrl = parse_url($cloudinaryUrl);
        $apiKey = $parsedUrl['user'];
        $apiSecret = $parsedUrl['pass'];
        $cloudName = $parsedUrl['host'];

        $timestamp = time();
        $signature = sha1("folder=imadikom_posters&timestamp={$timestamp}{$apiSecret}");

        $response = Http::attach(
            'file', file_get_contents($file->getRealPath()), $file->getClientOriginalName()
        )->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
            'api_key' => $apiKey,
            'timestamp' => $timestamp,
            'signature' => $signature,
            'folder' => 'imadikom_posters'
        ]);

        if ($response->successful()) {
            return $response->json('secure_url');
        }

        throw new \Exception('Gagal mengunggah gambar ke Cloudinary: ' . $response->body());
    }

    private function deleteFromCloudinary($url)
    {
        if (!str_contains($url, 'cloudinary.com')) return;

        $cloudinaryUrl = $this->getCloudinaryUrl();
        $parsedUrl = parse_url($cloudinaryUrl);
        $apiKey = $parsedUrl['user'];
        $apiSecret = $parsedUrl['pass'];
        $cloudName = $parsedUrl['host'];

        preg_match('/upload\/(?:v\d+\/)?(.*?)\.[a-zA-Z0-9]+$/', $url, $matches);
        if (!isset($matches[1])) return;
        $publicId = $matches[1];

        $timestamp = time();
        $signature = sha1("public_id={$publicId}&timestamp={$timestamp}{$apiSecret}");

        Http::post("https://api.cloudinary.com/v1_1/{$cloudName}/image/destroy", [
            'api_key' => $apiKey,
            'public_id' => $publicId,
            'timestamp' => $timestamp,
            'signature' => $signature,
        ]);
    }
}