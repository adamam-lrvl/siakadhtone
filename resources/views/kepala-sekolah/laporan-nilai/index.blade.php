{{-- resources/views/kepala-sekolah/laporan-nilai/index.blade.php --}}
@extends('kepala-sekolah.layouts.app')
@section('title', 'Laporan Nilai')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="trending-up" class="w-6 h-6 flex-shrink-0"></i>
                    <span>Laporan nilai</span>
                </h1>
                <p class="text-blue-100 text-sm mt-1">
                    Pilih kelas untuk melihat rekap nilai siswa
                </p>
            </div>
            <div class="bg-white/15 rounded-xl px-4 py-2 text-center flex-shrink-0">
                <p class="text-xl font-bold">{{ $kelas->count() }}</p>
                <p class="text-xs text-blue-100">Kelas</p>
            </div>
        </div>
    </div>

    {{-- GRID KELAS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($kelas as $k)
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden
                    hover:border-indigo-300 hover:shadow-md transition-all">
            <div class="p-5">
                <div class="flex items-start gap-3 mb-4">
                    <div class="bg-indigo-50 rounded-xl p-2.5 flex-shrink-0">
                        <i data-lucide="school" class="w-5 h-5 text-indigo-600"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900">{{ $k->nama_kelas }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $k->siswas_count }} siswa
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                            <i data-lucide="user" class="w-3 h-3"></i>
                            {{ $k->waliKelas->nama ?? 'Belum ada wali kelas' }}
                        </p>
                    </div>
                </div>

                {{-- PILIH SEMESTER --}}
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('kepsek.laporan-nilai.show', $k) }}?semester=1"
                       class="flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl
                              bg-blue-50 border border-blue-200 text-blue-700 text-xs
                              font-semibold hover:bg-blue-100 transition">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        Semester 1
                    </a>
                    <a href="{{ route('kepsek.laporan-nilai.show', $k) }}?semester=2"
                       class="flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl
                              bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs
                              font-semibold hover:bg-indigo-100 transition">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        Semester 2
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-2xl border border-gray-200 p-16 text-center">
            <div class="bg-gray-50 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                <i data-lucide="school" class="w-7 h-7 text-gray-300"></i>
            </div>
            <p class="text-sm font-medium text-gray-500">Belum ada data kelas</p>
        </div>
        @endforelse
    </div>

</div>
@endsection