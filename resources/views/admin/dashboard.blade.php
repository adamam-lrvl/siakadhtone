{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <!-- HERO SELAMAT DATANG -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white shadow-2xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">
                    Selamat Datang, {{ Auth::user()->name }}!
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

    <!-- STAT CARDS — REAL DATA -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Total Guru',    'value' => $totalGuru ?? 0,    'icon' => 'users',       'color' => 'blue'],
                ['label' => 'Total Siswa',   'value' => $totalSiswa ?? 0,   'icon' => 'user-check',  'color' => 'indigo'],
                ['label' => 'Total Kelas',   'value' => $totalKelas ?? 0,   'icon' => 'school',      'color' => 'purple'],
                ['label' => 'Mata Pelajaran', 'value' => $totalMapel ?? 0,  'icon' => 'book-open',   'color' => 'green'],
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

    <!-- PROFIL ADMIN + AKTIVITAS TERBARU (REAL + ICON RELEVAN) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- PROFIL ADMIN -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center mb-5">
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-3 mr-4">
                        <i data-lucide="shield" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Profil Admin</h3>
                </div>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between py-3 border-b">
                        <span class="text-gray-600">Nama</span>
                        <span class="font-semibold">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="flex justify-between py-3 border-b">
                        <span class="text-gray-600">Email</span>
                        <span class="font-semibold text-xs break-all">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="flex justify-between py-3 border-b">
                        <span class="text-gray-600">Role</span>
                        <span class="px-3 py-1 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-full text-xs font-bold">SUPER ADMIN</span>
                    </div>
                    <div class="flex justify-between py-3">
                        <span class="text-gray-600">Status</span>
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full font-bold text-xs">Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- AKTIVITAS TERBARU — DENGAN ICON RELEVAN -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl p-3 mr-4">
                            <i data-lucide="activity" class="w-8 h-8 text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Aktivitas Terbaru</h3>
                    </div>
                    <span class="text-sm text-gray-500">Hari Ini</span>
                </div>

                <div class="space-y-4">
                    @forelse($activities as $activity)
                        @php
                            // ICON & WARNA DINAMIS BERDASARKAN SUBJECT & EVENT
                            $icon = 'activity';
                            $color = 'gray';

                            if ($activity->subject_type) {
                                $type = class_basename($activity->subject_type);
                                $event = $activity->event ?? 'updated';

                                if ($type === 'Guru') {
                                    $icon = $event === 'created' ? 'user-plus' : ($event === 'deleted' ? 'user-minus' : 'user-pen');
                                    $color = $event === 'created' ? 'emerald' : ($event === 'deleted' ? 'red' : 'blue');
                                } elseif ($type === 'Siswa') {
                                    $icon = $event === 'created' ? 'user-plus' : ($event === 'deleted' ? 'user-minus' : 'user-pen');
                                    $color = $event === 'created' ? 'emerald' : ($event === 'deleted' ? 'red' : 'indigo');
                                } elseif ($type === 'Kelas') {
                                    $icon = $event === 'created' ? 'school' : ($event === 'deleted' ? 'building-2' : 'school');
                                    $color = $event === 'created' ? 'purple' : ($event === 'deleted' ? 'red' : 'purple');
                                } elseif ($type === 'Mapel') {
                                    $icon = $event === 'created' ? 'book-open' : ($event === 'deleted' ? 'book-x' : 'book');
                                    $color = $event === 'created' ? 'green' : ($event === 'deleted' ? 'red' : 'green');
                                }
                            }
                        @endphp

                        <div class="flex items-center p-5 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl hover:shadow-md transition">
                            <div class="bg-{{ $color }}-100 rounded-xl p-3 mr-4">
                                <i data-lucide="{{ $icon }}" class="w-7 h-7 text-{{ $color }}-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">
                                    {{ $activity->description }}
                                    @if($activity->subject)
                                        <span class="font-normal text-gray-600">
                                            : {{ $activity->subject->nama ?? $activity->subject->nama_kelas ?? $activity->subject->nama_mapel ?? 'Data' }}
                                        </span>
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Oleh: {{ $activity->causer->name ?? 'System' }} • 
                                    {{ $activity->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-8 font-medium">Belum ada aktivitas hari ini</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LIVE CLOCK -->
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