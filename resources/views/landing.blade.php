@extends('layouts.app')
@section('title', 'IMADIKOM - Universitas Amikom Yogyakarta')

@section('content')

{{-- HERO / PROFIL SECTION --}}
<section id="profil" class="relative min-h-screen flex items-center justify-center overflow-hidden pt-16">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-violet-500 dark:bg-violet-600/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-pastel-yellow dark:bg-gold/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 text-center px-6 max-w-4xl mx-auto animate-fade-up">
        <img src="{{ asset('images/logo2.png') }}" alt="Logo IMADIKOM" class="w-24 md:w-32 h-auto mx-auto mb-6 md:mb-8 drop-shadow-2xl">
        <h1 class="font-serif text-4xl md:text-5xl lg:text-7xl leading-tight mb-6 md:mb-8">
            <span class="text-slate-800 dark:text-slate-100 font-bold">Tentang</span><br>
            <span class="gradient-text font-serif">IMADIKOM</span>
        </h1>

        <div class="bg-white/50 dark:bg-slate-800/50 backdrop-blur-md p-6 md:p-8 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xl">
            <p class="text-base md:text-lg lg:text-xl text-slate-700 dark:text-slate-300 leading-relaxed text-justify mb-4">
                <strong>IMADIKOM</strong> adalah sebuah komunitas yang menaungi Mahasiswa Penerima Beasiswa KIP Kuliah, Universitas Amikom Yogyakarta. Komunitas tersebut terbentuk pada tanggal 11 Oktober 2012. 
            </p>
            <p class="text-base md:text-lg lg:text-xl text-slate-700 dark:text-slate-300 leading-relaxed text-justify mb-4">
                Awal mula terbentuknya komunitas ini adalah belum adanya koordinasi antar Mahasiswa Penerima Bidikmisi/KIPK Amikom satu sama lain. Dan melalui IMADIKOM, diharapkan semua Mahasiswa Penerima Bidikmisi/KIPK bisa menjalin silaturahmi sesama Mahasiswa Bidikmisi/KIPK. 
            </p>
            <p class="text-base md:text-lg lg:text-xl text-slate-700 dark:text-slate-300 leading-relaxed text-justify font-medium">
                Tentunya juga memiliki visi yaitu <span class="text-violet-600 dark:text-violet-400">"Menjadi wadah Mahasiswa Bidikmisi untuk meningkatkan prestasi dengan prinsip kekeluargaan"</span>.
            </p>
        </div>
    </div>
</section>

{{-- ORGANISASI SECTION --}}
<section id="organisasi" class="py-24 bg-slate-50 dark:bg-slate-800/30">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="text-violet-600 dark:text-violet-400 text-sm font-bold uppercase tracking-widest mb-2">Struktur Kepengurusan</p>
            <h2 class="font-serif text-4xl text-slate-800 dark:text-white">Organisasi IMADIKOM</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-4 text-lg max-w-2xl mx-auto">Mengenal lebih dekat para pengurus yang berkontribusi dalam memajukan IMADIKOM dari masa ke masa.</p>
        </div>

        @foreach($departments as $dept)
            @if($dept->boardMembers->count() > 0)
            <div class="mb-16">
                <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-200 border-b border-slate-200 dark:border-slate-700 pb-3 mb-8 inline-block">
                    Departemen {{ $dept->name }}
                </h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($dept->boardMembers->sortBy('year')->reverse() as $member)
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 text-center shadow-lg border border-slate-100 dark:border-slate-700 hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-24 h-24 mx-auto rounded-full overflow-hidden mb-4 border-4 border-violet-100 dark:border-slate-700 bg-slate-100 dark:bg-slate-700">
                            @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}" class="w-full h-full object-cover" alt="{{ $member->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-3xl font-serif text-slate-400">{{ substr($member->name, 0, 1) }}</div>
                            @endif
                        </div>
                        <h4 class="font-bold text-slate-800 dark:text-white mb-1">{{ $member->name }}</h4>
                        <p class="text-violet-600 dark:text-violet-400 text-sm font-medium mb-2">{{ $member->position }}</p>
                        <span class="inline-block bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-300 text-xs px-3 py-1 rounded-full font-semibold">Tahun {{ $member->year }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach
    </div>
</section>

{{-- KEGIATAN SECTION (CAROUSEL) --}}
@if($activities->count() > 0)
<section id="kegiatan" class="py-24 overflow-hidden relative" x-data="{ currentSlide: 0, maxSlide: {{ $activities->count() - 1 }}, openModal: false, modalImg: '', modalTitle: '' }" @keydown.escape.window="openModal = false">
    <div class="max-w-7xl mx-auto px-6 mb-12 flex justify-between items-end">
        <div>
            <p class="text-violet-600 dark:text-violet-400 text-sm font-bold uppercase tracking-widest mb-2">Galeri Momen</p>
            <h2 class="font-serif text-4xl text-slate-800 dark:text-white">Kegiatan IMADIKOM</h2>
        </div>
        <div class="flex gap-2">
            <button @click="currentSlide = currentSlide === 0 ? maxSlide : currentSlide - 1" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 hover:bg-violet-500 hover:text-white hover:border-violet-500 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button @click="currentSlide = currentSlide === maxSlide ? 0 : currentSlide + 1" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 hover:bg-violet-500 hover:text-white hover:border-violet-500 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>

    {{-- Carousel Track --}}
    <div class="relative max-w-7xl mx-auto px-6">
        <div class="flex gap-6 transition-transform duration-500 ease-out" :style="`transform: translateX(-${currentSlide * 100}%)`">
            @foreach($activities as $activity)
            <div class="min-w-full md:min-w-[calc(50%-12px)] lg:min-w-[calc(33.333%-16px)] shrink-0 group">
                <div class="relative rounded-3xl overflow-hidden aspect-video bg-slate-200 dark:bg-slate-800 shadow-xl border border-slate-200 dark:border-slate-700 cursor-pointer"
                     @click="openModal = true; modalImg = '{{ asset('storage/' . $activity->photo) }}'; modalTitle = '{{ addslashes($activity->name) }}'">
                    @if($activity->photo)
                        <img src="{{ asset('storage/' . $activity->photo) }}" alt="{{ $activity->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    {{-- Zoom Icon Overlay --}}
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span class="bg-white/20 text-white backdrop-blur-md p-3 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                        </span>
                    </div>
                    <div class="absolute bottom-0 inset-x-0 p-6 translate-y-2 group-hover:translate-y-0 transition-transform">
                        <h3 class="text-xl font-bold text-white mb-2 drop-shadow-md">{{ $activity->name }}</h3>
                        <div class="w-12 h-1 bg-violet-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity delay-100"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- MODAL IMAGE --}}
    <div x-show="openModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" x-cloak>
        <div x-show="openModal" x-transition.opacity class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm cursor-pointer" @click="openModal = false"></div>
        <div x-show="openModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-8" class="relative z-10 max-w-5xl w-full flex flex-col bg-slate-900 rounded-3xl overflow-hidden shadow-2xl">
            <button @click="openModal = false" class="absolute top-4 right-4 z-20 p-2 bg-black/50 hover:bg-black/80 text-white rounded-full backdrop-blur-md transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="flex-1 overflow-auto bg-black/80 flex items-center justify-center min-h-[50vh]">
                <img :src="modalImg" :alt="modalTitle" class="max-h-[85vh] w-auto object-contain">
            </div>
            <div class="p-6 bg-slate-900 border-t border-slate-800 text-center">
                <h3 class="text-xl sm:text-2xl font-bold text-white" x-text="modalTitle"></h3>
            </div>
        </div>
    </div>
</section>
@endif

@endsection
