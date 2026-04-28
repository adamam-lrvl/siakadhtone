{{-- resources/views/guru/nilai/pilih-kategori.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Pilih Kategori Nilai')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER BIRU --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="clipboard-list" class="w-6 h-6 flex-shrink-0"></i>
                    <span>Pilih kategori nilai</span>
                </h1>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2 text-sm text-blue-100">
                    <span class="flex items-center gap-1">
                        <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                        {{ $mapel->nama_mapel }}
                    </span>
                    <span class="text-blue-300">•</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="users" class="w-3.5 h-3.5"></i>
                        {{ $kelas->nama_kelas }}
                    </span>
                </div>
            </div>

            {{-- EXPORT --}}
            <div class="flex gap-2 flex-shrink-0">
                <a href="{{ route('guru.nilai.export.excel.kelas', [$kelas->id, $mapel->id]) }}"
                   class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25
                          text-white text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Excel</span>
                </a>
                <a href="{{ route('guru.nilai.export.pdf.kelas', [$kelas->id, $mapel->id]) }}"
                   class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25
                          text-white text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">PDF</span>
                </a>
            </div>
        </div>
    </div>

    {{-- SEMESTER 1 --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        {{-- HEADER CARD --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="bg-blue-50 rounded-xl p-2">
                    <i data-lucide="calendar" class="w-4 h-4 text-blue-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">Semester 1</p>
                    <p class="text-xs text-gray-400">{{ count($kategori) }} kategori penilaian</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                         bg-blue-50 text-blue-700 border border-blue-200">
                Ganjil
            </span>
        </div>

        {{-- GRID KATEGORI --}}
        <div class="p-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($kategori as $kat)
                    <a href="{{ route('guru.nilai.input-kategori', [$kelas->id, $mapel->id, $kat]) }}?semester=1"
                       class="group flex flex-col items-center gap-2.5 p-4 rounded-2xl border border-gray-200
                              hover:border-blue-300 hover:bg-blue-50/50 transition-all text-center">
                        <div class="bg-blue-50 group-hover:bg-blue-100 rounded-xl w-10 h-10
                                    flex items-center justify-center transition flex-shrink-0">
                            <i data-lucide="{{ str_starts_with($kat, 'tugas') ? 'file-text' : ($kat == 'uts' ? 'clipboard' : 'award') }}"
                               class="w-4 h-4 text-blue-600"></i>
                        </div>
                        <p class="font-semibold text-gray-800 text-xs leading-snug">
                            {{ ucwords(str_replace('_', ' ', $kat)) }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- SEMESTER 2 --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        {{-- HEADER CARD --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-50 rounded-xl p-2">
                    <i data-lucide="calendar" class="w-4 h-4 text-indigo-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">Semester 2</p>
                    <p class="text-xs text-gray-400">{{ count($kategori) }} kategori penilaian</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                         bg-indigo-50 text-indigo-700 border border-indigo-200">
                Genap
            </span>
        </div>

        {{-- GRID KATEGORI --}}
        <div class="p-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($kategori as $kat)
                    <a href="{{ route('guru.nilai.input-kategori', [$kelas->id, $mapel->id, $kat]) }}?semester=2"
                       class="group flex flex-col items-center gap-2.5 p-4 rounded-2xl border border-gray-200
                              hover:border-indigo-300 hover:bg-indigo-50/50 transition-all text-center">
                        <div class="bg-indigo-50 group-hover:bg-indigo-100 rounded-xl w-10 h-10
                                    flex items-center justify-center transition flex-shrink-0">
                            <i data-lucide="{{ str_starts_with($kat, 'tugas') ? 'file-text' : ($kat == 'uts' ? 'clipboard' : 'award') }}"
                               class="w-4 h-4 text-indigo-600"></i>
                        </div>
                        <p class="font-semibold text-gray-800 text-xs leading-snug">
                            {{ ucwords(str_replace('_', ' ', $kat)) }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- TOMBOL --}}
    <div class="flex justify-start">
        <a href="{{ route('guru.nilai.index') }}"
           class="px-5 py-2.5 border border-gray-200 rounded-xl text-gray-700 font-semibold
                  text-sm hover:bg-gray-50 hover:border-gray-300 transition
                  flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
</script>
@endsection