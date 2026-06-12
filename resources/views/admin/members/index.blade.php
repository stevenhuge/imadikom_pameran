@extends('layouts.admin')
@section('title', 'Data Anggota Imadikom')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 ">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="font-serif italic text-4xl text-slate-800 dark:text-white mb-1">Data Anggota Imadikom</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Kelola daftar mahasiswa penerima beasiswa KIPK / Imadikom.</p>
        </div>
        <div class="flex items-center gap-3">
            
            <a href="{{ route('admin.members.create') }}" class="text-xs px-4 py-2 rounded-full bg-violet-500 dark:bg-violet-600 text-white font-semibold hover:bg-violet-500 dark:bg-violet-600-light transition">+ Tambah Anggota</a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 overflow-hidden backdrop-blur-md p-6">
        <div class="flex flex-col md:flex-row gap-4 mb-6 justify-between items-start md:items-center">
            {{-- Form Upload CSV --}}
            <form action="{{ route('admin.members.import') }}" method="POST" enctype="multipart/form-data" class="flex gap-2 items-center">
                @csrf
                <input type="file" name="csv_file" accept=".csv" required class="text-xs text-slate-600 dark:text-slate-300 file:mr-2 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-slate-100 dark:bg-white/10 file:text-slate-800 dark:text-white hover:file:bg-slate-50 dark:bg-white/50 transition cursor-pointer bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full px-2 py-1 w-48 sm:w-auto">
                <button type="submit" class="text-xs px-4 py-2 rounded-full bg-blue-500/20 text-blue-400 font-semibold hover:bg-blue-500/30 transition shadow-md whitespace-nowrap flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Upload CSV
                </button>
            </form>

            {{-- Form Search & Sort --}}
            <form action="{{ route('admin.members.index') }}" method="GET" class="flex gap-2 items-center w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/NIM..." class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full px-4 py-2 text-xs text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:border-pastel-yellow dark:border-gold outline-none w-full md:w-48">
                <select name="sort" onchange="this.form.submit()" class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full px-4 py-2 text-xs text-slate-800 dark:text-white focus:border-pastel-yellow dark:border-gold outline-none cursor-pointer appearance-none">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }} class="bg-white dark:bg-slate-900">Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }} class="bg-white dark:bg-slate-900">Terlama</option>
                    <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }} class="bg-white dark:bg-slate-900">Nama A-Z</option>
                    <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }} class="bg-white dark:bg-slate-900">Nama Z-A</option>
                </select>
                @if(request('search') || request('sort'))
                    <a href="{{ route('admin.members.index') }}" class="text-xs text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:text-white transition">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800 bg-slate-100 dark:bg-slate-800/50">
                        <th class="px-6 py-4">NIM</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Fakultas / Jurusan</th>
                        <th class="px-6 py-4">Universitas</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($members as $member)
                    <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-violet-600 dark:text-violet-400-600 dark:text-gold font-medium">{{ $member->nim }}</td>
                        <td class="px-6 py-4 text-slate-800 dark:text-slate-100">
                            <div class="flex items-center gap-2">
                                {{ $member->nama }}
                                <img src="{{ asset('images/logo2.png') }}" class="h-4 w-auto object-contain" alt="Imadikom" title="Anggota Imadikom">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-slate-600 dark:text-slate-300">{{ $member->jurusan }}</div>
                            <div class="text-slate-500 dark:text-slate-400 text-xs mt-0.5">{{ $member->fakultas }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $member->universitas }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.members.edit', $member) }}" class="text-xs px-3 py-1.5 rounded-lg bg-slate-50 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:text-slate-800 dark:text-white transition">Edit</a>
                                <form action="{{ route('admin.members.destroy', $member) }}" method="POST" onsubmit="return confirm('Hapus data anggota ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs px-3 py-1.5 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            Belum ada data anggota Imadikom.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($members->hasPages())
        <div class="mt-6 px-6 pb-6">
            {{ $members->links() }}
        </div>
    @endif
</div>
@endsection
