{{-- resources/views/admin/jadwal/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Data Jadwal Pelajaran')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:border dark:border-white/[0.09]
                dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="relative p-6">
            <div class="flex items-start justify-between gap-4 mb-4">
                <div class="min-w-0">
                    <h1 class="text-2xl font-extrabold text-white flex items-center gap-2 tracking-tight">
                        <i data-lucide="calendar-clock" class="w-6 h-6 flex-shrink-0"></i>
                        Data jadwal pelajaran
                    </h1>
                    <p class="text-blue-200 dark:text-white/40 text-sm mt-1">Kelola jadwal harian per kelas</p>
                </div>
                <a href="{{ route('admin.jadwal.create') }}"
                   class="flex items-center gap-2 px-4 py-2 bg-white/15 hover:bg-white/25
                          border border-white/20 text-white text-sm font-semibold rounded-xl
                          transition flex-shrink-0 backdrop-blur-sm">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Tambah jadwal</span>
                    <span class="sm:hidden">Tambah</span>
                </a>
            </div>
            <form action="{{ route('admin.jadwal.index') }}" method="GET" class="flex gap-2">
                <div class="flex-1 relative">
                    <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                    <input type="text" name="search" value="{{ request('search') }}" autocomplete="off"
                           placeholder="Cari kelas, mapel, atau guru..."
                           class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-white/[0.08] border border-gray-200 dark:border-white/[0.12]
                                  rounded-xl text-sm text-gray-700 dark:text-white/80
                                  placeholder-gray-400 dark:placeholder-white/30
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <button type="submit" class="px-4 py-2.5 bg-white/15 hover:bg-white/25 border border-white/20 text-white text-sm font-semibold rounded-xl transition flex-shrink-0">Cari</button>
                @if(request('search'))
                    <a href="{{ route('admin.jadwal.index') }}" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 border border-white/15 text-white text-sm font-semibold rounded-xl transition flex-shrink-0">Reset</a>
                @endif
            </form>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">

        {{-- DESKTOP --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                        <th class="px-5 py-3.5 text-left font-semibold w-28">Kelas</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Mapel</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Guru</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Hari & jam</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                    @forelse($jadwal as $grouped)
                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-white/[0.04] transition
                                   {{ $loop->even ? 'bg-gray-50/50 dark:bg-white/[0.02]' : '' }}">
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                             bg-indigo-50 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300
                                             border border-indigo-200 dark:border-indigo-400/25">
                                    {{ $grouped['kelas']->nama_kelas }}
                                </span>
                            </td>
                            <td class="px-5 py-4 font-semibold text-gray-900 dark:text-white/90">{{ $grouped['mapel']->nama_mapel }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-indigo-50 dark:bg-indigo-500/15 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="user" class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-300"></i>
                                    </div>
                                    <span class="font-medium text-gray-700 dark:text-white/70">{{ $grouped['guru']->nama }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex flex-col gap-1.5">
                                    @foreach($grouped['hari_jam'] as $hj)
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                                         bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-300
                                                         border border-blue-200 dark:border-blue-400/25">
                                                {{ $hj['hari'] }}
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-white/40">{{ $hj['jam'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.jadwal.edit', $grouped['id']) }}"
                                       class="p-1.5 bg-amber-50 dark:bg-amber-500/10 hover:bg-amber-100 dark:hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-lg transition">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.jadwal.destroy', $grouped['id']) }}" method="POST" class="inline delete-form" data-name="{{ $grouped['mapel']->nama_mapel }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 text-red-600 dark:text-red-400 rounded-lg transition">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-16">
                                <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                                    <i data-lucide="calendar-x" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-400 dark:text-white/30">
                                    {{ request('search') ? 'Tidak ada hasil untuk "' . request('search') . '"' : 'Belum ada jadwal pelajaran' }}
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE --}}
        <div class="md:hidden divide-y divide-gray-100 dark:divide-white/[0.05]">
            @forelse($jadwal as $grouped)
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-white/[0.04] transition">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                         bg-indigo-50 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300
                                         border border-indigo-200 dark:border-indigo-400/25">
                                {{ $grouped['kelas']->nama_kelas }}
                            </span>
                        </div>
                        <p class="font-semibold text-gray-900 dark:text-white/90">{{ $grouped['mapel']->nama_mapel }}</p>
                        <p class="text-xs text-gray-400 dark:text-white/35 mt-0.5 flex items-center gap-1">
                            <i data-lucide="user" class="w-3 h-3"></i>
                            {{ $grouped['guru']->nama }}
                        </p>
                    </div>
                    <div class="flex gap-2 flex-shrink-0">
                        <a href="{{ route('admin.jadwal.edit', $grouped['id']) }}" class="p-1.5 bg-amber-50 dark:bg-amber-500/10 hover:bg-amber-100 dark:hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-lg transition">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('admin.jadwal.destroy', $grouped['id']) }}" method="POST" class="inline delete-form" data-name="{{ $grouped['mapel']->nama_mapel }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 text-red-600 dark:text-red-400 rounded-lg transition">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-100 dark:border-white/[0.05] mt-2">
                    @foreach($grouped['hari_jam'] as $hj)
                        <div class="flex items-center gap-1.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                         bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-300
                                         border border-blue-200 dark:border-blue-400/25">{{ $hj['hari'] }}</span>
                            <span class="text-xs text-gray-500 dark:text-white/40">{{ $hj['jam'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @empty
                <div class="text-center py-16">
                    <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="calendar-x" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-400 dark:text-white/30">Belum ada jadwal pelajaran</p>
                </div>
            @endforelse
        </div>

        @if($jadwal->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 dark:border-white/[0.05] bg-gray-50/50 dark:bg-white/[0.02]">
            {{ $jadwal->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection