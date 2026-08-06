{{-- resources/views/kepala-sekolah/laporan-nilai/index.blade.php --}}
@extends('kepala-sekolah.layouts.app')
@section('title', 'Laporan Nilai')

@section('content')
<div class="max-w-5xl mx-auto py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:border dark:border-white/[0.09]
                dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="relative p-6 flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-extrabold text-white flex items-center gap-2 tracking-tight">
                    <i data-lucide="trending-up" class="w-6 h-6 flex-shrink-0"></i>
                    Laporan nilai
                </h1>
                <p class="text-blue-200 dark:text-white/40 text-sm mt-1">Pilih kelas untuk melihat rekap nilai siswa</p>
            </div>
            <div class="bg-white/15 dark:bg-white/[0.07] border border-white/20 dark:border-white/[0.09]
                        backdrop-blur-sm rounded-xl px-4 py-2 text-center flex-shrink-0">
                <p class="text-xl font-bold text-white dark:text-white/90">{{ $kelas->count() }}</p>
                <p class="text-xs text-blue-100 dark:text-white/40">Kelas</p>
            </div>
        </div>
    </div>

    {{-- GRID KELAS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($kelas as $k)
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                    border border-gray-200 dark:border-white/[0.07]
                    rounded-2xl overflow-hidden
                    hover:border-indigo-300 dark:hover:border-indigo-400/40
                    hover:shadow-md dark:hover:bg-white/[0.08] transition-all">
            <div class="p-5">
                <div class="flex items-start gap-3 mb-4">
                    <div class="bg-indigo-50 dark:bg-indigo-500/15 rounded-xl p-2.5 flex-shrink-0">
                        <i data-lucide="school" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900 dark:text-white/90">{{ $k->nama_kelas }}</p>
                        <p class="text-xs text-gray-400 dark:text-white/35 mt-0.5">{{ $k->siswas_count }} siswa</p>
                        <p class="text-xs text-gray-400 dark:text-white/35 mt-0.5 flex items-center gap-1">
                            <i data-lucide="user" class="w-3 h-3"></i>
                            {{ $k->waliKelas->nama ?? 'Belum ada wali kelas' }}
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('kepsek.laporan-nilai.show', $k) }}?semester=1"
                       class="flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl
                              bg-blue-50 dark:bg-blue-500/15 border border-blue-200 dark:border-blue-400/25
                              text-blue-700 dark:text-blue-300 text-xs font-semibold
                              hover:bg-blue-100 dark:hover:bg-blue-500/25 transition">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i> Semester 1
                    </a>
                    <a href="{{ route('kepsek.laporan-nilai.show', $k) }}?semester=2"
                       class="flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl
                              bg-indigo-50 dark:bg-indigo-500/15 border border-indigo-200 dark:border-indigo-400/25
                              text-indigo-700 dark:text-indigo-300 text-xs font-semibold
                              hover:bg-indigo-100 dark:hover:bg-indigo-500/25 transition">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i> Semester 2
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                    rounded-2xl border border-gray-200 dark:border-white/[0.07] p-16 text-center">
            <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                <i data-lucide="school" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
            </div>
            <p class="text-sm font-medium text-gray-500 dark:text-white/30">Belum ada data kelas</p>
        </div>
        @endforelse
    </div>
</div>
@endsection