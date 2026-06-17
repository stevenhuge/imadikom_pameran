@extends('layouts.app')
@section('title', 'Masuk - Voting Karya')

@section('content')
<div class="min-h-screen flex items-center justify-center pt-24 pb-12 px-6 relative overflow-hidden">
    {{-- Ambient Background --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/3 left-1/4 w-[500px] h-[500px] bg-violet-500 dark:bg-violet-600/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-1/3 right-1/4 w-[400px] h-[400px] bg-pastel-yellow dark:bg-gold/10 rounded-full blur-[80px]"></div>
    </div>

    <div class="w-full max-w-md relative z-10 animate-fade-up">
        <div class="text-center mb-10">
            <h1 class="font-serif  text-5xl text-slate-800 dark:text-white mb-3">Selamat Datang</h1>
            <p class="text-slate-600 dark:text-slate-300">Masuk untuk mulai memberikan suaramu atau mengelola karya.</p>
        </div>

        <div class="backdrop-blur-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-8 shadow-2xl">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-sm text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-2">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3.5 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition"
                        placeholder="nama@email.com">
                    @error('email')
                        <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-medium text-slate-600 dark:text-slate-300">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-violet-600 dark:text-violet-400-600 dark:text-gold/80 hover:text-violet-600 dark:text-violet-400-600 dark:text-gold transition">Lupa sandi?</a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3.5 text-slate-800 dark:text-white placeholder-slate-300 dark:placeholder-slate-600 focus:border-pastel-yellow dark:border-gold focus:ring-1 focus:ring-violet-400 dark:focus:ring-gold outline-none transition"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                        <div class="relative flex items-center justify-center w-5 h-5 rounded border border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-800 group-hover:border-pastel-yellow dark:border-gold/50 transition">
                            <input id="remember_me" type="checkbox" name="remember" class="peer opacity-0 absolute w-full h-full cursor-pointer">
                            <svg class="w-3 h-3 text-violet-600 dark:text-violet-400-600 dark:text-gold opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="ml-3 text-sm text-slate-600 dark:text-slate-300 group-hover:text-slate-800 dark:text-slate-100 transition">Ingat saya</span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-violet to-violet-light text-white font-bold hover:shadow-lg hover:shadow-violet/25 hover:-translate-y-0.5 transition-all">
                        Masuk Sekarang
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700 text-center">
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-violet-600 dark:text-violet-400-600 dark:text-gold font-semibold hover:text-violet-600 dark:text-violet-400-600 dark:text-gold-light transition">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
