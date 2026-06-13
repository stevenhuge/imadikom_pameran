@extends('layouts.admin')
@section('title', 'Tambah Admin')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="font-serif italic text-4xl text-slate-800 dark:text-white mb-1">Tambah Admin Baru</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Tambahkan akses admin baru untuk sistem.</p>
        </div>
        <a href="{{ route('admin.admins.index') }}" class="text-xs px-4 py-2 rounded-full border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white transition">Kembali</a>
    </div>

    <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 p-6 backdrop-blur-md">
        <form action="{{ route('admin.admins.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama Admin</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:border-violet-400 outline-none transition @error('name') border-red-500 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:border-violet-400 outline-none transition @error('email') border-red-500 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Password</label>
                <input type="password" name="password" required
                       class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:border-violet-400 outline-none transition @error('password') border-red-500 @enderror">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                       class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:border-violet-400 outline-none transition">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="text-sm px-6 py-3 rounded-xl bg-violet-500 dark:bg-violet-600 text-white font-semibold hover:bg-violet-600 dark:hover:bg-violet-500 transition shadow-md">
                    Simpan Admin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
