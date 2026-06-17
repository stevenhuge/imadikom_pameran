<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Poster;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        // Cek jika bukan participant, redirect ke home
        if ($user->role !== 'participant') {
            return redirect()->route('home');
        }

        // Ambil kompetisi yang pendaftaran terbuka
        $competitions = Competition::where('registration_status', 'open')
            ->where(function($query) {
                $query->whereNull('registration_deadline')
                      ->orWhere('registration_deadline', '>=', now());
            })
            ->get();

        // Ambil karya yang sudah diupload user
        $myPosters = Poster::where('user_id', $user->id)->with('competition')->get();

        $isKipk = \Illuminate\Support\Facades\DB::table('bidikmisi_members')
            ->where('nim', $user->nim)
            ->exists();

        return view('participant.dashboard', compact('competitions', 'myPosters', 'isKipk'));
    }

    public function storeKarya(Request $request, Competition $competition)
    {
        $user = auth()->user();

        // Validasi: Pendaftaran kompetisi harus aktif dan terbuka
        if (!$competition->is_active || $competition->registration_status !== 'open' || ($competition->registration_deadline && $competition->registration_deadline->isPast())) {
            return back()->with('error', 'Pendaftaran untuk kompetisi ini sudah ditutup.');
        }

        // Validasi: 1 peserta hanya bisa upload 1 karya per kompetisi
        $existing = Poster::where('user_id', $user->id)
            ->where('competition_id', $competition->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah mengunggah karya untuk kompetisi ini.');
        }

        // Pengecekan Penerima KIP-K untuk Tipe 1
        if ($competition->eligibility_type === 1) {
            $isKipkAmikom = \Illuminate\Support\Facades\DB::table('bidikmisi_members')
                ->where('nim', $user->nim)
                ->exists();
            if (!$isKipkAmikom) {
                return back()->with('error', 'NIM Anda tidak terdaftar. Kompetisi ini khusus untuk penerima KIP-K Universitas Amikom Yogyakarta.');
            }
        }

        $rules = [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_karya' => 'required|mimes:pdf|max:2048', // PDF max 2MB
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $messages = [];

        // KTM / KIP-K Upload Rules
        if (in_array($competition->eligibility_type, [2, 3, 4])) {
            $rules['file_ktm'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
            $messages['file_ktm.required'] = 'Bukti KTM (Kartu Tanda Mahasiswa) wajib diunggah untuk kompetisi ini.';
        }

        if ($competition->eligibility_type === 3) {
            $rules['file_kipk'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
            $messages['file_kipk.required'] = 'Bukti Penerima KIP-K wajib diunggah untuk kompetisi ini.';
        }

        $request->validate($rules, $messages);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'pembuat' => $user->name,
            'user_id' => $user->id,
            'competition_id' => $competition->id,
            'is_bidikmisi' => in_array($competition->eligibility_type, [1, 3]) ? true : $user->is_bidikmisi,
            'nim' => $user->nim ?? '-',
        ];

        if ($request->hasFile('file_karya')) {
            $data['file_karya'] = $request->file('file_karya')->store('posters/docs', 'public');
        }

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('posters/images', 'public');
        }

        if ($request->hasFile('file_ktm')) {
            $data['file_ktm'] = $request->file('file_ktm')->store('posters/ktm', 'public');
        }

        if ($request->hasFile('file_kipk')) {
            $data['file_kipk'] = $request->file('file_kipk')->store('posters/kipk', 'public');
        }

        Poster::create($data);

        return back()->with('success', 'Pendaftaran & Karya berhasil diunggah! Semoga berhasil.');
    }
}
