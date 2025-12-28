{{-- resources/views/guru/absensi/index.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Absensi Hari Ini')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- HEADER CARD -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white shadow-xl mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2 flex items-center">
                    <i data-lucide="calendar-check" class="w-10 h-10 mr-3"></i>
                    Absensi Hari Ini
                </h1>
                <p class="text-blue-100 text-lg">
                    {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div class="mt-6 md:mt-0 text-right">
                <div class="text-5xl font-bold">{{ $jadwals->count() }}</div>
                <div class="text-blue-200">Jadwal Mengajar</div>
            </div>
        </div>
    </div>

    <!-- DAFTAR JADWAL -->
    <div class="grid gap-6">
        @forelse($jadwals as $j)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-2xl transition-all duration-300">
            <div class="p-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">

                    <!-- INFO KIRI -->
                    <div class="flex-1">
                        <div class="flex items-start gap-4">
                            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-4 text-white">
                                <i data-lucide="book-open" class="w-8 h-8"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    {{ $j->mapel->nama_mapel }}
                                    @if($j->mapel->kode)
                                        <span class="text-sm font-normal text-gray-500 ml-2">({{ $j->mapel->kode }})</span>
                                    @endif
                                </h3>
                                <div class="mt-2 space-y-1 text-gray-600">
                                    <p class="flex items-center text-lg">
                                        <i data-lucide="users" class="w-5 h-5 mr-2 text-indigo-600"></i>
                                        <strong>{{ $j->kelas->nama_kelas }}</strong>
                                    </p>
                                    <p class="flex items-center text-lg">
                                        <i data-lucide="clock" class="w-5 h-5 mr-2 text-purple-600"></i>
                                        {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STATUS + AKSI -->
                    <div class="flex flex-col items-end gap-4">
                        <!-- STATUS BADGE -->
                        @if($j->absensi->count() > 0)
                            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-emerald-100 text-emerald-800 border-2 border-emerald-300">
                                <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                                SUDAH DIABSEN
                            </div>
                        @else
                            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-orange-100 text-orange-800 border-2 border-orange-300">
                                <i data-lucide="clock" class="w-5 h-5 mr-2"></i>
                                BELUM DIABSEN
                            </div>
                        @endif

                        <!-- TOMBOL AKSI -->
                        <div class="flex gap-3">
                            @if($j->absensi->count() == 0)
                                <a href="{{ route('guru.absensi.create', $j) }}" 
                                   class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 flex items-center text-lg">
                                    <i data-lucide="user-check" class="w-6 h-6 mr-3"></i>
                                    ABSEN SEKARANG
                                </a>
                            @else
                                <a href="{{ route('guru.absensi.show', $j) }}" 
                                   class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition flex items-center">
                                    <i data-lucide="eye" class="w-5 h-5 mr-2"></i>
                                    Lihat Rekap
                                </a>
                                <a href="{{ route('guru.absensi.edit', $j) }}" 
                                   class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition flex items-center">
                                    <i data-lucide="edit-3" class="w-5 h-5 mr-2"></i>
                                    Edit Absen
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-20 text-center">
            <i data-lucide="calendar-x2" class="w-24 h-24 mx-auto text-gray-300 mb-6"></i>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">Tidak Ada Jadwal Hari Ini</h3>
            <p class="text-gray-500 text-lg">Nikmati hari libur Anda!</p>
        </div>
        @endforelse
    </div>
</div>
@endsection