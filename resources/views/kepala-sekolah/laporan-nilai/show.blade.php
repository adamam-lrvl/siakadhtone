{{-- resources/views/kepala-sekolah/laporan-nilai/show.blade.php --}}
@extends('kepala-sekolah.layouts.app')
@section('title', 'Laporan Nilai ' . $kelas->nama_kelas)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="trending-up" class="w-6 h-6 flex-shrink-0"></i>
                    <span>Laporan nilai — {{ $kelas->nama_kelas }}</span>
                </h1>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2 text-sm text-blue-100">
                    <span class="flex items-center gap-1">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        Semester {{ $semester }} ({{ $semester == 1 ? 'Ganjil' : 'Genap' }})
                    </span>
                    <span class="text-blue-300">•</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="users" class="w-3.5 h-3.5"></i>
                        {{ $siswas->count() }} siswa
                    </span>
                    <span class="text-blue-300">•</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="user" class="w-3.5 h-3.5"></i>
                        {{ $kelas->waliKelas->nama ?? '-' }}
                    </span>
                </div>
            </div>

            {{-- EXPORT --}}
            <div class="flex gap-2 flex-shrink-0">
                <a href="{{ route('kepsek.laporan-nilai.export-excel', $kelas) }}?semester={{ $semester }}"
                   class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25
                          text-white text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Excel</span>
                </a>
                <a href="{{ route('kepsek.laporan-nilai.export-pdf', $kelas) }}?semester={{ $semester }}"
                   class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25
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
                      : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            Semester 1
        </a>
        <a href="{{ route('kepsek.laporan-nilai.show', $kelas) }}?semester=2"
           class="px-4 py-2 text-sm font-semibold rounded-xl transition
                  {{ $semester == 2
                      ? 'bg-blue-600 text-white shadow-sm'
                      : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            Semester 2
        </a>
    </div>

    @if($mapels->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-200 p-16 text-center">
        <div class="bg-gray-50 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
            <i data-lucide="book-x" class="w-7 h-7 text-gray-300"></i>
        </div>
        <p class="text-sm font-medium text-gray-500">Belum ada data nilai untuk semester ini</p>
    </div>
    @else

    {{-- TABEL NILAI --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm" style="min-width: 700px">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                        <th class="px-4 py-3.5 text-center font-semibold w-10 sticky left-0 bg-blue-600">No</th>
                        <th class="px-4 py-3.5 text-left font-semibold w-28 sticky left-10 bg-blue-600">NIS</th>
                        <th class="px-4 py-3.5 text-left font-semibold w-44 sticky left-38 bg-blue-600">Nama Siswa</th>
                        @foreach($mapels as $mapel)
                            <th class="px-3 py-3.5 text-center font-semibold" colspan="3">
                                {{ $mapel->nama_mapel }}
                                <div class="flex justify-center gap-1 mt-1 text-blue-200 font-normal text-xs">
                                    <span class="w-10 text-center">Tgs</span>
                                    <span class="w-10 text-center">UTS</span>
                                    <span class="w-10 text-center">UAS</span>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($rekap as $index => $r)
                        <tr class="hover:bg-indigo-50/30 transition {{ $loop->even ? 'bg-gray-50/40' : '' }}">
                            <td class="px-4 py-3 text-center text-gray-400 text-xs">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-gray-500 text-xs">{{ $r->siswa->nis }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $r->siswa->nama }}</td>
                            @foreach($mapels as $mapel)
                                @php $n = $r->nilaiPerMapel[$mapel->id] ?? null; @endphp
                                <td class="px-2 py-3 text-center text-xs text-gray-600 w-10">{{ $n['tugas'] ?? '-' }}</td>
                                <td class="px-2 py-3 text-center text-xs text-gray-600 w-10">{{ $n['uts'] ?? '-' }}</td>
                                <td class="px-2 py-3 text-center text-xs w-10">
                                    @if(isset($n['uas']) && $n['uas'] !== '-')
                                        @php
                                            $badge = match($n['predikat'] ?? '-') {
                                                'A' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'B' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'C' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'D' => 'bg-orange-50 text-orange-700 border-orange-200',
                                                default => 'bg-red-50 text-red-700 border-red-200',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-bold border {{ $badge }}">
                                            {{ $n['predikat'] ?? '-' }}
                                        </span>
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @endif

    {{-- TOMBOL --}}
    <div class="flex justify-start">
        <a href="{{ route('kepsek.laporan-nilai.index') }}"
           class="px-5 py-2.5 border border-gray-200 rounded-xl text-gray-700 font-semibold
                  text-sm hover:bg-gray-50 transition flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke daftar kelas
        </a>
    </div>

</div>
@endsection