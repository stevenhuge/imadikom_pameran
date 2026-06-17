@extends('layouts.app')
@section('title', 'Dashboard Peserta')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900 pt-24 pb-12 px-6">
    <div class="max-w-5xl mx-auto">
        <div class="mb-10">
            <h1 class="font-serif text-4xl text-slate-800 dark:text-white mb-2">Dashboard Peserta</h1>
            <p class="text-slate-600 dark:text-slate-400">Selamat datang, {{ auth()->user()->name }}. Kelola karya Anda untuk kompetisi yang sedang berlangsung.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-400 font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-700 dark:text-red-400 font-medium">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-700 dark:text-red-400 font-medium">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- KARYA SAYA --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 border border-slate-200 dark:border-slate-700 shadow-xl">
                <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Karya Saya
                </h2>

                @if($myPosters->count() > 0)
                    <div class="space-y-4">
                        @foreach($myPosters as $poster)
                        <div class="flex items-start gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-700/50 border border-slate-100 dark:border-slate-700">
                            @if($poster->gambar)
                                <img src="{{ str_starts_with($poster->gambar, 'http') ? $poster->gambar : asset('storage/' . $poster->gambar) }}" class="w-20 h-20 rounded-lg object-cover">
                            @else
                                <div class="w-20 h-20 rounded-lg bg-violet-500/10 flex items-center justify-center text-violet-500 border border-violet-500/20 shrink-0">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold text-slate-800 dark:text-white">{{ $poster->judul }}</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Kompetisi: {{ $poster->competition->year ?? '-' }} - {{ $poster->competition->name ?? '-' }}</p>
                                @if($poster->file_karya)
                                    <a href="{{ asset('storage/' . $poster->file_karya) }}" target="_blank" class="inline-block mt-2 text-xs font-semibold text-violet-600 dark:text-violet-400 hover:underline">Lihat Dokumen PDF &rarr;</a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-700/30 rounded-2xl border border-dashed border-slate-200 dark:border-slate-600">
                        Belum ada karya yang diunggah. Silakan pilih kompetisi di samping untuk mulai berpartisipasi.
                    </div>
                @endif
            </div>

            {{-- KOMPETISI AKTIF --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 border border-slate-200 dark:border-slate-700 shadow-xl">
                <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    Pilih Kompetisi
                </h2>

                @if($competitions->count() > 0)
                    <div x-data="{ selectedComp: null }">
                        <div class="space-y-3 mb-6">
                            @foreach($competitions as $comp)
                                @php
                                    $hasJoined = $myPosters->contains('competition_id', $comp->id);
                                @endphp
                                <label class="block relative cursor-pointer {{ $hasJoined ? 'opacity-50' : '' }}">
                                    <input type="radio" name="comp_id" value="{{ $comp->id }}" class="peer sr-only" @change="selectedComp = {{ $comp->id }}" {{ $hasJoined ? 'disabled' : '' }}>
                                    <div class="p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 peer-checked:border-violet-500 peer-checked:bg-violet-50 dark:peer-checked:bg-violet-900/20 transition flex justify-between items-center">
                                        <div>
                                            <h4 class="font-bold text-slate-800 dark:text-white">{{ $comp->year }} - {{ $comp->name }}</h4>
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Tema: {{ $comp->theme ?? '-' }}</p>
                                            <span class="inline-block mt-2 text-[10px] font-bold px-2 py-0.5 rounded bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400">
                                                @if($comp->eligibility_type === 1)
                                                    Khusus KIP-K Amikom
                                                @elseif($comp->eligibility_type === 2)
                                                    Khusus Mahasiswa Amikom (KTM)
                                                @elseif($comp->eligibility_type === 3)
                                                    Khusus KIP-K PT Seluruh Indonesia (KTM + KIP-K)
                                                @elseif($comp->eligibility_type === 4)
                                                    Nasional / Umum (KTM)
                                                @endif
                                            </span>
                                        </div>
                                        @if($hasJoined)
                                            <span class="text-xs font-bold text-emerald-500 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-1 rounded">Terdaftar</span>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        {{-- Form Upload (Hidden by default, shown when a competition is selected) --}}
                        @foreach($competitions as $comp)
                            <div x-show="selectedComp === {{ $comp->id }}" x-transition x-cloak class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700">
                                <h3 class="font-bold text-slate-800 dark:text-white mb-4">Form Pendaftaran Karya: {{ $comp->name }}</h3>
                                
                                @if($comp->eligibility_type === 1 && !$isKipk)
                                    <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-700 dark:text-red-400 text-sm font-semibold flex items-start gap-2">
                                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        <span>Nim anda tidak terdaftar, kompetisi ini khusus penerima KIP-K Universitas Amikom Yogyakarta.</span>
                                    </div>
                                @else
                                    <form action="{{ route('participant.store_karya', $comp->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-1">Judul Karya</label>
                                            <input type="text" name="judul" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-800 dark:text-white focus:border-violet-500 outline-none transition">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-1">Deskripsi Singkat</label>
                                            <textarea name="deskripsi" rows="3" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 text-slate-800 dark:text-white focus:border-violet-500 outline-none transition"></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-1">File Karya (PDF Maks 2MB)</label>
                                            <input type="file" name="file_karya" accept=".pdf" required class="w-full text-sm text-slate-600 dark:text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-violet-100 dark:file:bg-violet-900/30 file:text-violet-700 dark:file:text-violet-400 hover:file:bg-violet-200 transition cursor-pointer border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-900 p-1.5">
                                        </div>

                                        {{-- KTM File input (Required for 2, 3, 4) --}}
                                        @if(in_array($comp->eligibility_type, [2, 3, 4]))
                                            <div>
                                                <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-1">Bukti KTM / Kartu Tanda Mahasiswa (PDF/JPG/PNG/WEBP Maks 2MB)</label>
                                                <input type="file" name="file_ktm" accept=".pdf,image/*" required class="w-full text-sm text-slate-600 dark:text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-violet-100 dark:file:bg-violet-900/30 file:text-violet-700 dark:file:text-violet-400 hover:file:bg-violet-200 transition cursor-pointer border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-900 p-1.5">
                                            </div>
                                        @endif

                                        {{-- KIPK File input (Required for 3) --}}
                                        @if($comp->eligibility_type === 3)
                                            <div>
                                                <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-1">Bukti Penerima KIP-K (PDF/JPG/PNG/WEBP Maks 2MB)</label>
                                                <input type="file" name="file_kipk" accept=".pdf,image/*" required class="w-full text-sm text-slate-600 dark:text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-violet-100 dark:file:bg-violet-900/30 file:text-violet-700 dark:file:text-violet-400 hover:file:bg-violet-200 transition cursor-pointer border border-slate-200 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-900 p-1.5">
                                            </div>
                                        @endif

                                        <button type="submit" class="w-full py-3 rounded-xl bg-violet-600 hover:bg-violet-700 text-white font-bold transition shadow-md mt-2">Daftar & Kirim Karya</button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-700/30 rounded-2xl border border-dashed border-slate-200 dark:border-slate-600">
                        Saat ini belum ada kompetisi yang sedang berlangsung.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
