@extends('layouts.admin')
@section('title', 'Edit Pengurus')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.board-members.index') }}" class="text-sm text-slate-500 hover:text-slate-800 dark:hover:text-white mb-2 inline-block">← Kembali</a>
        <h1 class="text-2xl font-semibold text-slate-800 dark:text-white">Edit Pengurus</h1>
    </div>

    <form action="{{ route('admin.board-members.update', $boardMember) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-slate-200 dark:border-slate-700">
        @csrf @method('PUT')
        
        @if($boardMember->photo)
        <div class="mb-6 flex justify-center">
            <img src="{{ asset('storage/' . $boardMember->photo) }}" class="w-24 h-24 object-cover rounded-full border-4 border-slate-100 dark:border-slate-700 shadow-md">
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $boardMember->name) }}" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-violet-500 bg-transparent dark:text-white">
                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Jabatan</label>
                <input type="text" name="position" value="{{ old('position', $boardMember->position) }}" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-violet-500 bg-transparent dark:text-white">
                @error('position') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Departemen</label>
                <select name="department_id" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-violet-500 bg-transparent dark:text-white">
                    <option value="" disabled>Pilih Departemen</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id', $boardMember->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
                @error('department_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tahun Kepengurusan</label>
                <input type="number" name="year" value="{{ old('year', $boardMember->year) }}" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-violet-500 bg-transparent dark:text-white">
                @error('year') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Foto Pengurus (Opsional)</label>
            <input type="file" name="photo" accept="image/*" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-violet-500 bg-transparent text-slate-500 dark:text-slate-400">
            <span class="text-xs text-slate-500 block mt-1">Biarkan kosong jika tidak ingin mengubah foto.</span>
            @error('photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg text-sm font-medium transition w-full">Update Pengurus</button>
    </form>
</div>
@endsection
