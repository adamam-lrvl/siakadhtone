{{-- resources/views/guru/absensi/index.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Absensi Hari Ini')

@section('content')
<div class="max-w-4xl mx-auto py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:border dark:border-white/[0.09]
                dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="absolute -right-10 -top-10 w-52 h-52 bg-white/[0.04] rounded-full pointer-events-none"></div>

        <div class="relative p-7 flex flex-wrap sm:flex-nowrap items-start justify-between gap-4">
            <div class="flex items-start gap-4 flex-1 min-w-0">
                <div class="w-11 h-11 bg-white/15 border border-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="calendar-check" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-blue-300 dark:text-white/35 uppercase tracking-widest mb-1">Akademik</p>
                    <h1 class="text-2xl font-extrabold text-white dark:text-white/90 leading-tight tracking-tight">Absensi hari ini</h1>
                    <p class="text-sm text-blue-200 dark:text-white/40 mt-1.5">
                        {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}
                    </p>
                </div>
            </div>
            <div class="flex gap-2 w-full sm:w-auto flex-shrink-0 z-10">
                <div class="flex-1 sm:flex-none bg-white/12 dark:bg-white/[0.07] border border-white/18 dark:border-white/[0.09] backdrop-blur-sm rounded-xl px-4 py-2 text-center">
                    <p class="text-xl font-extrabold text-white dark:text-white/90 leading-none">{{ $jadwals->count() }}</p>
                    <p class="text-xs text-blue-300 dark:text-white/40 mt-0.5 uppercase tracking-wide">Jadwal</p>
                </div>
                <div class="flex-1 sm:flex-none bg-white/12 dark:bg-white/[0.07] border border-white/18 dark:border-white/[0.09] backdrop-blur-sm rounded-xl px-4 py-2 text-center">
                    <p class="text-xl font-extrabold text-white dark:text-white/90 leading-none">
                        {{ $jadwals->filter(fn($j) => $j->sudahAbsenHariIni)->count() }}
                    </p>
                    <p class="text-xs text-blue-300 dark:text-white/40 mt-0.5 uppercase tracking-wide">Diabsen</p>
                </div>
            </div>
        </div>
    </div>

    {{-- LIST JADWAL --}}
    <div class="space-y-3">
        @forelse($jadwals as $j)
        @php
            $hariIni   = strtoupper(\Carbon\Carbon::today()->translatedFormat('l'));
            $isHariIni = strtoupper($j->hari) === $hariIni;
            $sudah     = $j->sudahAbsenHariIni;
            $hariLabel = ['SENIN'=>'Senin','SELASA'=>'Selasa','RABU'=>'Rabu','KAMIS'=>'Kamis','JUMAT'=>'Jumat','SABTU'=>'Sabtu'][strtoupper($j->hari)] ?? $j->hari;
        @endphp

        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                    rounded-2xl border {{ $isHariIni ? 'border-blue-200 dark:border-indigo-400/30' : 'border-gray-200 dark:border-white/[0.07]' }}
                    p-4 hover:shadow-md dark:hover:bg-white/[0.08] transition">

            <div class="flex items-start justify-between gap-3">
                <div class="flex items-start gap-3 flex-1 min-w-0">
                    <div class="w-10 h-10 {{ $isHariIni ? 'bg-blue-50 dark:bg-blue-500/15' : 'bg-gray-50 dark:bg-white/[0.06]' }}
                                rounded-xl flex items-center justify-center flex-shrink-0">
                        <i data-lucide="book-open" class="w-4 h-4 {{ $isHariIni ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-white/35' }}"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="font-bold text-gray-900 dark:text-white/90 text-sm leading-snug">
                            {{ $j->mapel->nama_mapel }}
                            @if($j->mapel->kode)
                                <span class="text-xs font-normal text-gray-400 dark:text-white/30">({{ $j->mapel->kode }})</span>
                            @endif
                        </p>
                        <div class="flex flex-wrap gap-x-3 gap-y-1 mt-1.5 text-xs text-gray-400 dark:text-white/35">
                            <span class="flex items-center gap-1">
                                <i data-lucide="users" class="w-3 h-3"></i>
                                {{ $j->kelas->nama_kelas }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i data-lucide="clock" class="w-3 h-3"></i>
                                {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} –
                                {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                                 {{ $isHariIni
                                    ? 'bg-blue-600 dark:bg-indigo-500/70 text-white'
                                    : 'bg-gray-100 dark:bg-white/[0.07] text-gray-500 dark:text-white/40 border border-gray-200 dark:border-white/[0.08]' }}">
                        <i data-lucide="calendar" class="w-3 h-3"></i>
                        {{ $hariLabel }}
                    </span>
                    @if($sudah)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                                     bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-400
                                     border border-emerald-200 dark:border-emerald-500/25">
                            <i data-lucide="check-circle" class="w-3 h-3"></i> Sudah
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                                     bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-400
                                     border border-amber-200 dark:border-amber-500/25">
                            <i data-lucide="clock" class="w-3 h-3"></i> Belum
                        </span>
                    @endif
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-white/[0.06] flex flex-wrap gap-2">
                @if($sudah)
                    <a href="{{ route('guru.absensi.show', $j) }}"
                       class="flex-1 sm:flex-none flex items-center justify-center gap-1.5 px-4 py-2 text-xs font-semibold rounded-xl
                              bg-white dark:bg-white/[0.07] border border-gray-200 dark:border-white/[0.10]
                              text-gray-700 dark:text-white/60 hover:bg-gray-50 dark:hover:bg-white/[0.12] transition">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i> Lihat rekap
                    </a>
                    <a href="{{ route('guru.absensi.edit', $j) }}"
                       class="flex-1 sm:flex-none flex items-center justify-center gap-1.5 px-4 py-2 text-xs font-semibold rounded-xl
                              bg-white dark:bg-white/[0.07] border border-gray-200 dark:border-white/[0.10]
                              text-gray-700 dark:text-white/60 hover:bg-gray-50 dark:hover:bg-white/[0.12] transition">
                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i> Edit absen
                    </a>
                @else
                    <a href="{{ route('guru.absensi.create', $j) }}"
                       class="flex-1 sm:flex-none flex items-center justify-center gap-1.5 px-5 py-2 text-xs font-bold rounded-xl
                              bg-blue-700 hover:bg-blue-800 text-white transition">
                        <i data-lucide="user-check" class="w-3.5 h-3.5"></i> Absen sekarang
                    </a>
                    @if($j->pernahAbsen)
                        <a href="{{ route('guru.absensi.show', $j) }}"
                           class="flex-1 sm:flex-none flex items-center justify-center gap-1.5 px-4 py-2 text-xs font-semibold rounded-xl
                                  bg-white dark:bg-white/[0.07] border border-gray-200 dark:border-white/[0.10]
                                  text-gray-700 dark:text-white/60 hover:bg-gray-50 dark:hover:bg-white/[0.12] transition">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> Lihat rekap
                        </a>
                    @endif
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                    rounded-2xl border border-gray-200 dark:border-white/[0.07] p-16 text-center">
            <div class="bg-indigo-50 dark:bg-indigo-500/15 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                <i data-lucide="calendar-x2" class="w-7 h-7 text-indigo-400 dark:text-indigo-400"></i>
            </div>
            <p class="font-semibold text-gray-700 dark:text-white/60 text-sm">Belum ada jadwal mengajar</p>
            <p class="text-xs text-gray-400 dark:text-white/30 mt-1">Hubungi admin untuk menambahkan jadwal</p>
        </div>
        @endforelse
    </div>
</div>
@endsection