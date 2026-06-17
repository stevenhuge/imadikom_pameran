@extends('layouts.admin')
@section('title', 'Edit Kompetisi')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.competitions.index') }}" class="text-sm text-slate-500 hover:text-slate-800 dark:hover:text-white mb-2 inline-block">← Kembali</a>
        <h1 class="text-2xl font-semibold text-slate-800 dark:text-white">Edit Kompetisi</h1>
    </div>

    <form action="{{ route('admin.competitions.update', $competition) }}" method="POST" class="bg-white dark:bg-slate-800 p-6 rounded-xl border border-slate-200 dark:border-slate-700">
        @csrf @method('PUT')
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Kompetisi</label>
            <input type="text" name="name" value="{{ old('name', $competition->name) }}" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-violet-500 bg-transparent dark:text-white">
            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tahun</label>
                <input type="number" name="year" value="{{ old('year', $competition->year) }}" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-violet-500 bg-transparent dark:text-white">
                @error('year') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Biaya Pendaftaran</label>
                <select name="fee_type" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-violet-500 bg-transparent dark:text-white">
                    <option value="free" {{ old('fee_type', $competition->fee_type) == 'free' ? 'selected' : '' }}>Gratis (Free)</option>
                    <option value="paid" {{ old('fee_type', $competition->fee_type) == 'paid' ? 'selected' : '' }}>Berbayar (Paid)</option>
                </select>
                @error('fee_type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tema (Opsional)</label>
            <input type="text" name="theme" value="{{ old('theme', $competition->theme) }}" class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-violet-500 bg-transparent dark:text-white">
            @error('theme') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kategori Kelayakan (Eligibility)</label>
            <select name="eligibility_type" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-violet-500 bg-transparent dark:text-white">
                <option value="1" {{ old('eligibility_type', $competition->eligibility_type) == 1 ? 'selected' : '' }}>Khusus penerima KIP-K Universitas Amikom Yogyakarta</option>
                <option value="2" {{ old('eligibility_type', $competition->eligibility_type) == 2 ? 'selected' : '' }}>Khusus Mahasiswa Universitas Amikom Yogyakarta</option>
                <option value="3" {{ old('eligibility_type', $competition->eligibility_type) == 3 ? 'selected' : '' }}>Khusus penerima KIP-K perguruan tinggi di Indonesia</option>
                <option value="4" {{ old('eligibility_type', $competition->eligibility_type) == 4 ? 'selected' : '' }}>Seluruh perguruan tinggi yang terdaftar di pemerintah (Nasional/Umum)</option>
            </select>
            @error('eligibility_type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg text-sm font-medium transition w-full">Update Kompetisi</button>
    </form>
</div>
@endsection
