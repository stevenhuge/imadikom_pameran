@extends('layouts.admin')
@section('title', 'Manajemen Pengurus')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-slate-800 dark:text-white">Daftar Pengurus</h1>
        <a href="{{ route('admin.board-members.create') }}" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg text-sm font-medium transition">
            + Tambah Pengurus
        </a>
    </div>

    <div class="mb-6">
        <p class="text-slate-600 dark:text-slate-400">Pilih tahun kepengurusan untuk melihat, menambah, atau mengedit data pengurus.</p>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 bg-emerald-50 text-emerald-600 rounded-lg border border-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 dark:bg-slate-700 text-slate-500 dark:text-slate-300">
                    <tr>
                        <th class="px-6 py-4 font-medium whitespace-nowrap">Tahun Kepengurusan</th>
                        <th class="px-6 py-4 font-medium whitespace-nowrap">Jumlah Pengurus</th>
                        <th class="px-6 py-4 font-medium text-center whitespace-nowrap">Status Utama</th>
                        <th class="px-6 py-4 font-medium text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($years as $row)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-800 dark:text-slate-200 whitespace-nowrap">Tahun {{ $row->year }}</td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400 whitespace-nowrap">{{ $row->total_members }} Orang</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            @if(isset($active_year) && $active_year == $row->year)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400 text-xs font-semibold border border-violet-200 dark:border-violet-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-violet-500 animate-pulse"></span>
                                    Aktif di Beranda
                                </span>
                            @else
                                <form action="{{ route('admin.board-members.set-active-year') }}" method="POST" class="inline-block">
                                    @csrf
                                    <input type="hidden" name="year" value="{{ $row->year }}">
                                    <button type="submit" class="text-xs font-medium text-slate-500 hover:text-violet-600 dark:text-slate-400 dark:hover:text-violet-400 transition" onclick="return confirm('Tampilkan struktur pengurus tahun {{ $row->year }} di halaman beranda?');">
                                        Jadikan Aktif
                                    </button>
                                </form>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <a href="{{ route('admin.board-members.show', $row->year) }}" class="inline-flex items-center gap-1 text-violet-600 hover:text-violet-700 font-medium bg-violet-50 hover:bg-violet-100 dark:bg-violet-500/10 dark:hover:bg-violet-500/20 px-3 py-1.5 rounded-lg transition">
                                Lihat Detail
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada data tahun kepengurusan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
