@extends('layouts.admin')
@section('title', 'Daftar Pengurus Tahun ' . $year)

@section('content')
<div class="p-6" x-data="tableData()">
    <div class="mb-6">
        <a href="{{ route('admin.board-members.index') }}" class="text-sm text-slate-500 hover:text-slate-800 dark:hover:text-white mb-2 inline-block">← Kembali ke Tahun Kepengurusan</a>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mt-2">
            <h1 class="text-2xl font-semibold text-slate-800 dark:text-white">Pengurus Tahun {{ $year }}</h1>
            <a href="{{ route('admin.board-members.create') }}?year={{ $year }}" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg text-sm font-medium transition inline-block text-center whitespace-nowrap">
                + Tambah Pengurus
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm">
        {{-- Table Toolbar: Search --}}
        <div class="p-4 border-b border-slate-200 dark:border-slate-700 flex justify-end bg-slate-50 dark:bg-slate-800/50">
            <div class="relative">
                <input type="text" x-model="search" placeholder="Cari nama, jabatan, departemen..." class="w-full md:w-80 pl-10 pr-4 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-violet-500 bg-white dark:bg-slate-900 dark:text-white placeholder-slate-400">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 dark:bg-slate-700 text-slate-500 dark:text-slate-300">
                    <tr>
                        <th class="px-6 py-4 font-medium whitespace-nowrap">Foto</th>
                        <th @click="sortBy('name')" class="px-6 py-4 font-medium whitespace-nowrap cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-600 transition group select-none">
                            <div class="flex items-center gap-1">
                                Nama
                                <span class="text-xs text-slate-400 group-hover:text-violet-500" x-show="sortCol === 'name'" x-text="sortAsc ? '▲' : '▼'"></span>
                            </div>
                        </th>
                        <th @click="sortBy('position')" class="px-6 py-4 font-medium whitespace-nowrap cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-600 transition group select-none">
                            <div class="flex items-center gap-1">
                                Jabatan
                                <span class="text-xs text-slate-400 group-hover:text-violet-500" x-show="sortCol === 'position'" x-text="sortAsc ? '▲' : '▼'"></span>
                            </div>
                        </th>
                        <th @click="sortBy('department')" class="px-6 py-4 font-medium whitespace-nowrap cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-600 transition group select-none">
                            <div class="flex items-center gap-1">
                                Departemen
                                <span class="text-xs text-slate-400 group-hover:text-violet-500" x-show="sortCol === 'department'" x-text="sortAsc ? '▲' : '▼'"></span>
                            </div>
                        </th>
                        <th class="px-6 py-4 font-medium text-right whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    <template x-for="member in filteredAndSortedMembers" :key="member.id">
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <template x-if="member.photo">
                                    <img :src="`{{ asset('storage') }}/${member.photo}`" class="w-12 h-12 object-cover rounded-full border border-slate-200 shadow-sm" :alt="member.name">
                                </template>
                                <template x-if="!member.photo">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-600 flex items-center justify-center text-slate-400 font-serif text-lg" x-text="member.name.charAt(0)"></div>
                                </template>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800 dark:text-slate-200 whitespace-nowrap" x-text="member.name"></td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400 whitespace-nowrap" x-text="member.position"></td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400 whitespace-nowrap" x-text="member.department"></td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a :href="`/admin/board-members/${member.id}/edit`" class="text-blue-500 hover:text-blue-600 hover:underline mr-3 font-medium">Edit</a>
                                <form :action="`/admin/board-members/${member.id}`" method="POST" class="inline-block" onsubmit="return confirm('Hapus pengurus ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 hover:underline font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="filteredAndSortedMembers.length === 0" x-cloak>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">Tidak ada pengurus yang cocok dengan pencarian Anda.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 text-sm text-slate-500 text-right">
            Menampilkan <span class="font-medium" x-text="filteredAndSortedMembers.length"></span> pengurus
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('tableData', () => ({
        search: '',
        sortCol: 'department',
        sortAsc: true,
        // Map data from PHP to JS
        members: [
            @foreach($boardMembers as $member)
            {
                id: {{ $member->id }},
                name: '{{ addslashes($member->name) }}',
                position: '{{ addslashes($member->position) }}',
                department: '{{ addslashes($member->department->name ?? "") }}',
                photo: '{{ $member->photo }}'
            },
            @endforeach
        ],
        get filteredAndSortedMembers() {
            let result = this.members;
            
            // Search
            if (this.search) {
                const s = this.search.toLowerCase();
                result = result.filter(m => 
                    m.name.toLowerCase().includes(s) || 
                    m.position.toLowerCase().includes(s) || 
                    m.department.toLowerCase().includes(s)
                );
            }
            
            // Sort
            result = result.sort((a, b) => {
                let valA = a[this.sortCol].toLowerCase();
                let valB = b[this.sortCol].toLowerCase();
                if (valA < valB) return this.sortAsc ? -1 : 1;
                if (valA > valB) return this.sortAsc ? 1 : -1;
                return 0;
            });
            
            return result;
        },
        sortBy(col) {
            if (this.sortCol === col) {
                this.sortAsc = !this.sortAsc;
            } else {
                this.sortCol = col;
                this.sortAsc = true;
            }
        }
    }))
})
</script>
@endsection
