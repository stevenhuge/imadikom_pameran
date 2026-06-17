@extends('layouts.admin')
@section('title', 'Edit Kegiatan')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.activities.index') }}" class="text-sm text-slate-500 hover:text-slate-800 dark:hover:text-white mb-2 inline-block">← Kembali</a>
        <h1 class="text-2xl font-semibold text-slate-800 dark:text-white">Edit Kegiatan</h1>
    </div>

    <form action="{{ route('admin.activities.update', $activity) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-slate-200 dark:border-slate-700">
        @csrf @method('PUT')
        
        @if($activity->photo)
        <div class="mb-6 flex justify-center">
            <img src="{{ asset('storage/' . $activity->photo) }}" class="w-48 h-32 object-cover rounded-lg border-4 border-slate-100 dark:border-slate-700 shadow-md">
        </div>
        @endif

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Kegiatan</label>
            <input type="text" name="name" value="{{ old('name', $activity->name) }}" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-violet-500 bg-transparent dark:text-white">
            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Foto Kegiatan (Opsional)</label>
            <input type="file" name="photo" accept="image/*" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-violet-500 bg-transparent text-slate-500 dark:text-slate-400">
            <span class="text-xs text-slate-500 block mt-1">Biarkan kosong jika tidak ingin mengubah foto.</span>
            @error('photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg text-sm font-medium transition w-full">Update Kegiatan</button>
    </form>
</div>
@endsection
