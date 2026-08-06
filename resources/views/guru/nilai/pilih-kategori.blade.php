{{-- resources/views/guru/nilai/pilih-kategori.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Pilih Kategori Nilai')

@section('content')
<div class="max-w-4xl mx-auto py-6 space-y-5">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:border dark:border-white/[0.09]
                dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="absolute -right-10 -top-10 w-52 h-52 bg-white/[0.04] rounded-full pointer-events-none"></div>
        <div class="relative p-7 flex items-start justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-11 h-11 bg-white/15 border border-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="clipboard-list" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-blue-300 dark:text-white/35 uppercase tracking-widest mb-1">Input Nilai</p>
                    <h1 class="text-2xl font-extrabold text-white dark:text-white/90 leading-tight tracking-tight">Pilih kategori nilai</h1>
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2 text-sm text-blue-200 dark:text-white/40">
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                            {{ $mapel->nama_mapel }}
                        </span>
                        <span>·</span>
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="users" class="w-3.5 h-3.5"></i>
                            {{ $kelas->nama_kelas }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 flex-shrink-0 z-10">


            </div>
        </div>
    </div>

    {{-- SEMESTER 1 --}}
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">
        <div class="h-1.5 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-white/[0.06]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-50 dark:bg-blue-500/15 rounded-xl flex items-center justify-center">
                    <i data-lucide="calendar" class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-900 dark:text-white/90 text-sm">Semester 1</p>
                    <p class="text-xs text-gray-400 dark:text-white/35">{{ count($kategori) }} kategori penilaian</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('guru.nilai.export.excel.kelas', [$kelas->id, $mapel->id]) }}?semester=1"
                   class="flex items-center gap-1.5 px-3 py-1.5
                          bg-blue-50 dark:bg-blue-500/15 hover:bg-blue-100 dark:hover:bg-blue-500/25
                          border border-blue-200 dark:border-blue-400/30
                          text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5"></i>
                    <span class="hidden sm:inline">Excel</span>
                </a>
                <a href="{{ route('guru.nilai.export.pdf.kelas', [$kelas->id, $mapel->id]) }}?semester=1"
                   class="flex items-center gap-1.5 px-3 py-1.5
                          bg-blue-50 dark:bg-blue-500/15 hover:bg-blue-100 dark:hover:bg-blue-500/25
                          border border-blue-200 dark:border-blue-400/30
                          text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                    <span class="hidden sm:inline">PDF</span>
                </a>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                             bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-300
                             border-2 border-blue-200 dark:border-blue-400/30">
                    Ganjil
                </span>
            </div>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($kategori as $kat)
                    <a href="{{ route('guru.nilai.input-kategori', [$kelas->id, $mapel->id, $kat]) }}?semester=1"
                       class="group flex flex-col items-center gap-3 p-4 rounded-xl
                              border border-gray-100 dark:border-white/[0.06]
                              hover:border-blue-200 dark:hover:border-blue-400/30
                              hover:bg-blue-50 dark:hover:bg-blue-500/10 transition-all text-center">
                        <div class="w-10 h-10 bg-blue-50 dark:bg-blue-500/15 group-hover:bg-blue-100 dark:group-hover:bg-blue-500/25 rounded-xl flex items-center justify-center transition">
                            <i data-lucide="{{ str_starts_with($kat, 'tugas') ? 'file-text' : ($kat == 'uts' ? 'clipboard' : 'award') }}"
                               class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <p class="font-bold text-gray-700 dark:text-white/60 group-hover:text-blue-700 dark:group-hover:text-blue-400 text-xs leading-snug transition">
                            {{ ucwords(str_replace('_', ' ', $kat)) }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- SEMESTER 2 --}}
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">
        <div class="h-1.5 bg-gradient-to-r from-violet-500 to-indigo-500"></div>
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-white/[0.06]">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-violet-50 dark:bg-violet-500/15 rounded-xl flex items-center justify-center">
                    <i data-lucide="calendar" class="w-4 h-4 text-violet-600 dark:text-violet-400"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-900 dark:text-white/90 text-sm">Semester 2</p>
                    <p class="text-xs text-gray-400 dark:text-white/35">{{ count($kategori) }} kategori penilaian</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('guru.nilai.export.excel.kelas', [$kelas->id, $mapel->id]) }}?semester=2"
                   class="flex items-center gap-1.5 px-3 py-1.5
                          bg-violet-50 dark:bg-violet-500/15 hover:bg-violet-100 dark:hover:bg-violet-500/25
                          border border-violet-200 dark:border-violet-400/30
                          text-violet-700 dark:text-violet-300 text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5"></i>
                    <span class="hidden sm:inline">Excel</span>
                </a>
                <a href="{{ route('guru.nilai.export.pdf.kelas', [$kelas->id, $mapel->id]) }}?semester=2"
                   class="flex items-center gap-1.5 px-3 py-1.5
                          bg-violet-50 dark:bg-violet-500/15 hover:bg-violet-100 dark:hover:bg-violet-500/25
                          border border-violet-200 dark:border-violet-400/30
                          text-violet-700 dark:text-violet-300 text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                    <span class="hidden sm:inline">PDF</span>
                </a>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                             bg-violet-50 dark:bg-violet-500/15 text-violet-700 dark:text-violet-300
                             border-2 border-violet-200 dark:border-violet-400/30">
                    Genap
                </span>
            </div>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($kategori as $kat)
                    <a href="{{ route('guru.nilai.input-kategori', [$kelas->id, $mapel->id, $kat]) }}?semester=2"
                       class="group flex flex-col items-center gap-3 p-4 rounded-xl
                              border border-gray-100 dark:border-white/[0.06]
                              hover:border-violet-200 dark:hover:border-violet-400/30
                              hover:bg-violet-50 dark:hover:bg-violet-500/10 transition-all text-center">
                        <div class="w-10 h-10 bg-violet-50 dark:bg-violet-500/15 group-hover:bg-violet-100 dark:group-hover:bg-violet-500/25 rounded-xl flex items-center justify-center transition">
                            <i data-lucide="{{ str_starts_with($kat, 'tugas') ? 'file-text' : ($kat == 'uts' ? 'clipboard' : 'award') }}"
                               class="w-4 h-4 text-violet-600 dark:text-violet-400"></i>
                        </div>
                        <p class="font-bold text-gray-700 dark:text-white/60 group-hover:text-violet-700 dark:group-hover:text-violet-400 text-xs leading-snug transition">
                            {{ ucwords(str_replace('_', ' ', $kat)) }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div>
        <a href="{{ route('guru.nilai.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-gray-200 dark:border-white/[0.10]
                  rounded-xl text-gray-600 dark:text-white/50 font-semibold text-sm
                  hover:bg-gray-50 dark:hover:bg-white/[0.07] transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>
</div>
@endsection