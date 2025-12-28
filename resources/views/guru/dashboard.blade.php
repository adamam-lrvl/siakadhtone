@extends('guru.layouts.app')
@section('title', 'Dashboard Guru')
@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <!-- HERO -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white shadow-2xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p class="text-blue-100 text-lg">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="mt-6 md:mt-0">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl px-8 py-5 text-center">
                    <p class="text-sm opacity-90">Waktu Sekarang</p>
                    <p class="text-4xl font-bold" id="liveClock">{{ \Carbon\Carbon::now()->format('H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Total Kelas', 'value' => $totalKelas, 'icon' => 'school', 'color' => 'blue'],
                ['label' => 'Total Siswa', 'value' => $totalSiswa, 'icon' => 'users', 'color' => 'indigo'],
                ['label' => 'Mapel Diajar', 'value' => $mapelDiajar, 'icon' => 'book-open', 'color' => 'purple'],
                ['label' => 'Jadwal Hari Ini', 'value' => $jadwalHariIni->count(), 'icon' => 'calendar-check', 'color' => 'green'],
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

    <!-- PROFIL + JADWAL -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center mb-5">
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-3 mr-4">
                        <i data-lucide="user" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Profil Guru</h3>
                </div>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between py-3 border-b"><span class="text-gray-600">Nama</span><span class="font-semibold">{{ $guru->nama }}</span></div>
                    <div class="flex justify-between py-3 border-b"><span class="text-gray-600">NIP</span><span class="font-semibold">{{ $guru->nip ?? '-' }}</span></div>
                    <div class="flex justify-between py-3 border-b"><span class="text-gray-600">Email</span><span class="font-semibold text-xs">{{ $guru->user->email }}</span></div>
                    <div class="flex justify-between py-3"><span class="text-gray-600">Telepon</span><span class="font-semibold">{{ $guru->telepon ?? '-' }}</span></div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl p-3 mr-4">
                            <i data-lucide="calendar-clock" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Jadwal Hari Ini</h3>
                    </div>
                    <span class="text-sm text-gray-500">{{ \Carbon\Carbon::today()->translatedFormat('l') }}</span>
                </div>

                @if($jadwalHariIni->count() > 0)
                    <div class="space-y-4">
                        @foreach($jadwalHariIni as $j)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200 hover:shadow-lg transition">
                            <div class="mb-4 sm:mb-0">
                                <p class="font-bold text-gray-800 text-lg">{{ $j->mapel->nama_mapel }}</p>
                                <p class="text-gray-600">{{ $j->kelas->nama_kelas }} • {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</p>
                            </div>
                            <div class="flex gap-3">
                                <a href="{{ route('guru.absensi.create', $j->id) }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow transition">Absen</a>
                                <a href="{{ route('guru.absensi.show', $j->id) }}" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow transition">Rekap</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20">
                        <i data-lucide="calendar-x2" class="w-24 h-24 mx-auto text-gray-300 mb-4"></i>
                        <p class="text-2xl font-bold text-gray-600">Hari Libur!</p>
                        <p class="text-gray-500 mt-2">Nikmati waktu istirahat Anda</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        document.getElementById('liveClock').textContent = now.toLocaleTimeString('id-ID', { timeZone: 'Asia/Jakarta', hour12: false });
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection