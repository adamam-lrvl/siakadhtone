{{-- resources/views/siswa/jadwal/index.blade.php --}}
@extends('siswa.layouts.app')
@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="max-w-5xl mx-auto py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl dark:border dark:border-white/[0.09] dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="relative p-6 flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-extrabold text-white dark:text-white/90 flex items-center gap-2 tracking-tight">
                    <i data-lucide="calendar-days" class="w-6 h-6 flex-shrink-0"></i> Jadwal pelajaran
                </h1>
                <p class="text-blue-200 dark:text-white/40 text-sm mt-1">Kelas {{ Auth::user()->siswa->kelas->nama_kelas ?? '-' }} · Tahun Ajaran 2025/2026</p>
            </div>
            <div class="bg-white/15 dark:bg-white/[0.07] border border-white/20 dark:border-white/[0.09] backdrop-blur-sm rounded-xl px-4 py-2 text-center flex-shrink-0">
                <p class="text-xs text-blue-100 dark:text-white/40">Hari ini</p>
                <p class="text-sm font-bold text-white dark:text-white/80">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    {{-- DESKTOP --}}
    <div class="hidden lg:block bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                    <th class="px-5 py-3.5 text-left font-semibold w-28">Hari</th>
                    <th class="px-5 py-3.5 text-left font-semibold w-36">Jam</th>
                    <th class="px-5 py-3.5 text-left font-semibold">Mata pelajaran</th>
                    <th class="px-5 py-3.5 text-left font-semibold">Guru pengajar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                @php $hariIni = \Carbon\Carbon::now()->translatedFormat('l'); @endphp
                @foreach($hariUrut as $hari)
                @php $isToday = strtolower($hari)===strtolower($hariIni); $ada = isset($jadwals[$hari]) && $jadwals[$hari]->count()>0; @endphp
                @if($ada)
                    @foreach($jadwals[$hari] as $j)
                    <tr class="hover:bg-indigo-50/30 dark:hover:bg-white/[0.04] transition {{ $isToday ? 'bg-blue-50/40 dark:bg-blue-500/[0.05]' : '' }}">
                        <td class="px-5 py-4">
                            @if($loop->first)
                                <p class="font-bold {{ $isToday ? 'text-blue-700 dark:text-blue-400' : 'text-gray-700 dark:text-white/70' }} text-sm">{{ $hari }}</p>
                                @if($isToday)<span class="text-[10px] font-semibold text-blue-500 dark:text-blue-400">Hari ini</span>@endif
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full
                                         {{ $isToday ? 'text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-500/15 border border-blue-200 dark:border-blue-400/25' : 'text-gray-600 dark:text-white/50 bg-gray-50 dark:bg-white/[0.05] border border-gray-200 dark:border-white/[0.08]' }}">
                                <i data-lucide="clock" class="w-3 h-3"></i>
                                {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                            </span>
                        </td>
                        <td class="px-5 py-4 font-semibold text-gray-900 dark:text-white/90">
                            {{ $j->mapel->nama_mapel }}
                            @if($j->mapel->kode)<span class="text-xs font-normal text-gray-400 dark:text-white/30">({{ $j->mapel->kode }})</span>@endif
                        </td>
                        <td class="px-5 py-4 text-gray-500 dark:text-white/40 text-xs">{{ $j->guru->nama }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr class="{{ $isToday ? 'bg-blue-50/40 dark:bg-blue-500/[0.05]' : '' }}">
                        <td class="px-5 py-4"><p class="font-bold {{ $isToday ? 'text-blue-700 dark:text-blue-400' : 'text-gray-400 dark:text-white/25' }} text-sm">{{ $hari }}</p>@if($isToday)<span class="text-[10px] font-semibold text-blue-500 dark:text-blue-400">Hari ini</span>@endif</td>
                        <td colspan="3" class="px-5 py-4 text-xs text-gray-300 dark:text-white/20">Tidak ada jadwal</td>
                    </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- MOBILE --}}
    <div class="lg:hidden space-y-3">
        @php $hariIni = \Carbon\Carbon::now()->translatedFormat('l'); @endphp
        @foreach($hariUrut as $hari)
        @php $isToday = strtolower($hari)===strtolower($hariIni); $ada = isset($jadwals[$hari]) && $jadwals[$hari]->count()>0; @endphp
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border {{ $isToday ? 'border-blue-200 dark:border-blue-400/30' : 'border-gray-200 dark:border-white/[0.07]' }} overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 {{ $isToday ? 'bg-blue-50 dark:bg-blue-500/[0.07]' : 'bg-gray-50 dark:bg-white/[0.03]' }} border-b {{ $isToday ? 'border-blue-100 dark:border-blue-400/20' : 'border-gray-100 dark:border-white/[0.05]' }}">
                <p class="font-bold text-sm {{ $isToday ? 'text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-white/60' }}">{{ $hari }}</p>
                @if($isToday)<span class="text-[10px] font-bold text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-500/20 px-2 py-0.5 rounded-full">Hari ini</span>@endif
            </div>
            @if($ada)
                <div class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                    @foreach($jadwals[$hari] as $j)
                    <div class="flex items-center gap-3 px-4 py-3.5 hover:bg-gray-50 dark:hover:bg-white/[0.04] transition">
                        <div class="w-9 h-9 {{ $isToday ? 'bg-blue-50 dark:bg-blue-500/15' : 'bg-gray-50 dark:bg-white/[0.05]' }} rounded-xl flex items-center justify-center flex-shrink-0">
                            <i data-lucide="book-open" class="w-4 h-4 {{ $isToday ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-white/35' }}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 dark:text-white/90 text-sm truncate">{{ $j->mapel->nama_mapel }}</p>
                            <p class="text-xs text-gray-400 dark:text-white/35 mt-0.5">{{ $j->guru->nama }}</p>
                        </div>
                        <span class="inline-flex items-center gap-1 text-xs font-semibold border px-2.5 py-1 rounded-full flex-shrink-0
                                     {{ $isToday ? 'text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-500/15 border-blue-200 dark:border-blue-400/25' : 'text-gray-600 dark:text-white/50 bg-gray-50 dark:bg-white/[0.05] border-gray-200 dark:border-white/[0.08]' }}">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="px-4 py-4 text-xs text-gray-300 dark:text-white/20 text-center">Tidak ada jadwal</div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection