@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="mb-10">
        <h1 class="font-serif  text-4xl text-slate-800 dark:text-white mb-1">Dashboard Admin</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Rekapitulasi statistik seluruh kompetisi secara real-time.</p>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-12">
        @foreach([
            ['label' => 'Total Kompetisi', 'value' => $stats['total_competitions'], 'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>', 'color' => 'bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-white'],
            ['label' => 'Total Pengguna', 'value' => $stats['total_voters'], 'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>', 'color' => 'bg-slate-50 dark:bg-slate-800 text-violet-600 dark:text-violet-400'],
            ['label' => 'Total Suara', 'value' => $stats['total_votes'], 'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>', 'color' => 'bg-slate-50 dark:bg-slate-800 text-pastel-yellow dark:text-gold'],
        ] as $stat)
        <div class="rounded-2xl {{ $stat['color'] }} p-6 backdrop-blur-md transition-all hover:bg-slate-100 dark:bg-white/10 shadow-lg">
            <div class="text-3xl mb-4">{!! $stat['icon'] !!}</div>
            <div class="font-serif  text-5xl mb-1">{{ $stat['value'] }}</div>
            <div class="text-slate-500 dark:text-slate-400 text-sm uppercase tracking-widest">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- COMPETITIONS LIST --}}
        <div class="lg:col-span-2 rounded-2xl bg-slate-50 dark:bg-slate-800 overflow-hidden shadow-xl backdrop-blur-md flex flex-col">
            <div class="px-6 py-5 flex items-center justify-between border-b border-slate-100 dark:border-slate-700">
                <h2 class="font-semibold text-slate-800 dark:text-white"><svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>Kompetisi Terbaru</h2>
                <a href="{{ route('admin.competitions.create') }}" class="text-xs px-4 py-2 rounded-full bg-pastel-yellow dark:bg-gold text-ink font-semibold hover:bg-pastel-yellow/90 dark:hover:bg-gold/90 transition shadow-md">+ Tambah</a>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left text-xs text-slate-500 dark:text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800 bg-slate-100 dark:bg-slate-800/50">
                            <th class="px-6 py-4 font-medium">Tahun</th>
                            <th class="px-6 py-4 font-medium">Nama Kompetisi</th>
                            <th class="px-6 py-4 font-medium">Status Voting</th>
                            <th class="px-6 py-4 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($recent_competitions as $comp)
                        <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:bg-white/5 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-800 dark:text-slate-200">{{ $comp->year }}</td>
                            <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                                {{ $comp->name }}
                                @if($comp->is_active)
                                    <span class="ml-2 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400 border border-violet-200 dark:border-violet-800">Publik</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($comp->voting_status == 'open')
                                    <span class="text-emerald-500 font-medium">Buka</span>
                                @else
                                    <span class="text-red-500 font-medium">Tutup</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.competitions.dashboard', $comp) }}" class="text-violet-600 dark:text-violet-400 font-medium hover:underline">Kelola &rarr;</a>
                            </td>
                        </tr>
                        @endforeach
                        @if($recent_competitions->isEmpty())
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">Belum ada kompetisi.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 border-t border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/80 text-center">
                <a href="{{ route('admin.competitions.index') }}" class="text-xs text-violet-600 dark:text-violet-400 hover:text-violet-700 dark:hover:text-violet-300 font-medium transition">Lihat Semua Kompetisi &rarr;</a>
            </div>
        </div>

        {{-- ADMINS LIST --}}
        <div class="lg:col-span-1 rounded-2xl bg-slate-50 dark:bg-slate-800 overflow-hidden shadow-xl backdrop-blur-md flex flex-col">
            <div class="px-6 py-5 flex items-center justify-between border-b border-slate-100 dark:border-slate-700">
                <h2 class="font-semibold text-slate-800 dark:text-white"><svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>Tim Admin</h2>
                @if(auth()->user()->isSuperadmin())
                <a href="{{ route('admin.admins.index') }}" class="text-xs text-slate-500 hover:text-violet-600 dark:text-slate-400 dark:hover:text-violet-400 transition">Kelola</a>
                @endif
            </div>
            <div class="p-6 flex-1 overflow-y-auto max-h-[400px]">
                <ul class="space-y-4">
                    @foreach($admins as $admin)
                    <li class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700/50 transition border border-transparent hover:border-slate-200 dark:hover:border-slate-600">
                        <div class="w-10 h-10 rounded-full bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center text-violet-600 dark:text-violet-400 font-bold text-sm border border-violet-200 dark:border-violet-800">
                            {{ substr($admin->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800 dark:text-white truncate">{{ $admin->name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $admin->email }}</p>
                        </div>
                        @if($admin->role === 'superadmin')
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-200 dark:border-amber-800">Superadmin</span>
                        @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-200 text-slate-800 dark:bg-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-600">Admin</span>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
