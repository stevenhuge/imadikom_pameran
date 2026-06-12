@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="mb-10">
        <h1 class="font-serif italic text-4xl text-slate-800 dark:text-white mb-1">Dashboard Admin</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Pantau statistik voting secara real-time.</p>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-12">
        @foreach([
            ['label' => 'Total Voter', 'value' => $stats['total_voters'], 'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>', 'color' => 'bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-white'],
            ['label' => 'Total Poster', 'value' => $stats['total_posters'], 'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>', 'color' => 'bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-white'],
            ['label' => 'Total Suara', 'value' => $stats['total_votes'], 'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>', 'color' => 'bg-slate-50 dark:bg-slate-800 text-violet-600 dark:text-violet-400-600 dark:text-gold'],
            ['label' => 'Karya Imadikom', 'value' => $stats['total_bidikmisi'], 'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>', 'color' => 'bg-slate-50 dark:bg-slate-800 text-violet-600 dark:text-violet-400-light'],
        ] as $stat)
        <div class="rounded-2xl {{ $stat['color'] }} p-6 backdrop-blur-md transition-all hover:bg-slate-100 dark:bg-white/10 shadow-lg">
            <div class="text-3xl mb-4">{!! $stat['icon'] !!}</div>
            <div class="font-serif italic text-5xl mb-1">{{ $stat['value'] }}</div>
            <div class="text-slate-500 dark:text-slate-400 text-sm uppercase tracking-widest">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- VOTING SETTINGS --}}
    <div class="rounded-2xl bg-slate-50 dark:bg-slate-800 overflow-hidden shadow-xl backdrop-blur-md mb-8 p-6">
        <h2 class="font-semibold text-slate-800 dark:text-white mb-4"><svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>Pengaturan Voting</h2>
        <form action="{{ route('admin.settings.update') }}" method="POST" class="flex flex-col md:flex-row gap-6 items-end">
            @csrf
            <div class="w-full md:w-1/3">
                <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Status Voting</label>
                <select name="voting_status" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-slate-800 dark:text-white focus:border-violet-400 outline-none transition">
                    <option value="open" {{ $voting_status === 'open' ? 'selected' : '' }}>🟢 Dibuka</option>
                    <option value="closed" {{ $voting_status === 'closed' ? 'selected' : '' }}>🔴 Ditutup</option>
                </select>
            </div>
            <div class="w-full md:w-1/3">
                <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Batas Waktu (Deadline)</label>
                <input type="datetime-local" name="voting_deadline" value="{{ $voting_deadline }}" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-slate-800 dark:text-white focus:border-violet-400 outline-none transition">
            </div>
            <div class="w-full md:w-1/3">
                <button type="submit" class="w-full py-2.5 rounded-xl bg-violet-500 text-white font-semibold hover:bg-violet-600 transition shadow-md">Simpan Pengaturan</button>
            </div>
        </form>
    </div>

    {{-- LEADERBOARD --}}
    <div class="rounded-2xl bg-slate-50 dark:bg-slate-800 overflow-hidden shadow-xl backdrop-blur-md">
        <div class="px-6 py-5 flex items-center justify-between">
            <h2 class="font-semibold text-slate-800 dark:text-white"><svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>Leaderboard Karya</h2>
            <a href="{{ route('admin.posters.create') }}" class="text-xs px-4 py-2 rounded-full bg-pastel-yellow dark:bg-gold text-ink font-semibold hover:bg-pastel-yellow dark:bg-gold/90 transition shadow-md">+ Tambah Poster</a>
        </div>
        <table class="w-full">
            <thead>
                <tr class="text-left text-xs text-slate-500 dark:text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800">
                    <th class="px-6 py-4">Rank</th>
                    <th class="px-6 py-4">Karya</th>
                    <th class="px-6 py-4">Pembuat</th>
                    <th class="px-6 py-4 text-right">Suara</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaderboard as $index => $poster)
                <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:bg-white/5 transition-colors">
                    <td class="px-6 py-4">
                        <span class="w-7 h-7 inline-flex items-center justify-center rounded-full text-xs font-bold
                            {{ $index === 0 ? 'bg-yellow-400 text-yellow-900' : ($index === 1 ? 'bg-slate-300 text-slate-900' : ($index === 2 ? 'bg-amber-600 text-slate-800 dark:text-white' : 'bg-slate-100 dark:bg-white/10 text-slate-500 dark:text-slate-400')) }}">
                            {{ $index + 1 }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('storage/' . $poster->gambar) }}" class="w-10 h-10 rounded-lg object-cover">
                            <span class="text-slate-800 dark:text-white text-sm font-medium">{{ $poster->judul }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-600 dark:text-slate-300 text-sm">
                        <div class="flex items-center gap-2">
                            {{ $poster->pembuat }}
                            @if($poster->is_bidikmisi)
                                <img src="{{ asset('images/logo2.png') }}" class="h-3.5 w-auto object-contain" alt="Imadikom" title="Anggota Imadikom">
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="text-violet-600 dark:text-violet-400-600 dark:text-gold font-bold">{{ $poster->votes_count }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.posters.edit', $poster) }}" class="text-xs px-3 py-1.5 rounded-lg bg-slate-50 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:text-slate-800 dark:text-white transition">Edit</a>
                            <form action="{{ route('admin.posters.destroy', $poster) }}" method="POST" onsubmit="return confirm('Hapus poster ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs px-3 py-1.5 rounded-lg bg-red-500/20 text-red-400 hover:bg-red-500/30 transition">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection