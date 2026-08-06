{{-- resources/views/guru/nilai/show.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Rekap Nilai • ' . $mapel->nama_mapel)

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
                <h1 class="text-2xl font-extrabold text-white dark:text-white/90 flex items-center gap-2 tracking-tight">
                    <i data-lucide="trending-up" class="w-6 h-6 flex-shrink-0"></i>
                    Rekap nilai siswa
                </h1>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2 text-sm text-blue-200 dark:text-white/40">
                    <span class="flex items-center gap-1">
                        <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                        {{ $mapel->nama_mapel }}
                    </span>
                    <span>·</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="users" class="w-3.5 h-3.5"></i>
                        {{ $kelas->nama_kelas }}
                    </span>
                    <span>·</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        Semester {{ $semester }} ({{ $semester == 1 ? 'Ganjil' : 'Genap' }})
                    </span>
                </div>
            </div>
            <div class="flex gap-2 flex-shrink-0 z-10">
                <a href="{{ route('guru.nilai.export.excel', [$kelas->id, $mapel->id, $semester]) }}"
                   class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25
                          border border-white/20 text-white text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Excel</span>
                </a>
                <a href="{{ route('guru.nilai.export.pdf', [$kelas->id, $mapel->id, $semester]) }}"
                   class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25
                          border border-white/20 text-white text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">PDF</span>
                </a>
            </div>
        </div>
    </div>

    {{-- TABEL REKAP --}}
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                        <th class="px-4 py-3.5 text-center font-semibold w-10">No</th>
                        <th class="px-4 py-3.5 text-left font-semibold">Nama Siswa</th>
                        <th class="px-4 py-3.5 text-center font-semibold w-24">NIS</th>
                        <th class="px-3 py-3.5 text-center font-semibold w-16">Tgs 1</th>
                        <th class="px-3 py-3.5 text-center font-semibold w-16">Tgs 2</th>
                        <th class="px-3 py-3.5 text-center font-semibold w-16">Tgs 3</th>
                        <th class="px-3 py-3.5 text-center font-semibold w-16">Tgs 4</th>
                        <th class="px-3 py-3.5 text-center font-semibold w-16">Tgs 5</th>
                        <th class="px-3 py-3.5 text-center font-semibold w-16">Tgs 6</th>
                        <th class="px-3 py-3.5 text-center font-semibold w-16">UTS</th>
                        <th class="px-3 py-3.5 text-center font-semibold w-16">UAS</th>
                        <th class="px-4 py-3.5 text-center font-semibold w-24">Rata-rata</th>
                        <th class="px-4 py-3.5 text-center font-semibold w-24">Predikat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                    @forelse($rekapSiswa as $index => $r)
                    @php
                        $nilaiColor = fn($v) => $v ? 'text-emerald-700 dark:text-emerald-400 font-bold' : 'text-gray-300 dark:text-white/20';
                        $badge = match($r['predikat']) {
                            'A' => 'bg-emerald-500',
                            'B' => 'bg-blue-500',
                            'C' => 'bg-amber-500',
                            'D' => 'bg-orange-500',
                            default => 'bg-red-500',
                        };
                    @endphp
                    <tr class="hover:bg-indigo-50/30 dark:hover:bg-white/[0.04] transition
                               {{ $loop->even ? 'bg-gray-50/50 dark:bg-white/[0.02]' : '' }}">
                        <td class="px-4 py-4 text-center text-gray-400 dark:text-white/30 text-xs">{{ $index + 1 }}</td>
                        <td class="px-4 py-4 font-semibold text-gray-900 dark:text-white/90">{{ $r['siswa']->nama }}</td>
                        <td class="px-4 py-4 text-center">
                            <code class="bg-gray-100 dark:bg-white/[0.07] text-gray-600 dark:text-white/50 px-2 py-0.5 rounded text-xs">{{ $r['siswa']->nis }}</code>
                        </td>
                        @foreach(['tugas_1','tugas_2','tugas_3','tugas_4','tugas_5','tugas_6'] as $t)
                        <td class="px-3 py-4 text-center text-xs {{ $nilaiColor($r['nilai'][$t] ?? null) }}">
                            {{ $r['nilai'][$t] ?? '-' }}
                        </td>
                        @endforeach
                        <td class="px-3 py-4 text-center text-xs {{ $r['nilai']['uts'] ?? false ? 'text-blue-700 dark:text-blue-400 font-bold' : 'text-gray-300 dark:text-white/20' }}">
                            {{ $r['nilai']['uts'] ?? '-' }}
                        </td>
                        <td class="px-3 py-4 text-center text-xs {{ $r['nilai']['uas'] ?? false ? 'text-indigo-700 dark:text-indigo-400 font-bold' : 'text-gray-300 dark:text-white/20' }}">
                            {{ $r['nilai']['uas'] ?? '-' }}
                        </td>
                        <td class="px-4 py-4 text-center text-xl font-extrabold text-gray-900 dark:text-white/90">
                            {{ $r['rata_rata'] }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-white font-extrabold text-sm shadow-sm {{ $badge }}">
                                {{ $r['predikat'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="text-center py-16">
                            <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                                <i data-lucide="users" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-400 dark:text-white/30">Belum ada data siswa atau nilai</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-start">
        <a href="{{ route('guru.nilai.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5
                  border-2 border-gray-200 dark:border-white/[0.10] rounded-xl
                  text-gray-600 dark:text-white/50 font-semibold text-sm
                  hover:bg-gray-50 dark:hover:bg-white/[0.07] transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke daftar mata pelajaran
        </a>
    </div>
</div>
@endsection