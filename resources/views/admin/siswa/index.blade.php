{{-- resources/views/admin/siswa/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Data Siswa')

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
                        <i data-lucide="user-check" class="w-6 h-6 flex-shrink-0"></i>
                        Data siswa
                    </h1>
                    <p class="text-blue-200 dark:text-white/40 text-sm mt-1">Total {{ $siswas->total() }} siswa terdaftar</p>
                </div>
                <a href="{{ route('admin.siswa.create') }}"
                   class="flex items-center gap-2 px-4 py-2 bg-white/15 hover:bg-white/25
                          border border-white/20 text-white text-sm font-semibold rounded-xl
                          transition flex-shrink-0 backdrop-blur-sm">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Tambah siswa</span>
                    <span class="sm:hidden">Tambah</span>
                </a>
            </div>
            {{-- SEARCH --}}
            <form action="{{ route('admin.siswa.index') }}" method="GET" class="flex gap-2">
                <div class="flex-1 relative">
                    <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           autocomplete="off"
                           placeholder="Cari NIS, nama, email, atau kelas..."
                           class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-white/[0.08] border border-gray-200 dark:border-white/[0.12]
                                  rounded-xl text-sm text-gray-700 dark:text-white/80
                                  placeholder-gray-400 dark:placeholder-white/30
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <button type="submit"
                        class="px-4 py-2.5 bg-white/15 hover:bg-white/25 border border-white/20
                               text-white text-sm font-semibold rounded-xl transition flex-shrink-0">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.siswa.index') }}"
                       class="px-4 py-2.5 bg-white/10 hover:bg-white/20 border border-white/15
                              text-white text-sm font-semibold rounded-xl transition flex-shrink-0">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- TABEL / CARD --}}
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">

        {{-- DESKTOP --}}
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                        <th class="px-4 py-3.5 text-center font-semibold w-10">No</th>
                        <th class="px-4 py-3.5 text-left font-semibold">NIS</th>
                        <th class="px-4 py-3.5 text-left font-semibold">Nama</th>
                        <th class="px-4 py-3.5 text-center font-semibold">JK</th>
                        <th class="px-4 py-3.5 text-center font-semibold">Tgl Lahir</th>
                        <th class="px-4 py-3.5 text-center font-semibold">Kelas</th>
                        <th class="px-4 py-3.5 text-left font-semibold">Telepon</th>
                        <th class="px-4 py-3.5 text-left font-semibold">Telepon Wali</th>
                        <th class="px-4 py-3.5 text-center font-semibold w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                    @forelse($siswas as $index => $siswa)
                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-white/[0.04] transition
                                   {{ $loop->even ? 'bg-gray-50/50 dark:bg-white/[0.02]' : '' }}">
                            <td class="px-4 py-4 text-center text-gray-400 dark:text-white/30 text-xs">
                                {{ $siswas->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-4">
                                <code class="bg-gray-100 dark:bg-white/[0.07] text-gray-700 dark:text-white/50 px-2 py-0.5 rounded text-xs">
                                    {{ $siswa->nis ?? '-' }}
                                </code>
                            </td>
                            <td class="px-4 py-4 font-semibold text-gray-900 dark:text-white/90">{{ $siswa->nama }}</td>
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                    {{ $siswa->jenis_kelamin == 'L'
                                        ? 'bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-400/25'
                                        : 'bg-pink-50 dark:bg-pink-500/15 text-pink-700 dark:text-pink-300 border border-pink-200 dark:border-pink-400/25' }}">
                                    {{ $siswa->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center text-gray-500 dark:text-white/40 text-xs">
                                {{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                             bg-indigo-50 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300
                                             border border-indigo-200 dark:border-indigo-400/25">
                                    {{ $siswa->kelas->nama_kelas ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-gray-500 dark:text-white/40 text-xs">{{ $siswa->telepon ?? '-' }}</td>
                            <td class="px-4 py-4 text-gray-500 dark:text-white/40 text-xs">{{ $siswa->telepon_wali ?? '-' }}</td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.siswa.edit', $siswa) }}"
                                       class="p-1.5 bg-amber-50 dark:bg-amber-500/10 hover:bg-amber-100 dark:hover:bg-amber-500/20
                                              text-amber-600 dark:text-amber-400 rounded-lg transition">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.siswa.destroy', $siswa) }}"
                                          method="POST" class="inline delete-form" data-name="{{ $siswa->nama }}">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="p-1.5 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20
                                                       text-red-600 dark:text-red-400 rounded-lg transition">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-16">
                                <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                                    <i data-lucide="users" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-400 dark:text-white/30">Belum ada data siswa</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE --}}
        <div class="lg:hidden divide-y divide-gray-100 dark:divide-white/[0.05]">
            @forelse($siswas as $index => $siswa)
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-white/[0.04] transition">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900 dark:text-white/90">{{ $siswa->nama }}</p>
                        <div class="flex items-center gap-2 mt-1 flex-wrap">
                            <code class="bg-gray-100 dark:bg-white/[0.07] text-gray-600 dark:text-white/40 px-2 py-0.5 rounded text-xs">
                                {{ $siswa->nis ?? '-' }}
                            </code>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                         bg-indigo-50 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300
                                         border border-indigo-200 dark:border-indigo-400/25">
                                {{ $siswa->kelas->nama_kelas ?? '-' }}
                            </span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                {{ $siswa->jenis_kelamin == 'L'
                                    ? 'bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-400/25'
                                    : 'bg-pink-50 dark:bg-pink-500/15 text-pink-700 dark:text-pink-300 border border-pink-200 dark:border-pink-400/25' }}">
                                {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex gap-2 flex-shrink-0">
                        <a href="{{ route('admin.siswa.edit', $siswa) }}"
                           class="p-1.5 bg-amber-50 dark:bg-amber-500/10 hover:bg-amber-100 dark:hover:bg-amber-500/20
                                  text-amber-600 dark:text-amber-400 rounded-lg transition">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('admin.siswa.destroy', $siswa) }}"
                              method="POST" class="inline delete-form" data-name="{{ $siswa->nama }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="p-1.5 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20
                                           text-red-600 dark:text-red-400 rounded-lg transition">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-xs pt-2 border-t border-gray-100 dark:border-white/[0.05]">
                    <div>
                        <p class="text-gray-400 dark:text-white/30">Email</p>
                        <p class="font-medium text-gray-700 dark:text-white/70 truncate">{{ $siswa->user->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 dark:text-white/30">Tgl Lahir</p>
                        <p class="font-medium text-gray-700 dark:text-white/70">
                            {{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d/m/Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400 dark:text-white/30">Telepon</p>
                        <p class="font-medium text-gray-700 dark:text-white/70">{{ $siswa->telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 dark:text-white/30">Telepon wali</p>
                        <p class="font-medium text-gray-700 dark:text-white/70">{{ $siswa->telepon_wali ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @empty
                <div class="text-center py-16">
                    <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="users" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-400 dark:text-white/30">Belum ada data siswa</p>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if($siswas->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 dark:border-white/[0.05] bg-gray-50/50 dark:bg-white/[0.02]">
            {{ $siswas->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection