@extends('layouts.admin')
@section('title', 'Detail Data Voting')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 ">
    <div class="mb-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            @if(isset($competition) && $competition)
                <a href="{{ route('admin.competitions.dashboard', $competition) }}" class="text-sm text-slate-500 hover:text-slate-800 dark:hover:text-white mb-3 inline-flex items-center gap-1 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Dashboard Kompetisi
                </a>
                <h1 class="font-serif  text-4xl text-slate-800 dark:text-white mb-1">Data Voting: {{ $competition->name }}</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Log detail pemilih dan karya yang dipilih pada kompetisi ini.</p>
            @else
                <h1 class="font-serif  text-4xl text-slate-800 dark:text-white mb-1">Data Voting (Semua)</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Log detail pemilih dan karya yang dipilih dari seluruh kompetisi.</p>
            @endif
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.votes.index') }}" method="GET" class="flex gap-2">
                <select name="competition_id" onchange="this.form.submit()" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full px-4 py-2 text-sm text-slate-700 dark:text-slate-300 outline-none">
                    <option value="">Semua Kompetisi</option>
                    @foreach($competitions as $comp)
                        <option value="{{ $comp->id }}" {{ request('competition_id') == $comp->id ? 'selected' : '' }}>{{ $comp->year }} - {{ $comp->name }}</option>
                    @endforeach
                </select>
            </form>
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
