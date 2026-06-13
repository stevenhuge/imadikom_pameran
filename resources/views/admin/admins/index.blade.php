@extends('layouts.admin')
@section('title', 'Data Admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 ">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="font-serif italic text-4xl text-slate-800 dark:text-white mb-1">Data Admin</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Kelola akses untuk admin yang dapat mengontrol sistem.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.admins.create') }}" class="text-xs px-4 py-2 rounded-full bg-violet-500 dark:bg-violet-600 text-white font-semibold hover:bg-violet-500 dark:bg-violet-600-light transition">+ Tambah Admin</a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 overflow-hidden backdrop-blur-md p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800 bg-slate-100 dark:bg-slate-800/50">
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Terdaftar</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($admins as $admin)
                    <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-slate-800 dark:text-slate-100 font-medium">{{ $admin->name }}</td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $admin->email }}</td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $admin->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.admins.edit', $admin) }}" class="text-xs px-3 py-1.5 rounded-lg bg-slate-50 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:text-slate-800 dark:text-white transition">Edit</a>
                                <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" onsubmit="return confirm('Hapus data admin ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs px-3 py-1.5 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            Belum ada data admin.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($admins->hasPages())
        <div class="mt-6 px-6 pb-6">
            {{ $admins->links() }}
        </div>
    @endif
</div>
@endsection
