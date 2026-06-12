@extends('layouts.admin')
@section('title', 'Detail Data Voting')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 ">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="font-serif italic text-4xl text-slate-800 dark:text-white mb-1">Data Voting</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Log detail pemilih dan karya yang dipilih.</p>
        </div>
        
    </div>

    <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 overflow-hidden backdrop-blur-md">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800 bg-slate-100 dark:bg-slate-800/50">
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Pemilih (Voter)</th>
                        <th class="px-6 py-4">Karya yang Dipilih</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($votes as $vote)
                    <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300 text-xs">
                            {{ $vote->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-slate-800 dark:text-slate-100 font-medium">{{ $vote->user->name }}</div>
                            <div class="text-slate-500 dark:text-slate-400 text-xs mt-0.5">{{ $vote->user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ str_starts_with($vote->poster->gambar, 'http') ? $vote->poster->gambar : asset('storage/' . $vote->poster->gambar) }}" class="w-10 h-10 rounded-lg object-cover border border-slate-200 dark:border-slate-700">
                                <div>
                                    <div class="text-slate-800 dark:text-slate-100 font-medium line-clamp-1">{{ $vote->poster->judul }}</div>
                                    <div class="text-slate-500 dark:text-slate-400 text-xs mt-0.5 flex items-center gap-1.5">
                                        Oleh: {{ $vote->poster->pembuat }}
                                        @if($vote->poster->is_bidikmisi)
                                            <img src="{{ asset('images/logo2.png') }}" class="h-3 w-auto object-contain" alt="Imadikom" title="Anggota Imadikom">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            Belum ada data voting masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($votes->hasPages())
        <div class="mt-6 px-6 pb-6">
            {{ $votes->links() }}
        </div>
    @endif
</div>
@endsection
