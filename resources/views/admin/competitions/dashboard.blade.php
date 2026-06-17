@extends('layouts.admin')
@section('title', 'Dashboard Kompetisi: ' . $competition->name)

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8" x-data="{ showPreviewModal: false, activePoster: {} }">
    <div class="mb-8">
        <a href="{{ route('admin.competitions.index') }}" class="text-sm text-slate-500 hover:text-slate-800 dark:hover:text-white mb-3 inline-flex items-center gap-1 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Kompetisi
        </a>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <h1 class="font-serif text-3xl md:text-4xl text-slate-800 dark:text-white">{{ $competition->name }}</h1>
                    @if($competition->is_active)
                        <span class="px-2 py-1 rounded bg-violet-100 text-violet-700 text-[10px] font-bold uppercase tracking-widest border border-violet-200">Publik</span>
                    @endif
                </div>
                <p class="text-slate-500 dark:text-slate-400 font-medium">Tahun: {{ $competition->year }} &bull; Tema: {{ $competition->theme ?? '-' }} &bull; Biaya: {{ $competition->fee_type == 'free' ? 'Gratis' : 'Berbayar' }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.posters.index') }}?competition_id={{ $competition->id }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 dark:bg-white dark:hover:bg-slate-100 dark:text-slate-900 text-white rounded-xl text-sm font-bold transition shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Kelola Karya
                </a>
                <a href="{{ route('admin.votes.index') }}?competition_id={{ $competition->id }}" class="px-5 py-2.5 bg-violet-600 hover:bg-violet-700 text-white rounded-xl text-sm font-bold transition shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Detail Voting
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 bg-emerald-50 text-emerald-600 rounded-lg border border-emerald-200 font-medium">
            {{ session('success') }}
        </div>
    @endif

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        @foreach([
            ['label' => 'Total Poster', 'value' => $stats['total_posters'], 'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>', 'color' => 'bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-white'],
            ['label' => 'Total Suara', 'value' => $stats['total_votes'], 'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>', 'color' => 'bg-slate-50 dark:bg-slate-800 text-violet-600 dark:text-violet-400'],
            ['label' => 'Karya Imadikom', 'value' => $stats['total_bidikmisi'], 'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>', 'color' => 'bg-slate-50 dark:bg-slate-800 text-pastel-yellow dark:text-gold'],
        ] as $stat)
        <div class="rounded-2xl {{ $stat['color'] }} p-6 border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div>
                <div class="font-serif text-4xl mb-1">{{ $stat['value'] }}</div>
                <div class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-widest">{{ $stat['label'] }}</div>
            </div>
            <div class="opacity-80">{!! $stat['icon'] !!}</div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- LEADERBOARD --}}
        <div class="lg:col-span-2 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm flex flex-col">
            <div class="px-6 py-5 flex items-center justify-between border-b border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                <h2 class="font-semibold text-slate-800 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    Leaderboard {{ $competition->name }}
                </h2>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left text-xs text-slate-500 dark:text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800">
                            <th class="px-6 py-4 font-medium">Rank</th>
                            <th class="px-6 py-4 font-medium">Karya</th>
                            <th class="px-6 py-4 font-medium">Pembuat</th>
                            <th class="px-6 py-4 font-medium text-right">Suara</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($leaderboard as $index => $poster)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="w-8 h-8 inline-flex items-center justify-center rounded-full text-xs font-bold
                                    {{ $index === 0 ? 'bg-yellow-400 text-yellow-900 shadow-[0_0_10px_rgba(250,204,21,0.5)]' : ($index === 1 ? 'bg-slate-300 text-slate-900' : ($index === 2 ? 'bg-amber-600 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400')) }}">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3 cursor-pointer group/item" @click="activePoster = {
                                    judul: '{{ addslashes($poster->judul) }}',
                                    pembuat: '{{ addslashes($poster->pembuat) }}',
                                    nim: '{{ $poster->nim ?? '-' }}',
                                    is_bidikmisi: {{ $poster->is_bidikmisi ? 'true' : 'false' }},
                                    deskripsi: '{{ addslashes(preg_replace('/\s+/', ' ', $poster->deskripsi ?? 'Tidak ada deskripsi')) }}',
                                    gambar: '{{ $poster->gambar ? (str_starts_with($poster->gambar, 'http') ? $poster->gambar : asset('storage/' . $poster->gambar)) : '' }}',
                                    file_karya: '{{ $poster->file_karya ? asset('storage/' . $poster->file_karya) : '' }}',
                                    file_ktm: '{{ $poster->file_ktm ? asset('storage/' . $poster->file_ktm) : '' }}',
                                    file_kipk: '{{ $poster->file_kipk ? asset('storage/' . $poster->file_kipk) : '' }}'
                                }; showPreviewModal = true">
                                    @if($poster->gambar)
                                        <img src="{{ str_starts_with($poster->gambar, 'http') ? $poster->gambar : asset('storage/' . $poster->gambar) }}" class="w-12 h-12 rounded-lg object-cover border border-slate-200 dark:border-slate-700 group-hover/item:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-violet-500/10 flex items-center justify-center text-violet-500 border border-violet-500/20 shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    <span class="text-slate-800 dark:text-white font-bold group-hover/item:text-violet-600 dark:group-hover/item:text-violet-400 transition-colors duration-200">{{ $poster->judul }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300 font-medium">
                                <div class="flex items-center gap-2">
                                    {{ $poster->pembuat }}
                                    @if($poster->is_bidikmisi)
                                        <span title="Anggota IMADIKOM" class="w-2 h-2 rounded-full bg-violet-500"></span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-violet-600 dark:text-violet-400 font-black text-xl">{{ $poster->votes_count }}</span>
                            </td>
                        </tr>
                        @endforeach
                        @if($leaderboard->isEmpty())
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">Belum ada karya atau suara pada kompetisi ini.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- SETTINGS --}}
        <div class="lg:col-span-1 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col p-6">
            <h2 class="font-semibold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Pengaturan Kompetisi
            </h2>
            <form action="{{ route('admin.competitions.settings', $competition) }}" method="POST" class="flex flex-col gap-5 flex-1">
                @csrf
                
                {{-- VOTING SETTINGS --}}
                <div class="space-y-4">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pengaturan Voting</h3>
                    <div>
                        <label class="block text-xs text-slate-600 dark:text-slate-400 mb-1.5 font-medium">Status Voting</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="voting_status" value="open" class="peer sr-only" {{ $competition->voting_status === 'open' ? 'checked' : '' }}>
                                <div class="py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 text-center text-xs font-bold text-slate-600 dark:text-slate-300 peer-checked:text-emerald-700 dark:peer-checked:text-emerald-400 transition">Buka</div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="voting_status" value="closed" class="peer sr-only" {{ $competition->voting_status === 'closed' ? 'checked' : '' }}>
                                <div class="py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20 text-center text-xs font-bold text-slate-600 dark:text-slate-300 peer-checked:text-red-700 dark:peer-checked:text-red-400 transition">Tutup</div>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-600 dark:text-slate-400 mb-1.5 font-medium">Batas Waktu (Deadline) Voting</label>
                        <input type="datetime-local" name="voting_deadline" value="{{ $competition->voting_deadline ? $competition->voting_deadline->format('Y-m-d\TH:i') : '' }}" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-800 dark:text-white focus:border-violet-500 outline-none transition">
                    </div>
                </div>

                {{-- REGISTRATION SETTINGS --}}
                <div class="space-y-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pengaturan Pendaftaran</h3>
                    <div>
                        <label class="block text-xs text-slate-600 dark:text-slate-400 mb-1.5 font-medium">Status Pendaftaran</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="registration_status" value="open" class="peer sr-only" {{ $competition->registration_status === 'open' ? 'checked' : '' }}>
                                <div class="py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 text-center text-xs font-bold text-slate-600 dark:text-slate-300 peer-checked:text-emerald-700 dark:peer-checked:text-emerald-400 transition">Buka</div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="registration_status" value="closed" class="peer sr-only" {{ $competition->registration_status === 'closed' ? 'checked' : '' }}>
                                <div class="py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20 text-center text-xs font-bold text-slate-600 dark:text-slate-300 peer-checked:text-red-700 dark:peer-checked:text-red-400 transition">Tutup</div>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-600 dark:text-slate-400 mb-1.5 font-medium">Batas Waktu (Deadline) Pendaftaran</label>
                        <input type="datetime-local" name="registration_deadline" value="{{ $competition->registration_deadline ? $competition->registration_deadline->format('Y-m-d\TH:i') : '' }}" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-800 dark:text-white focus:border-violet-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-600 dark:text-slate-400 mb-1.5 font-medium">Kategori Kelayakan (Eligibility)</label>
                        <select name="eligibility_type" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-800 dark:text-white focus:border-violet-500 outline-none transition">
                            <option value="1" {{ $competition->eligibility_type == 1 ? 'selected' : '' }}>Khusus penerima KIP-K Universitas Amikom Yogyakarta</option>
                            <option value="2" {{ $competition->eligibility_type == 2 ? 'selected' : '' }}>Khusus Mahasiswa Universitas Amikom Yogyakarta</option>
                            <option value="3" {{ $competition->eligibility_type == 3 ? 'selected' : '' }}>Khusus penerima KIP-K perguruan tinggi di Indonesia</option>
                            <option value="4" {{ $competition->eligibility_type == 4 ? 'selected' : '' }}>Seluruh perguruan tinggi yang terdaftar di pemerintah (Nasional/Umum)</option>
                        </select>
                    </div>
                </div>

                <div class="mt-auto pt-6 border-t border-slate-100 dark:border-slate-700">
                    <button type="submit" class="w-full py-3 rounded-xl bg-violet-600 hover:bg-violet-700 text-white font-bold transition shadow-md">Simpan Pengaturan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL PREVIEW POSTER --}}
    <div x-show="showPreviewModal" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-transition x-cloak>
        <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-3xl w-full max-h-[90vh] overflow-hidden border border-slate-200 dark:border-slate-700 shadow-2xl flex flex-col" @click.away="showPreviewModal = false">
            {{-- Modal Header --}}
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50 dark:bg-slate-800/50">
                <h3 class="font-bold text-slate-800 dark:text-white truncate" x-text="activePoster.judul">Detail Karya</h3>
                <button @click="showPreviewModal = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            {{-- Modal Body --}}
            <div class="p-6 overflow-y-auto flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Left Side: Image Cover --}}
                <div class="flex flex-col items-center justify-center bg-slate-50 dark:bg-slate-900 rounded-2xl p-4 border border-slate-100 dark:border-slate-800">
                    <template x-if="activePoster.gambar">
                        <img :src="activePoster.gambar" class="max-w-full max-h-[45vh] rounded-xl object-contain shadow-md">
                    </template>
                    <template x-if="!activePoster.gambar">
                        <div class="w-full aspect-square max-h-[35vh] rounded-xl bg-violet-500/10 flex flex-col items-center justify-center text-violet-500 border border-violet-500/20 p-8 text-center">
                            <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            <span class="text-sm font-semibold">Tidak Ada Cover (Hanya PDF)</span>
                        </div>
                    </template>
                </div>
                
                {{-- Right Side: Info --}}
                <div class="flex flex-col justify-between">
                    <div class="space-y-4">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-0.5">Pembuat / Peserta</span>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-800 dark:text-white text-lg" x-text="activePoster.pembuat">Nama Peserta</span>
                                <template x-if="activePoster.is_bidikmisi">
                                    <span class="px-2 py-0.5 rounded bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400 text-[10px] font-bold uppercase tracking-wider">KIP-K</span>
                                </template>
                            </div>
                        </div>
                        
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-0.5">NIM</span>
                            <span class="font-semibold text-slate-700 dark:text-slate-300" x-text="activePoster.nim">-</span>
                        </div>
                        
                        <div class="flex flex-wrap gap-3">
                            <template x-if="activePoster.file_ktm">
                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Bukti KTM</span>
                                    <a :href="activePoster.file_ktm" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-700/50 text-slate-700 dark:text-slate-200 text-xs font-semibold hover:bg-slate-200 dark:hover:bg-slate-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        Buka KTM
                                    </a>
                                </div>
                            </template>

                            <template x-if="activePoster.file_kipk">
                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Bukti KIP-K</span>
                                    <a :href="activePoster.file_kipk" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-700/50 text-slate-700 dark:text-slate-200 text-xs font-semibold hover:bg-slate-200 dark:hover:bg-slate-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        Buka Bukti KIP-K
                                    </a>
                                </div>
                            </template>
                        </div>
                        
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-0.5">Deskripsi Karya</span>
                            <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed whitespace-pre-line" x-text="activePoster.deskripsi">Deskripsi karya...</p>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-700 flex flex-col gap-2">
                        <template x-if="activePoster.file_karya">
                            <a :href="activePoster.file_karya" target="_blank" class="w-full py-2.5 rounded-xl bg-violet-600 hover:bg-violet-700 text-white font-bold text-center transition shadow-md flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Lihat Dokumen PDF
                            </a>
                        </template>
                        <button @click="showPreviewModal = false" class="w-full py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 font-bold hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
