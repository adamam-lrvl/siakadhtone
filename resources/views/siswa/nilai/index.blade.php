{{-- resources/views/siswa/nilai/index.blade.php --}}
@extends('siswa.layouts.app')
@section('title', 'Rekap Nilai Saya')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER BIRU --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="trending-up" class="w-6 h-6 flex-shrink-0"></i>
                    <span>Rekap nilai saya</span>
                </h1>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2 text-sm text-blue-100">
                    <span class="flex items-center gap-1">
                        <i data-lucide="user" class="w-3.5 h-3.5"></i>
                        {{ Auth::user()->siswa->nama }}
                    </span>
                    <span class="text-blue-300">•</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="school" class="w-3.5 h-3.5"></i>
                        {{ Auth::user()->siswa->kelas->nama_kelas ?? '-' }}
                    </span>
                </div>
            </div>

            {{-- EXPORT --}}
            <div class="flex gap-2 flex-shrink-0">
                <a href="{{ route('siswa.nilai.export.excel') }}"
                   class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25
                          text-white text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Excel</span>
                </a>
                <a href="{{ route('siswa.nilai.export.pdf') }}"
                   class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25
                          text-white text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">PDF</span>
                </a>
            </div>
        </div>
    </div>

    {{-- SEMESTER 1 --}}
    @php
        $smt1 = collect($rekapNilai)->where('semester', 1);
        $smt2 = collect($rekapNilai)->where('semester', 2);
    @endphp

    @foreach([1 => $smt1, 2 => $smt2] as $smt => $data)
    @if($data->count() > 0)
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

        {{-- HEADER CARD --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="{{ $smt == 1 ? 'bg-blue-50' : 'bg-indigo-50' }} rounded-xl p-2">
                    <i data-lucide="calendar" class="w-4 h-4 {{ $smt == 1 ? 'text-blue-600' : 'text-indigo-600' }}"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">Semester {{ $smt }}</p>
                    <p class="text-xs text-gray-400">{{ $data->count() }} mata pelajaran</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                         {{ $smt == 1
                             ? 'bg-blue-50 text-blue-700 border border-blue-200'
                             : 'bg-indigo-50 text-indigo-700 border border-indigo-200' }}">
                {{ $smt == 1 ? 'Ganjil' : 'Genap' }}
            </span>
        </div>

        {{-- MOBILE: CARD --}}
        <div class="lg:hidden divide-y divide-gray-100">
            @foreach($data as $r)
            <div class="p-4">
                <div class="flex items-center justify-between mb-3">
                    <p class="font-semibold text-gray-900 text-sm">{{ $r->mapel->nama_mapel }}</p>
                    @php
                        $badge = match($r->predikat) {
                            'A' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'B' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'C' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'D' => 'bg-orange-50 text-orange-700 border-orange-200',
                            default => 'bg-red-50 text-red-700 border-red-200',
                        };
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs
                                 font-bold border {{ $badge }}">
                        {{ $r->predikat }}
                    </span>
                </div>
                <div class="grid grid-cols-4 gap-2 text-center">
                    <div class="bg-gray-50 rounded-xl p-2.5">
                        <p class="text-xs text-gray-400">Tugas</p>
                        <p class="font-bold text-gray-800 text-sm">{{ $r->tugas }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-2.5">
                        <p class="text-xs text-gray-400">UTS</p>
                        <p class="font-bold text-gray-800 text-sm">{{ $r->uts }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-2.5">
                        <p class="text-xs text-gray-400">UAS</p>
                        <p class="font-bold text-gray-800 text-sm">{{ $r->uas }}</p>
                    </div>
                    <div class="{{ $smt == 1 ? 'bg-blue-50' : 'bg-indigo-50' }} rounded-xl p-2.5">
                        <p class="text-xs {{ $smt == 1 ? 'text-blue-400' : 'text-indigo-400' }}">Rata</p>
                        <p class="font-bold {{ $smt == 1 ? 'text-blue-700' : 'text-indigo-700' }} text-sm">
                            {{ $r->rata_rata }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- DESKTOP: TABEL --}}
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500">Mata Pelajaran</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500">Tugas</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500">UTS</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500">UAS</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500">Rata-rata</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500">Predikat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($data as $r)
                        @php
                            $badge = match($r->predikat) {
                                'A' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'B' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'C' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'D' => 'bg-orange-50 text-orange-700 border-orange-200',
                                default => 'bg-red-50 text-red-700 border-red-200',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50/70 transition {{ $loop->even ? 'bg-gray-50/30' : '' }}">
                            <td class="px-5 py-4 font-semibold text-gray-900">{{ $r->mapel->nama_mapel }}</td>
                            <td class="px-5 py-4 text-center text-gray-600">{{ $r->tugas }}</td>
                            <td class="px-5 py-4 text-center text-gray-600">{{ $r->uts }}</td>
                            <td class="px-5 py-4 text-center text-gray-600">{{ $r->uas }}</td>
                            <td class="px-5 py-4 text-center font-bold
                                       {{ $smt == 1 ? 'text-blue-700' : 'text-indigo-700' }}">
                                {{ $r->rata_rata }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs
                                             font-bold border {{ $badge }}">
                                    {{ $r->predikat }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @endif
    @endforeach

    {{-- EMPTY STATE --}}
    @if(collect($rekapNilai)->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-200 p-16 text-center">
        <div class="bg-gray-50 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
            <i data-lucide="book-x" class="w-7 h-7 text-gray-300"></i>
        </div>
        <p class="font-semibold text-gray-700">Belum ada nilai</p>
        <p class="text-xs text-gray-400 mt-1">Nilai akan muncul setelah guru menginput</p>
    </div>
    @endif

</div>
@endsection