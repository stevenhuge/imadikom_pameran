<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Voting Karya Terbaikmu')</title>
    <link rel="icon" href="{{ asset('images/logo2.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <script>
        // Cek preferensi tema lokal
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
        
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }

        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Instrument Serif', 'serif'],
                    },
                    colors: {
                        pastel: {
                            blue: '#AEC6CF',
                            pink: '#FFD1DC',
                            yellow: '#FDFD96',
                            purple: '#C3B1E1',
                            green: '#77DD77',
                        },
                        ink:    { DEFAULT: '#1E293B', 50: '#F8FAFC' }, // slate-800 & slate-50
                        gold:   { DEFAULT: '#F5B82E', light: '#FCD34D', dark: '#F59E0B' }, // warm yellow
                        violet: { DEFAULT: '#A78BFA', light: '#C4B5FD' }, // soft purple
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.6s ease both',
                        'shimmer': 'shimmer 2s infinite',
                    },
                    keyframes: {
                        fadeUp: { '0%': { opacity: 0, transform: 'translateY(24px)' }, '100%': { opacity: 1, transform: 'translateY(0)' } },
                        shimmer: { 
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(200%)' } 
                        },
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-text { background: linear-gradient(135deg, #A78BFA, #F5B82E, #F97316); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .card-glow:hover { box-shadow: 0 0 40px rgba(167,139,250,0.15), 0 20px 40px rgba(0,0,0,0.1); }
        .voted-ring { box-shadow: 0 0 0 3px #A78BFA, 0 0 30px rgba(167,139,250,0.3); }
        .dark .card-glow:hover { box-shadow: 0 0 40px rgba(167,139,250,0.2), 0 20px 60px rgba(0,0,0,0.4); }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-200 antialiased font-sans transition-colors duration-500 selection:bg-violet-500/30">

    {{-- PAGE LOADER (Disabled temporarily for debugging)
    <div id="page-loader" class="fixed inset-0 z-[9999] bg-slate-100 dark:bg-slate-900 flex flex-col items-center justify-center transition-opacity duration-500">
        <img src="{{ asset('images/logo2.png') }}" class="h-24 w-auto animate-pulse mb-6" alt="Loading">
        <div class="w-48 h-1.5 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
            <div class="h-full bg-violet-500 w-1/2 animate-[shimmer_1s_infinite]"></div>
        </div>
    </div>
    <script>
        window.addEventListener('load', () => {
            const loader = document.getElementById('page-loader');
            if (loader) {
                loader.classList.add('opacity-0');
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 500);
            }
        });
    </script>
    --}}

    {{-- NAVBAR --}}
    <nav x-data="{ mobileMenuOpen: false }" class="fixed top-0 inset-x-0 z-50 backdrop-blur-xl bg-white/80 border-b border-slate-200 dark:bg-slate-900/80 dark:border-slate-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo1.png') }}" alt="Logo 1" class="h-10 w-auto object-contain drop-shadow-md hover:scale-105 transition-transform">
                    <img src="{{ asset('images/logo2.png') }}" alt="Logo 2" class="h-10 w-auto object-contain drop-shadow-md hover:scale-105 transition-transform">
                </div>
                <a href="{{ request()->routeIs('home') ? route('landing') : route('home') }}" class="font-serif  text-xl text-violet-500 dark:text-violet border-l border-slate-300 dark:border-slate-700 pl-4 hidden sm:block hover:text-violet-600 dark:hover:text-violet-light transition-colors">
                    ✦ {{ request()->routeIs('home') ? 'Pameran Voting' : 'IMADIKOM' }}
                </a>
            </div>
            
            {{-- DESKTOP MENU --}}
            <div class="hidden sm:flex items-center gap-2 sm:gap-4">
                <a href="{{ route('landing') }}#profil" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-violet-600 dark:hover:text-violet-400 transition">Profil</a>
                <a href="{{ route('landing') }}#organisasi" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-violet-600 dark:hover:text-violet-400 transition">Struktur Organisasi</a>
                <a href="{{ route('landing') }}#kegiatan" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-violet-600 dark:hover:text-violet-400 transition">Kegiatan</a>
                <a href="{{ route('home') }}" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-violet-600 dark:hover:text-violet-400 transition mr-2 border-r pr-4 dark:border-slate-700 border-slate-300">Voting</a>

                {{-- DARK/LIGHT TOGGLE --}}
                <button onclick="toggleTheme()" class="p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-800 transition text-slate-600 dark:text-slate-300">
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                </button>

                @auth
                    <span class="text-sm text-slate-600 dark:text-slate-400">{{ auth()->user()->name }}</span>                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-xs px-4 py-2 rounded-full bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-300 hover:bg-violet-200 dark:hover:bg-violet-900/50 transition font-medium">Admin</a>
                    @endif
                    @if(auth()->user()->role === 'participant')
                        <a href="{{ route('participant.dashboard') }}" class="text-xs px-4 py-2 rounded-full bg-gold/10 text-gold dark:bg-gold/20 dark:text-gold-light hover:bg-gold/20 transition font-medium">Dashboard</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button class="text-xs px-4 py-2 rounded-full border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm px-5 py-2.5 rounded-full bg-violet-500 text-white dark:bg-violet-600 font-semibold hover:bg-violet-600 dark:hover:bg-violet-50 transition shadow-sm">Daftar</a>
                @endauth
            </div>
 
            {{-- MOBILE MENU BUTTON & THEME TOGGLE --}}
            <div class="flex items-center gap-2 sm:hidden">
                <button onclick="toggleTheme()" class="p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-800 transition text-slate-600 dark:text-slate-300">
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                </button>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-800 transition text-slate-600 dark:text-slate-300">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
 
        {{-- MOBILE MENU DROPDOWN --}}
        <div x-show="mobileMenuOpen" x-transition.opacity x-cloak class="sm:hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 absolute w-full shadow-xl">
            <div class="px-6 py-4 flex flex-col gap-3 border-b border-slate-100 dark:border-slate-800">
                <a href="{{ route('landing') }}#profil" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-violet-600">Profil</a>
                <a href="{{ route('landing') }}#organisasi" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-violet-600">Struktur Organisasi</a>
                <a href="{{ route('landing') }}#kegiatan" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-violet-600">Kegiatan</a>
                <a href="{{ route('home') }}" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-violet-600">Pameran Voting</a>
            </div>
            <div class="px-6 py-6 flex flex-col gap-4">
                @auth
                    <span class="text-sm text-slate-600 dark:text-slate-400 font-medium pb-2 border-b border-slate-100 dark:border-slate-800">Hai, {{ auth()->user()->name }}</span>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-sm px-4 py-2.5 rounded-xl bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-300 font-medium text-center">Ke Halaman Admin</a>
                    @endif
                    @if(auth()->user()->role === 'participant')
                        <a href="{{ route('participant.dashboard') }}" class="text-sm px-4 py-2.5 rounded-xl bg-gold/10 text-gold dark:bg-gold/20 dark:text-gold-light font-medium text-center hover:bg-gold/20 transition">Dashboard Peserta</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="block w-full">">
                        @csrf
                        <button class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition font-medium">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-400 text-center font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm px-4 py-2.5 rounded-xl bg-violet-500 text-white dark:bg-violet-600 font-semibold text-center hover:bg-violet-600 transition">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>@yield('content')</main>

    <footer class="mt-24 border-t border-slate-200 dark:border-slate-800 py-10 text-center text-slate-500 dark:text-slate-500 text-sm">
        <p>✦ Voting Karya Terbaikmu &mdash; Semua hak dilindungi &copy; {{ date('Y') }}</p>
    </footer>

    @stack('scripts')
</body>
</html>
