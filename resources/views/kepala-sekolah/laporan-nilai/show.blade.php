{{-- resources/views/kepala-sekolah/laporan-nilai/show.blade.php --}}
@extends('kepala-sekolah.layouts.app')
@section('title', 'Laporan Nilai ' . $kelas->nama_kelas)

@section('content')
<div class="max-w-7xl mx-auto py-6 space-y-6">

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
                    Laporan nilai — {{ $kelas->nama_kelas }}
                </h1>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2 text-sm text-blue-200 dark:text-white/40">
                    <span class="flex items-center gap-1">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        Semester {{ $semester }} ({{ $semester == 1 ? 'Ganjil' : 'Genap' }})
                    </span>
                    <span>·</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="users" class="w-3.5 h-3.5"></i>
                        {{ $siswas->count() }} siswa
                    </span>
                    <span>·</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="user" class="w-3.5 h-3.5"></i>
                        {{ $kelas->waliKelas->nama ?? '-' }}
                    </span>
                </div>
            </div>
            <div class="flex gap-2 flex-shrink-0">
                <a href="{{ route('kepsek.laporan-nilai.export-excel', $kelas) }}?semester={{ $semester }}"
                   class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25 border border-white/20
                          text-white text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Excel</span>
                </a>
                <a href="{{ route('kepsek.laporan-nilai.export-pdf', $kelas) }}?semester={{ $semester }}"
                   class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25 border border-white/20
                          text-white text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">PDF</span>
                </a>
            </div>
        </div>
    </div>

    {{-- SWITCH SEMESTER --}}
    <div class="flex gap-2">
        <a href="{{ route('kepsek.laporan-nilai.show', $kelas) }}?semester=1"
           class="px-4 py-2 text-sm font-semibold rounded-xl transition
                  {{ $semester == 1
                      ? 'bg-blue-600 text-white shadow-sm'
                      : 'bg-white dark:bg-white/[0.06] border border-gray-200 dark:border-white/[0.10] text-gray-600 dark:text-white/60 hover:bg-gray-50 dark:hover:bg-white/[0.09]' }}">
            Semester 1
        </a>
        <a href="{{ route('kepsek.laporan-nilai.show', $kelas) }}?semester=2"
           class="px-4 py-2 text-sm font-semibold rounded-xl transition
                  {{ $semester == 2
                      ? 'bg-blue-600 text-white shadow-sm'
                      : 'bg-white dark:bg-white/[0.06] border border-gray-200 dark:border-white/[0.10] text-gray-600 dark:text-white/60 hover:bg-gray-50 dark:hover:bg-white/[0.09]' }}">
            Semester 2
        </a>
    </div>

    @if($mapels->isEmpty())
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] p-16 text-center">
        <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
            <i data-lucide="book-x" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
        </div>
        <p class="text-sm font-medium text-gray-500 dark:text-white/30">Belum ada data nilai untuk semester ini</p>
    </div>
    @else

    {{-- MOBILE: Card per siswa --}}
    <div class="lg:hidden space-y-4">
        @foreach($rekap as $index => $r)
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">
            <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 dark:bg-white/[0.03] border-b border-gray-100 dark:border-white/[0.05]">
                <div class="w-8 h-8 bg-indigo-50 dark:bg-indigo-500/15 rounded-full flex items-center justify-center
                            text-indigo-600 dark:text-indigo-400 font-bold text-xs flex-shrink-0">
                    {{ $index + 1 }}
                </div>
                <div class="min-w-0">
                    <p class="font-semibold text-gray-900 dark:text-white/90 text-sm truncate">{{ $r->siswa->nama }}</p>
                    <p class="text-xs text-gray-400 dark:text-white/35">NIS: {{ $r->siswa->nis }}</p>
                </div>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                @foreach($mapels as $mapel)
                    @php
                        $n = $r->nilaiPerMapel[$mapel->id] ?? null;
                        $predikat = $n['predikat'] ?? '-';
                        $badge = match($predikat) {
                            'A' => 'bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/25',
                            'B' => 'bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-500/25',
                            'C' => 'bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/25',
                            'D' => 'bg-orange-50 dark:bg-orange-500/15 text-orange-700 dark:text-orange-400 border-orange-200 dark:border-orange-500/25',
                            'E' => 'bg-red-50 dark:bg-red-500/15 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/25',
                            default => 'bg-gray-50 dark:bg-white/[0.05] text-gray-400 dark:text-white/30 border-gray-200 dark:border-white/[0.08]',
                        };
                    @endphp
                    <div class="px-4 py-3">
                        <div class="flex items-center justify-between gap-3 mb-2">
                            <p class="text-xs font-semibold text-gray-700 dark:text-white/70 truncate">{{ $mapel->nama_mapel }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold border {{ $badge }} flex-shrink-0">{{ $predikat }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <div class="bg-gray-50 dark:bg-white/[0.04] rounded-lg px-2 py-1.5">
                                <p class="text-xs text-gray-400 dark:text-white/30">Tugas</p>
                                <p class="font-semibold text-gray-800 dark:text-white/80 text-sm">{{ $n['tugas'] ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-white/[0.04] rounded-lg px-2 py-1.5">
                                <p class="text-xs text-gray-400 dark:text-white/30">UTS</p>
                                <p class="font-semibold text-gray-800 dark:text-white/80 text-sm">{{ $n['uts'] ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-white/[0.04] rounded-lg px-2 py-1.5">
                                <p class="text-xs text-gray-400 dark:text-white/30">UAS</p>
                                <p class="font-semibold text-gray-800 dark:text-white/80 text-sm">{{ $n['uas'] ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    {{-- DESKTOP: Tabel --}}
    <div class="hidden lg:block bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                        <th class="px-4 py-3.5 text-center font-semibold w-10">No</th>
                        <th class="px-4 py-3.5 text-left font-semibold w-24">NIS</th>
                        <th class="px-4 py-3.5 text-left font-semibold w-44">Nama Siswa</th>
                        @foreach($mapels as $mapel)
                            <th class="px-2 py-2 text-center font-semibold" colspan="4">
                                <p class="text-xs leading-tight">{{ $mapel->nama_mapel }}</p>
                                <div class="flex justify-center gap-1 mt-1 text-blue-200 font-normal text-xs">
                                    <span class="w-9 text-center">Tgs</span>
                                    <span class="w-9 text-center">UTS</span>
                                    <span class="w-9 text-center">UAS</span>
                                    <span class="w-9 text-center">Pred</span>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                    @foreach($rekap as $index => $r)
                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-white/[0.04] transition {{ $loop->even ? 'bg-gray-50/40 dark:bg-white/[0.02]' : '' }}">
                            <td class="px-4 py-3 text-center text-gray-400 dark:text-white/30 text-xs">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-gray-500 dark:text-white/40 text-xs">{{ $r->siswa->nis }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white/90 text-sm">{{ $r->siswa->nama }}</td>
                            @foreach($mapels as $mapel)
                                @php
                                    $n = $r->nilaiPerMapel[$mapel->id] ?? null;
                                    $predikat = $n['predikat'] ?? '-';
                                    $badge = match($predikat) {
                                        'A' => 'bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/25',
                                        'B' => 'bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-500/25',
                                        'C' => 'bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/25',
                                        'D' => 'bg-orange-50 dark:bg-orange-500/15 text-orange-700 dark:text-orange-400 border-orange-200 dark:border-orange-500/25',
                                        'E' => 'bg-red-50 dark:bg-red-500/15 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/25',
                                        default => 'bg-gray-50 dark:bg-white/[0.05] text-gray-400 dark:text-white/30 border-gray-200 dark:border-white/[0.08]',
                                    };
                                @endphp
                                <td class="px-1 py-3 text-center text-xs text-gray-600 dark:text-white/50 w-9">{{ $n['tugas'] ?? '-' }}</td>
                                <td class="px-1 py-3 text-center text-xs text-gray-600 dark:text-white/50 w-9">{{ $n['uts'] ?? '-' }}</td>
                                <td class="px-1 py-3 text-center text-xs text-gray-600 dark:text-white/50 w-9">{{ $n['uas'] ?? '-' }}</td>
                                <td class="px-1 py-3 text-center w-9">
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-bold border {{ $badge }}">
                                        {{ $predikat }}
                                    </span>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="flex justify-start">
        <a href="{{ route('kepsek.laporan-nilai.index') }}"
           class="px-5 py-2.5 border-2 border-gray-200 dark:border-white/[0.10] rounded-xl
                  text-gray-600 dark:text-white/50 font-semibold text-sm
                  hover:bg-gray-50 dark:hover:bg-white/[0.07] transition
                  flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke daftar kelas
        </a>
    </div>
</div>
@endsection