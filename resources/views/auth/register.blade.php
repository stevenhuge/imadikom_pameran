@extends('layouts.app')
@section('title', 'Daftar - Voting Karya')

@section('content')
<div class="min-h-screen flex items-center justify-center pt-24 pb-12 px-6 relative overflow-hidden">
    {{-- Ambient Background --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 right-1/4 w-[600px] h-[600px] bg-pastel-yellow dark:bg-gold/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 left-1/4 w-[500px] h-[500px] bg-violet-500 dark:bg-violet-600/15 rounded-full blur-[100px]"></div>
    </div>

    <div class="w-full max-w-md relative z-10 animate-fade-up">
        <div class="text-center mb-10">
            <h1 class="font-serif  text-5xl text-slate-800 dark:text-white mb-3">Buat Akun</h1>
            <p class="text-slate-600 dark:text-slate-300">Daftar sekarang untuk berpartisipasi dalam voting.</p>
        </div>

        <div class="backdrop-blur-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-8 shadow-2xl">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition"
                        placeholder="John Doe">
                    @error('name')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition"
                        placeholder="nama@email.com">
                    @error('email')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Kata Sandi</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition"
                        placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Konfirmasi Sandi</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition"
                        placeholder="Ulangi kata sandi">
                    @error('password_confirmation')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role Selection -->
                <div>
                    <label for="role" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Mendaftar Sebagai</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="role" value="voter" class="peer sr-only" {{ old('role', 'voter') === 'voter' ? 'checked' : '' }}>
                            <div class="px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 peer-checked:border-violet-500 peer-checked:bg-violet-50 dark:peer-checked:bg-violet-900/20 text-center font-bold text-slate-600 dark:text-slate-300 peer-checked:text-violet-700 dark:peer-checked:text-violet-400 transition">Voter Saja</div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="role" value="participant" class="peer sr-only" {{ old('role') === 'participant' ? 'checked' : '' }}>
                            <div class="px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 peer-checked:border-gold peer-checked:bg-gold/10 dark:peer-checked:bg-gold/20 text-center font-bold text-slate-600 dark:text-slate-300 peer-checked:text-gold-light dark:peer-checked:text-gold transition">Peserta Lomba</div>
                        </label>
                    </div>
                    @error('role')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIM Input (Only for Participant) -->
                <div id="nim-container" class="space-y-2 {{ old('role') === 'participant' ? '' : 'hidden' }}">
                    <label for="nim" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">NIM (Nomor Induk Mahasiswa)</label>
                    <input id="nim" type="text" name="nim" value="{{ old('nim') }}"
                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition"
                        placeholder="Contoh: 22.11.1234">
                    @error('nim')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 rounded-xl bg-pastel-yellow dark:bg-gold text-ink font-bold hover:bg-pastel-yellow dark:bg-gold-light transition-all shadow-lg hover:shadow-gold/25 hover:-translate-y-0.5">
                        Daftar Sekarang
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700 text-center">
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-violet-600 dark:text-violet-400-600 dark:text-gold font-semibold hover:text-violet-600 dark:text-violet-400-600 dark:text-gold-light transition">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleRadios = document.querySelectorAll('input[name="role"]');
        const nimContainer = document.getElementById('nim-container');
        const nimInput = document.getElementById('nim');

        roleRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'participant') {
                    nimContainer.classList.remove('hidden');
                    nimInput.setAttribute('required', 'required');
                } else {
                    nimContainer.classList.add('hidden');
                    nimInput.removeAttribute('required');
                }
            });
        });
    });
</script>
@endpush
