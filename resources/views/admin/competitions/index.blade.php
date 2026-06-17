@extends('layouts.admin')
@section('title', 'Manajemen Kompetisi')

@section('content')
<div class="p-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <h1 class="text-2xl font-semibold text-slate-800 dark:text-white">Daftar Kompetisi</h1>
        <a href="{{ route('admin.competitions.create') }}" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg text-sm font-medium transition text-center whitespace-nowrap">
            + Tambah Kompetisi
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 bg-emerald-50 text-emerald-600 rounded-lg border border-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 dark:bg-slate-700 text-slate-500 dark:text-slate-300">
                    <tr>
                        <th class="px-6 py-4 font-medium">Nama Kompetisi</th>
                        <th class="px-6 py-4 font-medium">Tahun</th>
                        <th class="px-6 py-4 font-medium">Biaya</th>
                        <th class="px-6 py-4 font-medium text-center">Status Publik</th>
                        <th class="px-6 py-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($competitions as $competition)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-800 dark:text-slate-200">
                            {{ $competition->name }}
                            @if($competition->theme)
                                <span class="block text-xs text-slate-500 dark:text-slate-400 font-normal mt-0.5">{{ $competition->theme }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400 font-semibold">{{ $competition->year }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $competition->fee_type == 'free' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $competition->fee_type == 'free' ? 'Gratis' : 'Berbayar' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($competition->is_active)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400 text-xs font-semibold border border-violet-200 dark:border-violet-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-violet-500 animate-pulse"></span>
                                    Tampil di Publik
                                </span>
                            @else
                                <form action="{{ route('admin.competitions.set-active', $competition) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs font-medium text-slate-500 hover:text-violet-600 dark:text-slate-400 dark:hover:text-violet-400 transition" onclick="return confirm('Jadikan kompetisi ini sebagai yang aktif di halaman pameran utama?');">
                                        Jadikan Aktif
                                    </button>
                                </form>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.competitions.dashboard', $competition) }}" class="inline-flex items-center gap-1 text-white bg-slate-800 hover:bg-slate-900 dark:bg-slate-600 dark:hover:bg-slate-500 px-3 py-1.5 rounded text-xs font-medium transition mr-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                Dashboard
                            </a>
                            <a href="{{ route('admin.competitions.edit', $competition) }}" class="text-blue-500 hover:text-blue-600 hover:underline mr-3 font-medium">Edit</a>
                            <form action="{{ route('admin.competitions.destroy', $competition) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus kompetisi ini beserta seluruh poster dan vote di dalamnya?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-600 hover:underline font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">Belum ada data kompetisi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
