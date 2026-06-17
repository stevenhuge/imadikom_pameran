@extends('layouts.admin')
@section('title', 'Manajemen Departemen')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-slate-800 dark:text-white">Daftar Departemen</h1>
        <a href="{{ route('admin.departments.create') }}" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg text-sm font-medium transition">
            + Tambah Departemen
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
                    <th class="px-6 py-3 font-medium">ID</th>
                    <th class="px-6 py-3 font-medium">Nama Departemen</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse($departments as $dept)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                    <td class="px-6 py-4">{{ $dept->id }}</td>
                    <td class="px-6 py-4 font-medium text-slate-800 dark:text-slate-200">{{ $dept->name }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.departments.edit', $dept) }}" class="text-blue-500 hover:underline mr-3">Edit</a>
                        <form action="{{ route('admin.departments.destroy', $dept) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus departemen ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center text-slate-500">Belum ada departemen.</td>
                </tr>
                @endforelse
            </tbody>
        </table></div>
    </div>
</div>
@endsection

