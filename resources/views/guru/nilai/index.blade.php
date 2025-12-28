{{-- resources/views/guru/nilai/index.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Input Nilai Siswa')

@section('content')
<div class="min-h-screen bg-gray-50 px-4 py-8">

    <!-- HEADER INDIGO-PURPLE -->
    <div class="max-w-4xl mx-auto text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-extrabold text-indigo-900 mb-4">
            Input Nilai Siswa
        </h1>
        <p class="text-lg md:text-xl text-indigo-700">
            Pilih mata pelajaran dan kelas untuk mulai menginput nilai
        </p>
    </div>

    <!-- GRID CARD MAPEL — SATU CARD PER MAPEL -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($mapelGrouped as $item)
            <div class="bg-white rounded-3xl shadow-xl border border-indigo-100 overflow-hidden hover:shadow-2xl hover:-translate-y-3 transition-all duration-300 transform">
                
                <!-- Header Gradient Indigo-Purple -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white p-8 text-center">
                    <h3 class="text-2xl md:text-3xl font-bold">{{ $item['mapel']->nama_mapel }}</h3>
                    <p class="mt-4 text-indigo-100 text-lg font-medium">
                        {{ $item['kelas']->count() }} kelas diajar
                    </p>
                </div>

                <!-- List Kelas — Premium Button -->
                <div class="p-6 space-y-4">
                    @if($item['kelas']->count() > 0)
                        @foreach($item['kelas'] as $kelas)
                            <a href="{{ route('guru.nilai.pilih-kategori', [$kelas->id, $item['mapel']->id]) }}"
                               class="block text-center py-4 px-6 bg-gradient-to-r from-purple-600 to-indigo-700 hover:from-purple-700 hover:to-indigo-800 text-white font-bold text-base md:text-lg rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                                {{ $kelas->nama_kelas }}
                            </a>
                        @endforeach
                    @else
                        <p class="text-center text-gray-500 py-10 text-base">Belum ada kelas</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-32">
                <div class="bg-gray-100 rounded-full w-40 h-40 mx-auto mb-8 flex items-center justify-center">
                    <i data-lucide="book-open" class="w-20 h-20 text-gray-400"></i>
                </div>
                <p class="text-2xl md:text-3xl font-bold text-gray-600">
                    Belum ada mata pelajaran yang diajar
                </p>
                <p class="text-gray-500 mt-4 text-lg">
                    Hubungi admin untuk menambahkan jadwal mengajar
                </p>
            </div>
        @endforelse
    </div>

    <!-- TOMBOL KEMBALI INDIGO-PURPLE -->
    <div class="mt-16 text-center">
        <a href="{{ route('guru.dashboard') }}"
           class="inline-flex items-center justify-center gap-4 px-12 py-5 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 text-white font-bold text-xl rounded-2xl shadow-2xl hover:shadow-3xl transform hover:scale-110 transition-all duration-300">
            <i data-lucide="arrow-left" class="w-7 h-7"></i>
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