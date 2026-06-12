@extends('layouts.admin')
@section('title', 'Edit Poster')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10 ">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="font-serif italic text-4xl text-slate-800 dark:text-white mb-1">Edit Poster</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Perbarui informasi karya poster.</p>
        </div>
        
    </div>

    <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 p-6 md:p-8">
        <form action="{{ route('admin.posters.update', $poster) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="judul" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Judul Karya</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $poster->judul) }}" required
                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition">
                @error('judul')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="pembuat" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Nama Pembuat</label>
                <input type="text" name="pembuat" id="pembuat" value="{{ old('pembuat', $poster->pembuat) }}" required
                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition">
                @error('pembuat')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nim" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">NIM (Opsional - Untuk validasi Anggota Imadikom)</label>
                <div class="flex gap-3">
                    <input type="text" name="nim" id="nim" value="{{ old('nim', $poster->nim) }}"
                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition"
                        placeholder="Contoh: 21.11.4000">
                    <button type="button" id="btn-check-nim" class="px-6 rounded-xl bg-violet-500 dark:bg-violet-600 text-white font-semibold hover:bg-violet-500 dark:bg-violet-600-light transition whitespace-nowrap shadow-lg">
                        Cek Imadikom
                    </button>
                </div>
                
                <div id="kipk-status" class="mt-3 text-sm {{ old('is_bidikmisi', $poster->is_bidikmisi) ? '' : 'hidden' }}">
                    @if(old('is_bidikmisi', $poster->is_bidikmisi))
                        <span class="text-green-400 flex items-center gap-1">✓ Terdaftar sebagai anggota Imadikom</span>
                    @endif
                </div>
                <input type="hidden" name="is_bidikmisi" id="is_bidikmisi" value="{{ old('is_bidikmisi', $poster->is_bidikmisi ? '1' : '0') }}">
                @error('nim')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Deskripsi Karya (Opsional)</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition">{{ old('deskripsi', $poster->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Gambar Saat Ini</label>
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $poster->gambar) }}" alt="Poster" class="h-32 rounded-lg object-cover border border-slate-200 dark:border-slate-700">
                </div>
                
                <label for="gambar" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Ganti Gambar (Opsional)</label>
                <input type="file" name="gambar" id="gambar" accept=".jpg,.jpeg,.png,.webp"
                    class="w-full text-sm text-slate-600 dark:text-slate-300 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 dark:file:bg-violet-500/20 file:text-violet-600 dark:file:text-violet-400 hover:file:bg-violet-100 dark:hover:file:bg-violet-500/30 transition file:cursor-pointer cursor-pointer border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800 p-2">
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-2">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                @error('gambar')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-200 dark:border-slate-700 flex justify-end">
                <button type="submit" class="px-6 py-3 rounded-full bg-pastel-yellow dark:bg-gold text-ink font-semibold hover:bg-pastel-yellow dark:bg-gold/90 transition flex items-center gap-2">
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnCheck = document.getElementById('btn-check-nim');
        if(btnCheck) {
            btnCheck.addEventListener('click', async function() {
                const nim = document.getElementById('nim').value.trim();
                const statusEl = document.getElementById('kipk-status');
                const inputIsBidikmisi = document.getElementById('is_bidikmisi');
                
                if(!nim) {
                    statusEl.innerHTML = '<span class="text-yellow-400">Silakan masukkan NIM terlebih dahulu.</span>';
                    statusEl.classList.remove('hidden');
                    return;
                }
                
                statusEl.innerHTML = '<span class="text-slate-600 dark:text-slate-300">Memeriksa...</span>';
                statusEl.classList.remove('hidden');
                
                try {
                    const response = await fetch(`/api/check-nim/${nim}`);
                    const data = await response.json();
                    
                    if(data.is_bidikmisi) {
                        statusEl.innerHTML = '<span class="text-green-400 flex items-center gap-1">✓ Terdaftar sebagai anggota Imadikom</span>';
                        inputIsBidikmisi.value = '1';
                    } else {
                        statusEl.innerHTML = '<span class="text-red-400 flex items-center gap-1">✗ NIM tidak ditemukan dalam data Imadikom</span>';
                        inputIsBidikmisi.value = '0';
                    }
                } catch (e) {
                    statusEl.innerHTML = '<span class="text-red-400">Terjadi kesalahan saat memeriksa NIM.</span>';
                }
            });
        }
    });
</script>
@endpush
