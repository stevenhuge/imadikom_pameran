@extends('layouts.admin')
@section('title', 'Edit Anggota Imadikom')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10 ">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="font-serif  text-4xl text-slate-800 dark:text-white mb-1">Edit Anggota</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Perbarui data anggota Imadikom.</p>
        </div>
        
    </div>

    <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 p-6 md:p-8 backdrop-blur-md">
        <form action="{{ route('admin.members.update', $member) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nim" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">NIM</label>
                    <input type="text" name="nim" id="nim" value="{{ old('nim', $member->nim) }}" required
                        class="w-full bg-slate-100 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition">
                    @error('nim') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="nama" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $member->nama) }}" required
                        class="w-full bg-slate-100 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition">
                    @error('nama') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="jurusan" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Jurusan</label>
                    <input type="text" name="jurusan" id="jurusan" value="{{ old('jurusan', $member->jurusan) }}" required
                        class="w-full bg-slate-100 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition">
                    @error('jurusan') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="fakultas" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Fakultas</label>
                    <input type="text" name="fakultas" id="fakultas" value="{{ old('fakultas', $member->fakultas) }}" required
                        class="w-full bg-slate-100 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition">
                    @error('fakultas') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="universitas" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Universitas</label>
                <input type="text" name="universitas" id="universitas" value="{{ old('universitas', $member->universitas) }}"
                    class="w-full bg-slate-100 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition">
                @error('universitas') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 border-t border-slate-200 dark:border-slate-700 flex justify-end">
                <button type="submit" class="px-6 py-3 rounded-full bg-violet-500 dark:bg-violet-600 text-white font-semibold hover:bg-violet-500 dark:bg-violet-600-light transition flex items-center gap-2">
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
