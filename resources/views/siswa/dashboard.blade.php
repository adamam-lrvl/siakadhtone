{{-- resources/views/siswa/dashboard.blade.php --}}
@extends('siswa.layouts.app')
@section('title', 'Dashboard Siswa')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <!-- HERO SELAMAT DATANG + LIVE CLOCK (PERSIS ADMIN) -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white shadow-2xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">
                    Selamat Datang, {{ Auth::user()->siswa->nama }}!
                </h1>
                <p class="text-blue-100 text-lg">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div class="mt-6 md:mt-0">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl px-8 py-5 text-center">
                    <p class="text-sm opacity-90">Waktu Sekarang</p>
                    <p class="text-4xl font-bold" id="liveClock">
                        {{ \Carbon\Carbon::now()->format('H:i:s') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- STAT CARDS SISWA -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Jadwal Hari Ini', 'value' => $jadwalsHariIni->count(), 'icon' => 'calendar-clock', 'color' => 'blue'],
                ['label' => 'Absensi Hadir',   'value' => $absensi['hadir'] ?? 0, 'icon' => 'check-circle-2', 'color' => 'green'],
                ['label' => 'Total Nilai',     'value' => $nilaiTerakhir->count(), 'icon' => 'trending-up', 'color' => 'indigo'],
                ['label' => 'Pengumuman',      'value' => $pengumuman->count(), 'icon' => 'megaphone', 'color' => 'purple'],
            ];
        @endphp

        @foreach($stats as $stat)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 hover:shadow-2xl transition transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ $stat['label'] }}</p>
                        <p class="text-4xl font-bold text-gray-900 mt-2">{{ $stat['value'] }}</p>
                    </div>
                    <div class="bg-{{ $stat['color'] }}-100 rounded-xl p-4">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-10 h-10 text-{{ $stat['color'] }}-600"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- PROFIL SISWA + JADWAL HARI INI -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- PROFIL SISWA -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center mb-5">
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-3 mr-4">
                        <i data-lucide="user" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Profil Siswa</h3>
                </div>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between py-3 border-b">
                        <span class="text-gray-600">Nama</span>
                        <span class="font-semibold">{{ Auth::user()->siswa->nama }}</span>
                    </div>
                    <div class="flex justify-between py-3 border-b">
                        <span class="text-gray-600">NIS</span>
                        <span class="font-semibold">{{ Auth::user()->siswa->nis ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-3 border-b">
                        <span class="text-gray-600">Kelas</span>
                        <span class="font-semibold">{{ Auth::user()->siswa->kelas->nama_kelas ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-3">
                        <span class="text-gray-600">Status</span>
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full font-bold text-xs">Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- JADWAL HARI INI -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl p-3 mr-4">
                            <i data-lucide="calendar-clock" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Jadwal Hari Ini</h3>
                    </div>
                    <span class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->translatedFormat('l') }}</span>
                </div>

                <div class="space-y-4">
                    @if($jadwalsHariIni->count() > 0)
                        @foreach($jadwalsHariIni as $j)
                            <div class="flex items-center p-5 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl hover:shadow-md transition">
                                <div class="bg-indigo-100 rounded-xl p-3 mr-4">
                                    <i data-lucide="clock" class="w-7 h-7 text-indigo-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-indigo-900">{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</p>
                                    <p class="font-semibold text-purple-700">{{ $j->mapel->nama_mapel }}</p>
                                    <p class="text-sm text-gray-600 mt-1">Guru: {{ $j->guru->nama }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center text-gray-500 py-8 font-medium">Tidak ada jadwal hari ini 😎</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LIVE CLOCK SCRIPT (PERSIS ADMIN) -->
<script>
    function updateClock() {
        const now = new Date();
        document.getElementById('liveClock').textContent = 
            now.toLocaleTimeString('id-ID', { timeZone: 'Asia/Jakarta', hour12: false });
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection