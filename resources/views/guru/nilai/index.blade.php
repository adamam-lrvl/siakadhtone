{{-- resources/views/guru/nilai/index.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Input Nilai Siswa')

@section('content')
<div class="max-w-6xl mx-auto py-6 space-y-6">

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
                    <i data-lucide="book-open" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-blue-300 dark:text-white/35 uppercase tracking-widest mb-1">Akademik</p>
                    <h1 class="text-2xl font-extrabold text-white dark:text-white/90 leading-tight tracking-tight">Input nilai siswa</h1>
                    <p class="text-sm text-blue-200 dark:text-white/40 mt-1.5">Pilih mata pelajaran yang ingin diinput nilainya</p>
                </div>
            </div>
            <div class="bg-white/12 dark:bg-white/[0.07] border border-white/18 dark:border-white/[0.09] backdrop-blur-sm rounded-xl px-5 py-3 text-center flex-shrink-0 z-10">
                <p class="text-2xl font-extrabold text-white dark:text-white/90 leading-none">{{ $mapelGrouped->count() }}</p>
                <p class="text-xs text-blue-300 dark:text-white/40 mt-1 uppercase tracking-wide">Mata pelajaran</p>
            </div>
        </div>
    </div>

    @if($mapelGrouped->count())
        @php
            $accents = [
                ['bar' => 'from-blue-500 to-indigo-500',   'icon_bg' => 'bg-blue-50 dark:bg-blue-500/15',    'icon_color' => 'text-blue-600 dark:text-blue-400',    'hover_bg' => 'hover:bg-blue-50 dark:hover:bg-blue-500/10',    'hover_border' => 'hover:border-blue-200 dark:hover:border-blue-400/30',    'hover_text' => 'group-hover:text-blue-700 dark:group-hover:text-blue-400'],
                ['bar' => 'from-violet-500 to-purple-500', 'icon_bg' => 'bg-violet-50 dark:bg-violet-500/15', 'icon_color' => 'text-violet-600 dark:text-violet-400', 'hover_bg' => 'hover:bg-violet-50 dark:hover:bg-violet-500/10', 'hover_border' => 'hover:border-violet-200 dark:hover:border-violet-400/30', 'hover_text' => 'group-hover:text-violet-700 dark:group-hover:text-violet-400'],
                ['bar' => 'from-cyan-500 to-blue-500',     'icon_bg' => 'bg-cyan-50 dark:bg-cyan-500/15',     'icon_color' => 'text-cyan-600 dark:text-cyan-400',     'hover_bg' => 'hover:bg-cyan-50 dark:hover:bg-cyan-500/10',     'hover_border' => 'hover:border-cyan-200 dark:hover:border-cyan-400/30',     'hover_text' => 'group-hover:text-cyan-700 dark:group-hover:text-cyan-400'],
                ['bar' => 'from-rose-500 to-pink-500',     'icon_bg' => 'bg-rose-50 dark:bg-rose-500/15',     'icon_color' => 'text-rose-600 dark:text-rose-400',     'hover_bg' => 'hover:bg-rose-50 dark:hover:bg-rose-500/10',     'hover_border' => 'hover:border-rose-200 dark:hover:border-rose-400/30',     'hover_text' => 'group-hover:text-rose-700 dark:group-hover:text-rose-400'],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($mapelGrouped as $index => $item)
            @php $a = $accents[$index % count($accents)]; @endphp
            <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                        rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden
                        hover:border-gray-300 dark:hover:border-white/[0.12]
                        hover:shadow-lg dark:hover:bg-white/[0.08] transition-all duration-200">
                <div class="h-1.5 bg-gradient-to-r {{ $a['bar'] }}"></div>
                <div class="px-5 pt-5 pb-4">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 {{ $a['icon_bg'] }} rounded-xl flex items-center justify-center flex-shrink-0">
                            <i data-lucide="book-open" class="w-4 h-4 {{ $a['icon_color'] }}"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="font-bold text-gray-900 dark:text-white/90 text-sm leading-snug">
                                {{ $item['mapel']->nama_mapel }}
                                @if($item['mapel']->kode)
                                    <span class="text-xs font-normal text-gray-400 dark:text-white/30">({{ $item['mapel']->kode }})</span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-400 dark:text-white/35 mt-1 flex items-center gap-1">
                                <i data-lucide="users" class="w-3 h-3"></i>
                                {{ $item['kelas']->count() }} kelas diajar
                            </p>
                        </div>
                    </div>
                </div>
                <div class="h-px bg-gray-100 dark:bg-white/[0.05] mx-5"></div>
                <div class="p-3 space-y-1.5">
                    @foreach($item['kelas'] as $kelas)
                        <a href="{{ route('guru.nilai.pilih-kategori', [$kelas->id, $item['mapel']->id]) }}"
                           class="flex items-center justify-between px-4 py-3 rounded-xl
                                  border border-gray-100 dark:border-white/[0.06]
                                  {{ $a['hover_bg'] }} {{ $a['hover_border'] }} transition group">
                            <span class="text-sm font-semibold text-gray-700 dark:text-white/70 {{ $a['hover_text'] }}">
                                {{ $kelas->nama_kelas }}
                            </span>
                            <div class="w-6 h-6 bg-gray-100 dark:bg-white/[0.08]
                                        group-hover:bg-white dark:group-hover:bg-white/[0.15]
                                        rounded-lg flex items-center justify-center flex-shrink-0 transition">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-gray-400 dark:text-white/40 {{ $a['hover_text'] }}"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                    rounded-2xl border border-gray-200 dark:border-white/[0.07] p-16 text-center">
            <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                <i data-lucide="book-x" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
            </div>
            <p class="text-sm font-semibold text-gray-600 dark:text-white/50">Belum ada mata pelajaran</p>
            <p class="text-xs text-gray-400 dark:text-white/30 mt-1">Hubungi admin untuk menambahkan jadwal mengajar</p>
        </div>
    @endif

    <div>
        <a href="{{ route('guru.dashboard') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-gray-200 dark:border-white/[0.10]
                  rounded-xl text-gray-600 dark:text-white/50 font-semibold text-sm
                  hover:bg-gray-50 dark:hover:bg-white/[0.07] transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke dashboard
        </a>
    </div>
</div>
@endsection