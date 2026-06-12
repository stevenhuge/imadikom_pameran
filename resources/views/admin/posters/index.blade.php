@extends('layouts.app')
@section('title', 'Daftar Poster')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 mt-16">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="font-serif italic text-4xl text-white mb-1">Daftar Poster</h1>
            <p class="text-white/40 text-sm">Kelola semua karya poster yang terdaftar.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="text-xs px-4 py-2 rounded-full border border-white/20 text-white/60 hover:text-white transition">Dashboard</a>
            <a href="{{ route('admin.posters.create') }}" class="text-xs px-4 py-2 rounded-full bg-gold text-ink font-semibold hover:bg-gold/90 transition">+ Tambah Poster</a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-2xl border border-white/8 bg-white/3 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs text-white/30 uppercase tracking-widest border-b border-white/5 bg-white/5">
                        <th class="px-6 py-4">Karya</th>
                        <th class="px-6 py-4">Pembuat</th>
                        <th class="px-6 py-4 text-center">Jumlah Suara</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posters as $poster)
                    <tr class="border-b border-white/5 hover:bg-white/2 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ str_starts_with($poster->gambar, 'http') ? $poster->gambar : asset('storage/' . $poster->gambar) }}" class="w-16 h-16 rounded-xl object-cover border border-white/10">
                                <div>
                                    <h3 class="text-white font-medium">{{ $poster->judul }}</h3>
                                    <p class="text-white/40 text-xs mt-0.5 line-clamp-1">{{ $poster->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-white/70">{{ $poster->pembuat }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center min-w-[2.5rem] h-8 px-3 rounded-full bg-gold/10 text-gold font-bold border border-gold/20">
                                {{ $poster->votes_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.posters.edit', $poster) }}" class="text-xs px-3 py-1.5 rounded-lg bg-white/8 text-white/60 hover:text-white transition">Edit</a>
                                <form action="{{ route('admin.posters.destroy', $poster) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus poster ini secara permanen?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs px-3 py-1.5 rounded-lg bg-red-500/20 text-red-400 hover:bg-red-500/30 transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-white/40">
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
