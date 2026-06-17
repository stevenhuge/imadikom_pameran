@extends('layouts.app')
@section('title', 'Voting Karya Terbaikmu')

@section('content')

{{-- HERO SECTION --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-16">
    {{-- Background ambient orbs --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-violet-500 dark:bg-violet-600/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-pastel-yellow dark:bg-gold/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 text-center px-6 max-w-4xl mx-auto animate-fade-up">
        @if($is_voting_open)
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-emerald-500/30 bg-emerald-500/5 text-emerald-600 dark:text-emerald-400 text-xs font-medium tracking-widest uppercase mb-8 shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Voting Sedang Berlangsung
                @if($voting_deadline)
                    <span class="opacity-50">|</span> Ditutup {{ \Carbon\Carbon::parse($voting_deadline)->format('d M, H:i') }}
                @endif
            </div>
        @else
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-red-500/30 bg-red-500/5 text-red-600 dark:text-red-400 text-xs font-medium tracking-widest uppercase mb-8 shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                Periode Voting Telah Ditutup
            </div>
        @endif

        <h1 class="font-serif text-6xl md:text-8xl leading-none mb-6">
            <span class=" text-slate-800 dark:text-slate-100">Pilih Karya</span><br>
            <span class="gradient-text font-serif not-">Terbaik Mereka</span>
        </h1>

        <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto mb-10 leading-relaxed">
            Berikan suaramu untuk poster favoritmu. Satu suara, satu pilihan — jadikan itu berarti.
        </p>

        <div class="flex items-center justify-center gap-4">
            <a href="#galeri" class="px-8 py-3.5 rounded-full bg-pastel-yellow dark:bg-gold text-ink font-bold hover:bg-pastel-yellow dark:bg-gold/90 transition-all hover:scale-105">
                Lihat Semua Karya ↓
            </a>
            @guest
            <a href="{{ route('register') }}" class="px-8 py-3.5 rounded-full border border-slate-300 dark:border-white/20 text-slate-600 dark:text-slate-300 hover:text-slate-800 dark:text-white hover:border-white/40 transition-all">
                Daftar untuk Vote
            </a>
            @endguest
        </div>

        {{-- Stats bar --}}
        <div class="mt-16 flex items-center justify-center gap-12 text-center">
            <div>
                <div class="font-serif  text-3xl text-violet-600 dark:text-violet-400-600 dark:text-gold">{{ $posters->count() }}</div>
                <div class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-widest mt-1">Karya</div>
            </div>
            <div class="w-px h-10 bg-slate-100 dark:bg-white/10"></div>
            <div>
                <div class="font-serif  text-3xl text-violet-600 dark:text-violet-400-600 dark:text-gold">{{ $posters->sum('votes_count') }}</div>
                <div class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-widest mt-1">Total Suara</div>
            </div>
            <div class="w-px h-10 bg-slate-100 dark:bg-white/10"></div>
            <div>
                <div class="font-serif  text-3xl text-violet-600 dark:text-violet-400-600 dark:text-gold">1</div>
                <div class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-widest mt-1">Suara per Voter</div>
            </div>
        </div>
    </div>
</section>

{{-- FLASH MESSAGES --}}
@if(session('success') || session('error'))
<div class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 w-full max-w-md px-4" x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)">
    @if(session('success'))
    <div class="flex items-start gap-3 p-4 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 text-sm backdrop-blur-xl shadow-2xl">
        <span class="text-lg">🎉</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="flex items-start gap-3 p-4 rounded-2xl bg-red-500/20 border border-red-500/30 text-red-300 text-sm backdrop-blur-xl shadow-2xl">
        <span class="text-lg">⚠️</span>
        <span>{{ session('error') }}</span>
    </div>
    @endif
</div>
@endif

{{-- RANKING TERTINGGI (PODIUM) --}}
@if($posters->count() >= 3)
<section class="max-w-7xl mx-auto px-6 pt-20 pb-10">
    <div class="text-center mb-16">
        <p class="text-violet-600 dark:text-violet-400-600 dark:text-gold text-xs uppercase tracking-widest mb-2 animate-pulse">Hall of Fame</p>
        <h2 class="font-serif  text-4xl md:text-5xl text-slate-800 dark:text-white">Ranking Vote Tertinggi</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-3 text-sm">3 Karya terbaik pilihan terbanyak sejauh ini.</p>
    </div>

    <div class="grid grid-cols-3 gap-3 sm:gap-6 items-end max-w-4xl mx-auto h-auto min-h-[350px]">
        @php
            $top3 = $posters->take(3);
            // Reorder for podium display: 2nd, 1st, 3rd
            $podium = collect([$top3->get(1), $top3->get(0), $top3->get(2)]);
            
            $rankStyles = [
                0 => ['color' => 'text-slate-300', 'bg' => 'bg-slate-300/10', 'border' => 'border-slate-300/30', 'shadow' => 'shadow-[0_0_20px_rgba(203,213,225,0.15)]', 'height' => 'h-52 sm:h-64', 'rank' => '2', 'label' => 'Silver'],
                1 => ['color' => 'text-yellow-400', 'bg' => 'bg-yellow-400/10', 'border' => 'border-yellow-400/40', 'shadow' => 'shadow-[0_0_40px_rgba(250,204,21,0.25)]', 'height' => 'h-64 sm:h-80', 'rank' => '1', 'label' => 'Gold'],
                2 => ['color' => 'text-amber-600', 'bg' => 'bg-amber-600/10', 'border' => 'border-amber-600/30', 'shadow' => 'shadow-[0_0_20px_rgba(217,119,6,0.15)]', 'height' => 'h-44 sm:h-52', 'rank' => '3', 'label' => 'Bronze'],
            ];
        @endphp

        @foreach($podium as $pos => $poster)
            @if($poster)
            @php $style = $rankStyles[$pos]; @endphp
            <div class="flex flex-col items-center group animate-fade-up" style="animation-delay: {{ $pos * 150 }}ms;">
                {{-- Poster Preview --}}
                <div class="relative w-full {{ $style['height'] }} rounded-t-2xl overflow-hidden border-t border-l border-r {{ $style['border'] }} {{ $style['shadow'] }} transition-transform duration-500 group-hover:-translate-y-2">
                    <img src="{{ str_starts_with($poster->gambar, 'http') ? $poster->gambar : asset('storage/' . $poster->gambar) }}" alt="{{ $poster->judul }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/60 to-transparent"></div>
                    
                    <div class="absolute bottom-3 inset-x-2 sm:bottom-4 sm:inset-x-4 text-center">
                        <h3 class="font-semibold text-slate-800 dark:text-white text-xs sm:text-sm line-clamp-1 mb-0.5">{{ $poster->judul }}</h3>
                        <p class="text-slate-600 dark:text-slate-300 text-[10px] sm:text-xs hidden sm:block mb-2">{{ $poster->pembuat }}</p>
                        <div class="inline-flex items-center gap-1.5 px-2 py-0.5 sm:px-3 sm:py-1 rounded-full {{ $style['bg'] }} {{ $style['color'] }} text-[10px] sm:text-xs font-bold border {{ $style['border'] }} backdrop-blur-md">
                            {{ $poster->votes_count }} suara
                        </div>
                    </div>
                </div>
                
                {{-- Podium Base --}}
                <div class="w-full h-20 sm:h-28 {{ $style['bg'] }} border {{ $style['border'] }} rounded-b-2xl flex flex-col items-center justify-center relative overflow-hidden backdrop-blur-md">
                    <div class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiNmZmYiLz48L3N2Zz4=')]"></div>
                    <span class="font-serif  text-4xl sm:text-6xl {{ $style['color'] }} drop-shadow-2xl relative z-10 leading-none">{{ $style['rank'] }}</span>
                    <span class="text-[8px] sm:text-[10px] uppercase tracking-widest {{ $style['color'] }} opacity-70 mt-1 relative z-10 font-bold">{{ $style['label'] }}</span>
                </div>
            </div>
            @else
            <div class="w-full h-20 sm:h-28 rounded-b-2xl"></div>
            @endif
        @endforeach
    </div>
</section>
@endif

{{-- DAFTAR RANKING PESERTA --}}
<section class="max-w-4xl mx-auto px-6 py-10 mb-10">
    <div class="text-center mb-10">
        <h2 class="font-serif  text-3xl text-slate-800 dark:text-white">Daftar Peringkat Peserta</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm mt-2">Total perolehan suara secara keseluruhan.</p>
    </div>
    
    <div class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl overflow-hidden backdrop-blur-md shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-xs uppercase tracking-widest bg-slate-50 dark:bg-slate-800">
                        <th class="py-4 px-6 font-medium w-20 text-center">Rank</th>
                        <th class="py-4 px-6 font-medium min-w-[150px]">Nama Peserta</th>
                        <th class="py-4 px-6 font-medium min-w-[200px]">Karya</th>
                        <th class="py-4 px-6 font-medium text-right w-32">Suara</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($posters as $index => $poster)
                    <tr class="border-b border-slate-100 dark:border-slate-800 last:border-0 hover:bg-slate-50 dark:bg-slate-800 transition">
                        <td class="py-4 px-6 text-center">
                            @if($index == 0)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400/20 text-yellow-400 border border-yellow-400/30 font-bold text-xs shadow-[0_0_15px_rgba(250,204,21,0.2)]">1</span>
                            @elseif($index == 1)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-300/20 text-slate-300 border border-slate-300/30 font-bold text-xs shadow-[0_0_10px_rgba(203,213,225,0.1)]">2</span>
                            @elseif($index == 2)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-600/20 text-amber-500 border border-amber-600/30 font-bold text-xs shadow-[0_0_10px_rgba(217,119,6,0.1)]">3</span>
                            @else
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-medium text-xs">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 font-medium text-slate-800 dark:text-slate-100">{{ $poster->pembuat }}</td>
                        <td class="py-4 px-6 text-slate-600 dark:text-slate-300">{{ $poster->judul }}</td>
                        <td class="py-4 px-6 text-right font-bold text-violet-600 dark:text-violet-400-600 dark:text-gold text-lg">{{ $poster->votes_count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- GALERI POSTER — Fixed Grid --}}
<section id="galeri" class="max-w-7xl mx-auto px-6 py-20" x-data="{ openModal: false, modalImg: '', modalTitle: '', modalMaker: '' }" @keydown.escape.window="openModal = false">
    <div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-12 gap-6">
        <div>
            <p class="text-violet-600 dark:text-violet-400-600 dark:text-gold text-xs uppercase tracking-widest mb-2">Galeri Karya</p>
            <h2 class="font-serif  text-4xl text-slate-800 dark:text-white">Semua Peserta</h2>
            @auth
                @if(!$is_voting_open)
                    <button disabled class="w-full py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 text-sm font-semibold cursor-not-allowed mt-4">
                        Voting Ditutup
                    </button>
                @elseif(!is_null($userVotedPosterId))
                <div class="mt-4 inline-block text-sm text-violet-600 dark:text-violet-400-600 dark:text-gold/70 border border-pastel-yellow dark:border-gold/20 px-4 py-2 rounded-full">
                    ✓ Suaramu sudah tercatat
                </div>
                @endif
            @endauth
        </div>

        <form action="{{ route('home') }}#galeri" method="GET" class="flex gap-2 w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari karya/peserta..." class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full px-4 py-2 text-sm text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:border-pastel-yellow dark:border-gold outline-none w-full md:w-64">
            <select name="sort" onchange="this.form.submit()" class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full px-4 py-2 text-sm text-slate-800 dark:text-white focus:border-pastel-yellow dark:border-gold outline-none cursor-pointer appearance-none">
                <option value="most_votes" {{ request('sort') == 'most_votes' ? 'selected' : '' }} class="bg-white dark:bg-slate-900">Suara Terbanyak</option>
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }} class="bg-white dark:bg-slate-900">Terbaru</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }} class="bg-white dark:bg-slate-900">Terlama</option>
            </select>
            @if(request('search') || request('sort'))
                <a href="{{ route('home') }}#galeri" class="text-sm text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:text-white transition flex items-center px-2">Reset</a>
            @endif
        </form>
    </div>

    {{-- Grid layout dengan aspect ratio tetap --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($posters as $poster)
        @php
            $isVotedByUser = auth()->check() && $userVotedPosterId === $poster->id;
            $hasVoted = auth()->check() && !is_null($userVotedPosterId);
        @endphp

        <div class="flex flex-col group relative rounded-2xl overflow-hidden border transition-all duration-500
            {{ $isVotedByUser ? 'border-pastel-yellow dark:border-gold voted-ring' : 'border-slate-200 dark:border-slate-700 hover:border-pastel-yellow dark:border-gold/30' }}
            bg-slate-50 dark:bg-slate-800/50 card-glow">

            {{-- Voted Badge --}}
            @if($isVotedByUser)
            <div class="absolute top-3 left-3 z-20 flex items-center gap-1.5 px-3 py-1 rounded-full bg-pastel-yellow dark:bg-gold text-ink text-xs font-bold shadow-lg">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                Pilihanmu
            </div>
            @endif

            {{-- Rank Badge (top 3) --}}
            @if($loop->index < 3)
            <div class="absolute top-3 right-3 z-20 w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold shadow-lg
                {{ $loop->index === 0 ? 'bg-yellow-400 text-yellow-900' : ($loop->index === 1 ? 'bg-slate-300 text-slate-900' : 'bg-amber-600 text-amber-100') }}">
                {{ $loop->index + 1 }}
            </div>
            @endif

            {{-- Gambar Poster --}}
            <div class="relative overflow-hidden aspect-[3/4] w-full shrink-0 bg-slate-100 dark:bg-slate-800/50 cursor-pointer group/img"
                 @click="openModal = true; modalImg = '{{ str_starts_with($poster->gambar, 'http') ? $poster->gambar : asset('storage/' . $poster->gambar) }}'; modalTitle = '{{ addslashes($poster->judul) }}'; modalMaker = '{{ addslashes($poster->pembuat) }}'">
                <img src="{{ str_starts_with($poster->gambar, 'http') ? $poster->gambar : asset('storage/' . $poster->gambar) }}"
                     alt="{{ $poster->judul }}"
                     class="w-full h-full object-cover transition-transform duration-700 group-hover/img:scale-105"
                     loading="lazy">
                {{-- Overlay gradient --}}
                <div class="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/20 to-transparent opacity-0 group-hover/img:opacity-100 transition-opacity duration-300"></div>
                
                {{-- Zoom Icon Overlay --}}
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity duration-300">
                    <span class="bg-slate-50/90 dark:bg-slate-900/60 text-slate-800 dark:text-white backdrop-blur-md px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2 border border-slate-200 dark:border-slate-700 shadow-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                        Perbesar
                    </span>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="p-4 flex flex-col flex-grow">
                <h3 class="font-semibold text-slate-800 dark:text-white text-base leading-tight mb-1 line-clamp-2">
                    {{ $poster->judul }}
                </h3>
                <div class="flex items-center gap-2 mb-3">
                    <p class="text-slate-500 dark:text-slate-400 text-xs">oleh {{ $poster->pembuat }}</p>
                    @if($poster->is_bidikmisi)
                        <img src="{{ asset('images/logo2.png') }}" class="h-4 w-auto object-contain" alt="Imadikom" title="Anggota Imadikom">
                    @endif
                </div>

                @if($poster->deskripsi)
                <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-3 line-clamp-2">{{ $poster->deskripsi }}</p>
                @endif

                {{-- Vote count --}}
                <div class="flex items-center gap-1.5 text-slate-500 dark:text-slate-400 text-xs mb-4">
                    <svg class="w-3.5 h-3.5 text-violet-600 dark:text-violet-400-600 dark:text-gold/50" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/></svg>
                    <span class="{{ $poster->votes_count > 0 ? 'text-violet-600 dark:text-violet-400-600 dark:text-gold/70' : '' }} font-medium">
                        {{ $poster->votes_count }} suara
                    </span>
                </div>
                
                {{-- VOTE BUTTON LOGIC --}}
                <div class="mt-auto pt-4 border-t border-slate-100 dark:border-slate-800">
                @if(!$is_voting_open)
                    <button disabled class="w-full py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500 text-sm font-semibold cursor-not-allowed">
                        Voting Ditutup
                    </button>
                @else
                    @auth
                        @if($isVotedByUser)
                            <button disabled class="w-full py-2.5 rounded-xl bg-pastel-yellow dark:bg-gold/20 text-violet-600 dark:text-violet-400-600 dark:text-gold text-sm font-semibold cursor-default border border-pastel-yellow dark:border-gold/30">
                                ✓ Sudah Kamu Pilih
                            </button>
                        @elseif($hasVoted)
                            <button disabled class="w-full py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-500 text-sm cursor-not-allowed">
                                Suaramu Sudah Digunakan
                            </button>
                        @else
                            <form action="{{ route('vote.store', $poster) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Yakin ingin memilih \&quot;{{ $poster->judul }}\&quot;? Pilihan tidak bisa diubah!')"
                                    class="w-full py-2.5 rounded-xl bg-violet-500 dark:bg-violet-600 text-white text-sm font-semibold hover:bg-violet-500 dark:bg-violet-600-light transition-all hover:scale-[1.02] active:scale-95 shadow-lg">
                                    Vote Karya Ini ✦
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="block w-full py-2.5 rounded-xl border border-pastel-yellow dark:border-gold/30 text-violet-600 dark:text-violet-400-600 dark:text-gold text-sm font-semibold text-center hover:bg-pastel-yellow dark:bg-gold/10 transition-all">
                            Login untuk Vote
                        </a>
                    @endauth
                @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-24 text-slate-500 dark:text-slate-400">
            <div class="text-5xl mb-4">🎨</div>
            <p class="text-lg">Belum ada poster yang ditambahkan.</p>
        </div>
        @endforelse
    </div>

    {{-- MODAL IMAGE --}}
    <div x-show="openModal" 
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" 
         x-cloak>
        <div x-show="openModal" 
             x-transition.opacity 
             class="absolute inset-0 bg-slate-900/50 dark:bg-slate-900/90 backdrop-blur-sm cursor-pointer" 
             @click="openModal = false"></div>
        
        <div x-show="openModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-8"
             class="relative z-10 max-w-4xl w-full max-h-[90vh] flex flex-col bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-3xl overflow-hidden shadow-2xl">
            
            <button @click="openModal = false" class="absolute top-4 right-4 z-20 p-2.5 bg-slate-100 dark:bg-slate-800/50 hover:bg-slate-100 dark:bg-white/10 text-slate-800 dark:text-white rounded-full backdrop-blur-md transition border border-slate-200 dark:border-slate-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            
            <div class="flex-1 overflow-auto bg-slate-100 dark:bg-slate-800/50 p-2 sm:p-4 flex items-center justify-center">
                <img :src="modalImg" :alt="modalTitle" class="max-h-[70vh] w-auto object-contain rounded-xl shadow-2xl">
            </div>
            
            <div class="p-6 bg-slate-50 dark:bg-slate-800 backdrop-blur-md border-t border-slate-200 dark:border-slate-700">
                <h3 class="font-serif  text-2xl sm:text-3xl text-slate-800 dark:text-white mb-1" x-text="modalTitle"></h3>
                <p class="text-slate-600 dark:text-slate-300 text-sm">Karya oleh: <span class="text-slate-800 dark:text-slate-100 font-medium" x-text="modalMaker"></span></p>
            </div>
        </div>
    </div>
</section>
@endsection
