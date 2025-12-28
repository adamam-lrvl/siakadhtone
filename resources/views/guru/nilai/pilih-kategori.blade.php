{{-- resources/views/guru/nilai/pilih-kategori.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Pilih Kategori Nilai')

@section('content')
<div class="min-h-screen bg-gray-50 px-4 py-12">

    <!-- CARD UTAMA SIMPLE & ELEGAN -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-lg border border-indigo-100 overflow-hidden">

            <!-- HEADER INDIGO-PURPLE RENDAH -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white px-8 py-8 text-center">
                <h2 class="text-3xl font-bold mb-3">
                    Pilih Kategori Nilai
                </h2>
                <div class="text-indigo-100 text-lg space-y-1">
                    <p><span class="font-semibold">Mata Pelajaran:</span> {{ $mapel->nama_mapel }}</p>
                    <p><span class="font-semibold">Kelas:</span> {{ $kelas->nama_kelas }}</p>
                </div>
            </div>

            <!-- GRID KATEGORI — SIMPLE CARD RENDAH -->
            <div class="p-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($kategori as $kat)
                        <a href="{{ route('guru.nilai.input-kategori', [$kelas->id, $mapel->id, $kat]) }}"
                           class="block bg-gradient-to-br from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-2xl text-center py-8 shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                            <p class="text-2xl font-extrabold mb-1">
                                {{ strtoupper(substr(str_replace('_', ' ', $kat), 0, 1)) }}
                            </p>
                            <p class="text-sm font-medium tracking-wide">
                                {{ ucwords(str_replace('_', ' ', $kat)) }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- TOMBOL KEMBALI + REKAP NILAI -->
            <div class="px-8 py-6 bg-gray-50 border-t border-indigo-100">
                <div class="flex flex-col sm:flex-row gap-5 justify-center items-center">
                    <!-- KEMBALI -->
                    <a href="{{ route('guru.nilai.index') }}"
                       class="inline-flex items-center gap-3 px-8 py-3.5 bg-gradient-to-r from-gray-600 to-gray-800 hover:from-gray-700 hover:to-gray-900 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                        Kembali
                    </a>

                    <!-- TOMBOL REKAP NILAI -->
                    <a href="{{ route('guru.nilai.show', [$kelas->id, $mapel->id]) }}"
                    class="inline-flex items-center gap-3 px-10 py-3.5 bg-gradient-to-r from-green-600 to-teal-700 hover:from-green-700 hover:to-teal-800 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition">
                        <i data-lucide="table-properties" class="w-6 h-6"></i>
                        Lihat Rekap Nilai
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
</script>
@endsection