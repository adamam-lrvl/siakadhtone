@extends('guru.layouts.app')
@section('title', 'Dashboard Guru')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6 space-y-6">

    {{-- HERO --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold">Selamat datang, {{ Auth::user()->name }}!</h1>
                <p class="text-blue-100 text-sm mt-1">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div class="bg-white/15 rounded-xl px-4 py-2 text-center flex-shrink-0">
                <p class="text-xs text-blue-100">Waktu</p>
                <p class="text-xl font-bold tabular-nums" id="liveClock">
                    {{ \Carbon\Carbon::now()->format('H:i') }}
                </p>
            </div>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        @php
            $stats = [
                ['label' => 'Kelas diajar',    'value' => $totalKelas,             'icon' => 'school',          'bg' => 'bg-blue-50',   'text' => 'text-blue-600'],
                ['label' => 'Total siswa',     'value' => $totalSiswa,             'icon' => 'users',           'bg' => 'bg-indigo-50', 'text' => 'text-indigo-600'],
                ['label' => 'Mapel diajar',    'value' => $mapelDiajar,            'icon' => 'book-open',       'bg' => 'bg-purple-50', 'text' => 'text-purple-600'],
                ['label' => 'Jadwal hari ini', 'value' => $jadwalHariIni->count(), 'icon' => 'calendar-check', 'bg' => 'bg-emerald-50','text' => 'text-emerald-600'],
            ];
        @endphp
        @foreach($stats as $s)
        <div class="bg-white rounded-2xl border border-gray-200 p-4 hover:border-indigo-300 transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="{{ $s['bg'] }} rounded-xl p-2.5">
                    <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5 {{ $s['text'] }}"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $s['value'] }}</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ $s['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- PROFIL + JADWAL --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- PROFIL --}}
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-5 py-4 text-white">
                <div class="flex items-center gap-3">
                    <div class="bg-white/15 rounded-xl p-2.5">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </div>
                    <p class="font-semibold">Profil guru</p>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400">Nama</span>
                    <span class="text-sm font-semibold text-gray-900 text-right max-w-[60%] truncate">
                        {{ $guru->nama }}
                    </span>
                </div>
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400">NIP</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $guru->nip ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400">Email</span>
                    <span class="text-xs font-semibold text-gray-900 text-right max-w-[60%] truncate">
                        {{ $guru->user->email }}
                    </span>
                </div>
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400">Telepon</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $guru->telepon ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- JADWAL HARI INI --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-5 py-4 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/15 rounded-xl p-2.5">
                            <i data-lucide="calendar-clock" class="w-5 h-5"></i>
                        </div>
                        <p class="font-semibold">Jadwal hari ini</p>
                    </div>
                    <span class="text-xs text-blue-100">
                        {{ \Carbon\Carbon::today()->translatedFormat('l') }}
                    </span>
                </div>
            </div>

            @if($jadwalHariIni->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($jadwalHariIni as $j)
                    <div class="flex items-center gap-4 px-5 py-4 hover:bg-indigo-50/30 transition">
                        <div class="bg-indigo-50 rounded-xl p-2.5 flex-shrink-0">
                            <i data-lucide="book-open" class="w-4 h-4 text-indigo-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $j->mapel->nama_mapel }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $j->kelas->nama_kelas }}</p>
                        </div>
                        <div class="flex-shrink-0 text-right">
                            <span class="inline-flex items-center gap-1 text-xs font-semibold
                                         text-indigo-700 bg-indigo-50 border border-indigo-200
                                         px-2.5 py-1 rounded-full">
                                <i data-lucide="clock" class="w-3 h-3"></i>
                                {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} –
                                {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div class="bg-gray-50 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="calendar-x2" class="w-7 h-7 text-gray-300"></i>
                    </div>
                    <p class="font-semibold text-gray-700">Tidak ada jadwal hari ini</p>
                    <p class="text-xs text-gray-400 mt-1">Nikmati hari libur Anda!</p>
                </div>
            @endif
        </div>

    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        document.getElementById('liveClock').textContent =
            now.toLocaleTimeString('id-ID', { timeZone: 'Asia/Jakarta', hour12: false, hour: '2-digit', minute: '2-digit' });
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection