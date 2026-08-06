{{-- resources/views/admin/guru/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Data Guru')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="relative rounded-2xl overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)]"></div>
        <div class="relative p-6">
            <div class="flex items-start justify-between gap-4 mb-4">
                <div class="min-w-0">
                    <h1 class="text-2xl font-extrabold text-white flex items-center gap-2 tracking-tight">
                        <i data-lucide="users" class="w-6 h-6 flex-shrink-0"></i>
                        Data guru
                    </h1>
                    <p class="text-blue-200 text-sm mt-1">Kelola semua data pengajar</p>
                </div>
                <a href="{{ route('admin.guru.create') }}"
                   class="flex items-center gap-2 px-4 py-2 bg-white/15 hover:bg-white/25
                          border border-white/20 text-white text-sm font-semibold rounded-xl
                          transition flex-shrink-0 backdrop-blur-sm">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Tambah guru</span>
                    <span class="sm:hidden">Tambah</span>
                </a>
            </div>
            {{-- SEARCH --}}
            <form action="{{ route('admin.guru.index') }}" method="GET" class="flex gap-2">
                <div class="flex-1 relative">
                    <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari NIP, nama, atau email..."
                           class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                                  rounded-xl text-sm text-gray-700 dark:text-gray-200
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <button type="submit"
                        class="px-4 py-2.5 bg-white/15 hover:bg-white/25 border border-white/20
                               text-white text-sm font-semibold rounded-xl transition flex-shrink-0">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.guru.index') }}"
                       class="px-4 py-2.5 bg-white/10 hover:bg-white/20 border border-white/15
                              text-white text-sm font-semibold rounded-xl transition flex-shrink-0">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- TABEL / CARD --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">

        {{-- DESKTOP --}}
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                        <th class="px-5 py-3.5 text-left font-semibold w-32">NIP</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Nama</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Email</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Mapel</th>
                        <th class="px-5 py-3.5 text-left font-semibold w-32">Telepon</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($gurus as $guru)
                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-white/5 transition
                                   {{ $loop->even ? 'bg-gray-50/50 dark:bg-white/[0.02]' : '' }}">
                            <td class="px-5 py-4">
                                <code class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300
                                             px-2 py-0.5 rounded text-xs">
                                    {{ $guru->nip ?? '-' }}
                                </code>
                            </td>
                            <td class="px-5 py-4 font-semibold text-gray-900 dark:text-white">{{ $guru->nama }}</td>
                            <td class="px-5 py-4 text-gray-500 dark:text-gray-400 text-xs">{{ $guru->email ?? '-' }}</td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($guru->mapels as $mapel)
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                                     bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300
                                                     border border-indigo-200 dark:border-indigo-800">
                                            {{ $mapel->nama_mapel }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400 italic">Belum ada mapel</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-5 py-4 text-gray-500 dark:text-gray-400 text-xs">{{ $guru->telepon ?? '-' }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.guru.edit', $guru) }}"
                                       class="p-1.5 bg-amber-50 dark:bg-amber-950 hover:bg-amber-100 dark:hover:bg-amber-900
                                              text-amber-600 dark:text-amber-400 rounded-lg transition">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.guru.destroy', $guru) }}"
                                          method="POST" class="inline delete-form"
                                          data-name="{{ $guru->nama }}">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="p-1.5 bg-red-50 dark:bg-red-950 hover:bg-red-100 dark:hover:bg-red-900
                                                       text-red-600 dark:text-red-400 rounded-lg transition">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-16 text-gray-400">
                                <div class="bg-gray-50 dark:bg-gray-800 rounded-full w-14 h-14
                                            flex items-center justify-center mx-auto mb-3">
                                    <i data-lucide="users" class="w-7 h-7 text-gray-300 dark:text-gray-600"></i>
                                </div>
                                <p class="text-sm font-medium dark:text-gray-500">
                                    {{ request('search') ? 'Tidak ada hasil untuk "' . request('search') . '"' : 'Belum ada data guru' }}
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE --}}
        <div class="lg:hidden divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($gurus as $guru)
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-white/5 transition">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $guru->nama }}</p>
                        <code class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400
                                     px-2 py-0.5 rounded text-xs mt-1 inline-block">
                            {{ $guru->nip ?? '-' }}
                        </code>
                    </div>
                    <div class="flex gap-2 flex-shrink-0">
                        <a href="{{ route('admin.guru.edit', $guru) }}"
                           class="p-1.5 bg-amber-50 dark:bg-amber-950 hover:bg-amber-100 dark:hover:bg-amber-900
                                  text-amber-600 dark:text-amber-400 rounded-lg transition">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('admin.guru.destroy', $guru) }}"
                              method="POST" class="inline delete-form" data-name="{{ $guru->nama }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="p-1.5 bg-red-50 dark:bg-red-950 hover:bg-red-100 dark:hover:bg-red-900
                                           text-red-600 dark:text-red-400 rounded-lg transition">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-xs pt-2 border-t border-gray-100 dark:border-gray-800 mt-2">
                    <div>
                        <p class="text-gray-400">Email</p>
                        <p class="font-medium text-gray-700 dark:text-gray-300 truncate">{{ $guru->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Telepon</p>
                        <p class="font-medium text-gray-700 dark:text-gray-300">{{ $guru->telepon ?? '-' }}</p>
                    </div>
                </div>
                @if($guru->mapels->count() > 0)
                <div class="mt-2 pt-2 border-t border-gray-100 dark:border-gray-800">
                    <p class="text-xs text-gray-400 mb-1.5">Mapel mengajar</p>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($guru->mapels as $mapel)
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                         bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300
                                         border border-indigo-200 dark:border-indigo-800">
                                {{ $mapel->nama_mapel }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @empty
                <div class="text-center py-16">
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-full w-14 h-14
                                flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="users" class="w-7 h-7 text-gray-300 dark:text-gray-600"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-400 dark:text-gray-500">
                        {{ request('search') ? 'Tidak ada hasil untuk "' . request('search') . '"' : 'Belum ada data guru' }}
                    </p>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if($gurus->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800
                    bg-gray-50/50 dark:bg-white/[0.02]">
            {{ $gurus->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection