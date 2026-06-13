<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="icon" href="{{ asset('images/logo2.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <script>
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
                        pastel: { blue: '#AEC6CF', pink: '#FFD1DC', yellow: '#FDFD96', purple: '#C3B1E1', green: '#77DD77' },
                        ink: { DEFAULT: '#1E293B', 50: '#F8FAFC' },
                        gold: { DEFAULT: '#F5B82E', light: '#FCD34D', dark: '#F59E0B' },
                        violet: { DEFAULT: '#A78BFA', light: '#C4B5FD' },
                    },
                    animation: { 'fade-up': 'fadeUp 0.6s ease both', 'shimmer': 'shimmer 2s infinite' },
                    keyframes: {
                        fadeUp: { '0%': { opacity: 0, transform: 'translateY(24px)' }, '100%': { opacity: 1, transform: 'translateY(0)' } },
                        shimmer: { '0%': { transform: 'translateX(-100%)' }, '100%': { transform: 'translateX(200%)' } },
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-200 antialiased font-sans transition-colors duration-500 selection:bg-violet-500/30 overflow-hidden">

    {{-- PAGE LOADER --}}
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
                setTimeout(() => { loader.style.display = 'none'; }, 500);
            }
        });
    </script>

    <div class="flex h-screen w-full">
        {{-- SIDEBAR --}}
        <aside class="w-72 flex-shrink-0 bg-white dark:bg-slate-800 border-r border-slate-200 dark:border-slate-700 flex flex-col transition-colors duration-300">
            <div class="p-6 flex items-center justify-between border-b border-slate-200 dark:border-slate-700">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/logo2.png') }}" class="h-8 w-auto group-hover:scale-105 transition">
                    <span class="font-serif italic text-xl text-slate-800 dark:text-white tracking-wide">Admin</span>
                </a>
                <button onclick="toggleTheme()" class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                    <svg class="w-5 h-5 hidden dark:block text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <svg class="w-5 h-5 block dark:hidden text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                </button>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.posters.*') ? 'bg-violet-50 dark:bg-violet-500/10 text-violet-600 dark:text-violet-400 font-semibold' : 'text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard & Karya
                </a>
                <a href="{{ route('admin.members.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.members.*') ? 'bg-violet-50 dark:bg-violet-500/10 text-violet-600 dark:text-violet-400 font-semibold' : 'text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Anggota Imadikom
                </a>
                <a href="{{ route('admin.votes.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.votes.*') ? 'bg-violet-50 dark:bg-violet-500/10 text-violet-600 dark:text-violet-400 font-semibold' : 'text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Detail Voting
                </a>
                @if(auth()->user()->isSuperadmin())
                <a href="{{ route('admin.admins.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.admins.*') ? 'bg-violet-50 dark:bg-violet-500/10 text-violet-600 dark:text-violet-400 font-semibold' : 'text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Data Admin
                </a>
                @endif
            </nav>

            <div class="p-6 border-t border-slate-200 dark:border-slate-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800/50 text-slate-600 dark:text-slate-400 font-semibold hover:bg-red-50 dark:hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 h-full overflow-y-auto relative">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
