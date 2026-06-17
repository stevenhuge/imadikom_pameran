@extends('layouts.admin')
@section('title', 'Manajemen Kegiatan')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-slate-800 dark:text-white">Daftar Kegiatan</h1>
        <a href="{{ route('admin.activities.create') }}" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg text-sm font-medium transition">
            + Tambah Kegiatan
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 bg-emerald-50 text-emerald-600 rounded-lg border border-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto"><table class="w-full whitespace-nowrap text-left text-sm">
            <thead class="bg-slate-50 dark:bg-slate-700 text-slate-500 dark:text-slate-300">
                <tr>
                    <th class="px-6 py-3 font-medium">Foto Kegiatan</th>
                    <th class="px-6 py-3 font-medium">Nama Kegiatan</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse($activities as $activity)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                    <td class="px-6 py-4">
                        @if($activity->photo)
                            <img src="{{ asset('storage/' . $activity->photo) }}" class="w-32 h-20 object-cover rounded-lg border border-slate-200" alt="{{ $activity->name }}">
                        @else
                            <div class="w-32 h-20 rounded-lg bg-slate-100 dark:bg-slate-600 flex items-center justify-center text-slate-400">Tanpa Foto</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-slate-800 dark:text-slate-200">{{ $activity->name }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.activities.edit', $activity) }}" class="text-blue-500 hover:underline mr-3">Edit</a>
                        <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus kegiatan ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center text-slate-500">Belum ada kegiatan.</td>
                </tr>
                @endforelse
            </tbody>
        </table></div>
    </div>
</div>
@endsection

