@extends('layouts.admin')
@section('title', 'Daftar Poster')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="mb-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-serif italic text-4xl text-slate-800 dark:text-white mb-1">Daftar Poster</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Kelola semua karya poster yang terdaftar.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="text-xs px-4 py-2 rounded-full border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white transition">Dashboard</a>
            <a href="{{ route('admin.posters.create') }}" class="text-xs px-4 py-2 rounded-full bg-pastel-yellow dark:bg-gold text-ink font-semibold hover:bg-pastel-yellow/90 dark:hover:bg-gold/90 transition shadow-md">+ Tambah Poster</a>
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
                        <th class="px-6 py-4">Pembuat</th>
                        <th class="px-6 py-4 text-center">Jumlah Suara</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($posters as $poster)
                    <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4 min-w-[200px]">
                                <img src="{{ str_starts_with($poster->gambar, 'http') ? $poster->gambar : asset('storage/' . $poster->gambar) }}" class="w-16 h-16 rounded-xl object-cover border border-slate-200 dark:border-slate-700">
                                <div>
                                    <h3 class="text-slate-800 dark:text-white font-medium">{{ $poster->judul }}</h3>
                                    <p class="text-slate-500 dark:text-slate-400 text-xs mt-0.5 line-clamp-1">{{ $poster->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300 whitespace-nowrap">{{ $poster->pembuat }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center min-w-[2.5rem] h-8 px-3 rounded-full bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-400 font-bold border border-violet-200 dark:border-violet-800/50">
                                {{ $poster->votes_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
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
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
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
</div>
@endsection
