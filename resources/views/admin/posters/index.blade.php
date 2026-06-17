@extends('layouts.admin')
@section('title', 'Daftar Poster')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10" x-data="{ showPreviewModal: false, activePoster: {} }">
    <div class="mb-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h1 class="font-serif  text-4xl text-slate-800 dark:text-white mb-1">Daftar Poster</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Kelola semua karya poster yang terdaftar.</p>
        </div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full md:w-auto">
            <form action="{{ route('admin.posters.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
                <select name="competition_id" onchange="this.form.submit()" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full px-4 py-2 text-sm text-slate-700 dark:text-slate-300 outline-none w-full sm:w-auto">
                    <option value="">Semua Kompetisi</option>
                    @foreach($competitions as $comp)
                        <option value="{{ $comp->id }}" {{ request('competition_id') == $comp->id ? 'selected' : '' }}>{{ $comp->year }} - {{ $comp->name }}</option>
                    @endforeach
                </select>
            </form>
            <a href="{{ route('admin.posters.create', ['competition_id' => request('competition_id')]) }}" class="text-xs px-4 py-2.5 rounded-full bg-pastel-yellow dark:bg-gold text-ink font-semibold hover:bg-pastel-yellow/90 dark:hover:bg-gold/90 transition shadow-md whitespace-nowrap">+ Tambah Poster</a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 overflow-hidden backdrop-blur-md">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-widest border-b border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800/50">
                        <th class="px-6 py-4">Karya</th>
                        <th class="px-6 py-4">Kompetisi</th>
                        <th class="px-6 py-4">Pembuat</th>
                        <th class="px-6 py-4">Dokumen</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Jumlah Suara</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($posters as $poster)
                    <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4 min-w-[200px] cursor-pointer group/item" @click="activePoster = {
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
                                    <img src="{{ str_starts_with($poster->gambar, 'http') ? $poster->gambar : asset('storage/' . $poster->gambar) }}" class="w-16 h-16 rounded-xl object-cover border border-slate-200 dark:border-slate-700 group-hover/item:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-16 h-16 rounded-xl bg-violet-500/10 flex items-center justify-center text-violet-500 border border-violet-500/20 shrink-0">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-slate-800 dark:text-white font-medium group-hover/item:text-violet-600 dark:group-hover/item:text-violet-400 transition-colors duration-200">{{ $poster->judul }}</h3>
                                    <p class="text-slate-500 dark:text-slate-400 text-xs mt-0.5 line-clamp-1">{{ $poster->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($poster->competition)
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 whitespace-nowrap">
                                    {{ $poster->competition->year }} - {{ $competition->name ?? $poster->competition->name }}
                                </span>
                            @else
                                <span class="text-xs text-slate-400 italic">Tanpa Kompetisi</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300 whitespace-nowrap">
                            <div>{{ $poster->pembuat }}</div>
                            <div class="text-[10px] text-slate-400 dark:text-slate-500">NIM: {{ $poster->nim ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col gap-1">
                                @if($poster->file_karya)
                                    <a href="{{ asset('storage/' . $poster->file_karya) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-violet-600 dark:text-violet-400 hover:underline">
                                        📄 Karya (PDF)
                                    </a>
                                @endif
                                @if($poster->file_ktm)
                                    <a href="{{ asset('storage/' . $poster->file_ktm) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-slate-600 dark:text-slate-300 hover:underline">
                                        💳 KTM
                                    </a>
                                @endif
                                @if($poster->file_kipk)
                                    <a href="{{ asset('storage/' . $poster->file_kipk) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-emerald-600 dark:text-emerald-400 hover:underline">
                                        🎓 Bukti KIP-K
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($poster->is_visible)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                    Tampil
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-500 dark:bg-slate-700 dark:text-slate-400 border border-slate-200 dark:border-slate-600">
                                    Disembunyikan
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center min-w-[2.5rem] h-8 px-3 rounded-full bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-400 font-bold border border-violet-200 dark:border-violet-800/50">
                                {{ $poster->votes_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.posters.toggle-visibility', $poster) }}" method="POST" class="inline">
                                    @csrf
                                    @if($poster->is_visible)
                                        <button type="submit" class="text-xs px-3 py-1.5 rounded-lg bg-yellow-100 dark:bg-yellow-500/20 text-yellow-700 dark:text-yellow-400 hover:bg-yellow-200 dark:hover:bg-yellow-500/30 transition">Sembunyikan</button>
                                    @else
                                        <button type="submit" class="text-xs px-3 py-1.5 rounded-lg bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-200 dark:hover:bg-emerald-500/30 transition">Tampilkan</button>
                                    @endif
                                </form>
                                <a href="{{ route('admin.posters.edit', $poster) }}" class="text-xs px-3 py-1.5 rounded-lg bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition">Edit</a>
                                <form action="{{ route('admin.posters.destroy', $poster) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus poster ini secara permanen?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs px-3 py-1.5 rounded-lg bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-500/30 transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            Belum ada poster yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($posters->hasPages())
        <div class="mt-6 px-6 pb-6">
            {{ $posters->links() }}
        </div>
    @endif
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
