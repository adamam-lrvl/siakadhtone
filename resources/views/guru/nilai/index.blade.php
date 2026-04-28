{{-- resources/views/guru/nilai/index.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Input Nilai Siswa')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">

    <!-- HEADER GRADIENT (sama style absensi) -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold flex items-center gap-3">
                    <i data-lucide="book-open" class="w-8 h-8"></i>
                    Input Nilai Siswa
                </h1>
                <p class="text-blue-100 mt-2 text-lg">
                    Pilih mata pelajaran yang ingin diinput nilainya
                </p>
            </div>
            <div class="hidden md:block text-right">
                <div class="bg-white/20 rounded-2xl px-6 py-3">
                    <p class="text-sm opacity-90">Total Mata Pelajaran</p>
                    <p class="text-4xl font-bold">{{ $mapelGrouped->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- GRID CARD MAPEL (style card sama seperti absensi) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($mapelGrouped as $item)
        <div class="bg-white rounded-3xl border border-gray-200 p-6 hover:border-indigo-300 hover:shadow-2xl transition-all duration-300 group">

            <!-- Icon + Mapel Name -->
            <div class="flex items-start gap-4">
                <div class="bg-indigo-100 text-indigo-600 rounded-2xl p-3 flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <i data-lucide="book-open" class="w-7 h-7"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-xl text-gray-900 leading-tight">
                        {{ $item['mapel']->nama_mapel }}
                        @if($item['mapel']->kode)
                            <span class="text-sm font-normal text-gray-400">({{ $item['mapel']->kode }})</span>
                        @endif
                    </h3>
                    <p class="text-indigo-600 mt-1 flex items-center gap-1 text-sm">
                        <i data-lucide="users" class="w-4 h-4"></i>
                        {{ $item['kelas']->count() }} Kelas diajar
                    </p>
                </div>
            </div>

            <!-- List Kelas -->
            <div class="mt-6 space-y-3">
                @foreach($item['kelas'] as $kelas)
                    <a href="{{ route('guru.nilai.pilih-kategori', [$kelas->id, $item['mapel']->id]) }}"
                       class="block w-full text-center py-4 px-5 bg-white border border-gray-200 hover:border-indigo-400 hover:bg-indigo-50 rounded-2xl font-medium text-gray-700 hover:text-indigo-700 transition-all">
                        {{ $kelas->nama_kelas }}
                    </a>
                @endforeach
            </div>
        </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl border border-gray-200 p-16 text-center">
                <i data-lucide="book-x" class="w-16 h-16 mx-auto text-gray-300 mb-6"></i>
                <p class="text-2xl font-semibold text-gray-600">Belum ada mata pelajaran</p>
                <p class="text-gray-500 mt-2">Hubungi admin untuk menambahkan jadwal mengajar</p>
            </div>
        @endforelse
    </div>

    <!-- TOMBOL KEMBALI -->
    <div class="text-center pt-8">
        <a href="{{ route('guru.dashboard') }}"
           class="inline-flex items-center gap-3 px-10 py-4 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 text-white font-semibold rounded-3xl shadow-xl hover:shadow-2xl transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
            Kembali ke Dashboard
        </a>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
</script>
@endsection