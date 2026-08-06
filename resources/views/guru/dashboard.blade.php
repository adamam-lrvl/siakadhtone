{{-- resources/views/guru/dashboard.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Dashboard Guru')

@section('content')
<div class="max-w-5xl mx-auto py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:border dark:border-white/[0.09]
                dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="relative px-7 py-7 flex items-start justify-between gap-4">
            <div class="min-w-0">
                <p class="text-xs font-semibold text-blue-300 dark:text-white/40 uppercase tracking-widest mb-1">Guru</p>
                <h1 class="text-2xl font-extrabold text-white dark:text-white/90 tracking-tight">
                    Selamat datang, {{ Auth::user()->name }}!
                </h1>
                <p class="text-blue-200 dark:text-white/40 text-sm mt-1.5">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div class="flex-shrink-0 bg-white/15 dark:bg-white/[0.07]
                        border border-white/20 dark:border-white/[0.09]
                        backdrop-blur-sm rounded-2xl px-5 py-3 text-center z-10">
                <p class="text-xs text-blue-300 dark:text-white/35 uppercase tracking-wide">Waktu</p>
                <p class="text-2xl font-extrabold text-white dark:text-white/80 tabular-nums mt-0.5" id="liveClock">
                    {{ \Carbon\Carbon::now()->format('H:i') }}
                </p>
            </div>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        @php
            $stats = [
                ['label' => 'Kelas diajar',    'value' => $totalKelas,             'icon' => 'school',         'from' => 'from-blue-500',   'to' => 'to-blue-600'],
                ['label' => 'Total siswa',     'value' => $totalSiswa,             'icon' => 'users',          'from' => 'from-indigo-500', 'to' => 'to-indigo-600'],
                ['label' => 'Mapel diajar',    'value' => $mapelDiajar,            'icon' => 'book-open',      'from' => 'from-violet-500', 'to' => 'to-purple-600'],
                ['label' => 'Jadwal hari ini', 'value' => $jadwalHariIni->count(), 'icon' => 'calendar-check', 'from' => 'from-emerald-500','to' => 'to-teal-600'],
            ];
        @endphp
        @foreach($stats as $s)
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                    border border-gray-200 dark:border-white/[0.07]
                    rounded-2xl p-5 hover:-translate-y-0.5 hover:shadow-lg dark:hover:bg-white/[0.08]
                    transition-all duration-200">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $s['from'] }} {{ $s['to'] }}
                        flex items-center justify-center mb-4">
                <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5 text-white"></i>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white/90 tracking-tight">{{ $s['value'] }}</p>
            <p class="text-xs text-gray-400 dark:text-white/35 mt-0.5">{{ $s['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- PROFIL + JADWAL HARI INI --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- PROFIL --}}
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                    border border-gray-200 dark:border-white/[0.07] rounded-2xl overflow-hidden">
            <div class="relative overflow-hidden px-5 py-4
                        bg-gradient-to-br from-blue-700 to-indigo-700
                        dark:bg-none dark:bg-white/[0.06]
                        dark:border-b dark:border-white/[0.08]">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_70%)] dark:opacity-25 pointer-events-none"></div>
                <div class="relative flex items-center gap-3">
                    <div class="bg-white/15 dark:bg-white/[0.08] backdrop-blur-sm border border-white/20 dark:border-white/[0.10] rounded-xl p-2.5">
                        <i data-lucide="user" class="w-5 h-5 text-white dark:text-white/80"></i>
                    </div>
                    <p class="font-semibold text-white dark:text-white/80">Profil guru</p>
                </div>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400 dark:text-white/30">Nama</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white/90 text-right max-w-[60%] truncate">{{ $guru->nama }}</span>
                </div>
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400 dark:text-white/30">NIP</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white/90">{{ $guru->nip ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400 dark:text-white/30">Email</span>
                    <span class="text-xs font-semibold text-gray-900 dark:text-white/90 text-right max-w-[60%] truncate">{{ $guru->user->email }}</span>
                </div>
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400 dark:text-white/30">Telepon</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white/90">{{ $guru->telepon ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- JADWAL HARI INI --}}
        <div class="lg:col-span-2 bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                    border border-gray-200 dark:border-white/[0.07] rounded-2xl overflow-hidden">
            <div class="relative overflow-hidden px-5 py-4
                        bg-gradient-to-br from-blue-700 to-indigo-700
                        dark:bg-none dark:bg-white/[0.06]
                        dark:border-b dark:border-white/[0.08]">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_70%)] dark:opacity-25 pointer-events-none"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/15 dark:bg-white/[0.08] backdrop-blur-sm border border-white/20 dark:border-white/[0.10] rounded-xl p-2.5">
                            <i data-lucide="calendar-clock" class="w-5 h-5 text-white dark:text-white/80"></i>
                        </div>
                        <p class="font-semibold text-white dark:text-white/80">Jadwal hari ini</p>
                    </div>
                    <span class="text-xs text-blue-200 dark:text-white/40 bg-white/10 dark:bg-white/[0.06]
                                 border border-white/15 dark:border-white/[0.08] px-2.5 py-1 rounded-full">
                        {{ \Carbon\Carbon::today()->translatedFormat('l') }}
                    </span>
                </div>
            </div>
            @if($jadwalHariIni->count() > 0)
                <div class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                    @foreach($jadwalHariIni as $j)
                    <div class="flex items-center gap-4 px-5 py-4 hover:bg-indigo-50/30 dark:hover:bg-white/[0.04] transition">
                        <div class="bg-indigo-50 dark:bg-indigo-500/15 rounded-xl p-2.5 flex-shrink-0">
                            <i data-lucide="book-open" class="w-4 h-4 text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 dark:text-white/90 truncate">{{ $j->mapel->nama_mapel }}</p>
                            <p class="text-xs text-gray-400 dark:text-white/35 mt-0.5">{{ $j->kelas->nama_kelas }}</p>
                        </div>
                        <span class="inline-flex items-center gap-1 text-xs font-semibold flex-shrink-0
                                     text-indigo-700 dark:text-indigo-300
                                     bg-indigo-50 dark:bg-indigo-500/15
                                     border border-indigo-200 dark:border-indigo-400/25 px-2.5 py-1 rounded-full">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} –
                            {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="calendar-x2" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
                    </div>
                    <p class="font-semibold text-gray-700 dark:text-white/60">Tidak ada jadwal hari ini</p>
                    <p class="text-xs text-gray-400 dark:text-white/30 mt-1">Nikmati hari libur Anda!</p>
                </div>
            @endif
        </div>
    </div>

    {{-- JADWAL MINGGU INI --}}
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                border border-gray-200 dark:border-white/[0.07] rounded-2xl overflow-hidden">
        <div class="relative overflow-hidden px-5 py-4
                    bg-gradient-to-br from-blue-700 to-indigo-700
                    dark:bg-none dark:bg-white/[0.06]
                    dark:border-b dark:border-white/[0.08]">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_70%)] dark:opacity-25 pointer-events-none"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-white/15 dark:bg-white/[0.08] backdrop-blur-sm border border-white/20 dark:border-white/[0.10] rounded-xl p-2.5">
                        <i data-lucide="calendar-range" class="w-5 h-5 text-white dark:text-white/80"></i>
                    </div>
                    <p class="font-semibold text-white dark:text-white/80">Jadwal minggu ini</p>
                </div>
                <span class="text-xs text-blue-200 dark:text-white/40 bg-white/10 dark:bg-white/[0.06]
                             border border-white/15 dark:border-white/[0.08] px-2.5 py-1 rounded-full">
                    {{ \Carbon\Carbon::now()->startOfWeek()->translatedFormat('d M') }} –
                    {{ \Carbon\Carbon::now()->endOfWeek()->translatedFormat('d M Y') }}
                </span>
            </div>
        </div>

        @php
            $hariUrut      = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $hariIniNama   = \Carbon\Carbon::today()->translatedFormat('l');
            $jadwalPerHari = $jadwalMingguIni->groupBy(fn($j) => ucfirst(strtolower($j->hari)));
        @endphp

        <div class="divide-y divide-gray-100 dark:divide-white/[0.05]">
            @foreach($hariUrut as $hari)
            @php
                $jadwalHari = $jadwalPerHari->get($hari, collect());
                $isToday    = strtolower($hari) === strtolower($hariIniNama);
            @endphp
            <div class="flex gap-4 px-5 py-4 {{ $isToday ? 'bg-indigo-50/40 dark:bg-indigo-500/[0.06]' : '' }}">
                <div class="w-16 flex-shrink-0 pt-0.5">
                    <p class="text-xs font-bold {{ $isToday ? 'text-indigo-700 dark:text-indigo-400' : 'text-gray-400 dark:text-white/30' }}">{{ $hari }}</p>
                    @if($isToday)
                        <span class="text-[10px] font-semibold text-indigo-400 dark:text-indigo-400">Hari ini</span>
                    @endif
                </div>
                <div class="flex-1 flex flex-wrap gap-2">
                    @forelse($jadwalHari as $j)
                        <div class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border
                                    {{ $isToday
                                        ? 'bg-white dark:bg-white/[0.07] border-indigo-200 dark:border-indigo-400/25'
                                        : 'bg-gray-50 dark:bg-white/[0.04] border-gray-200 dark:border-white/[0.07]' }}">
                            <i data-lucide="book-open"
                               class="w-3.5 h-3.5 flex-shrink-0 {{ $isToday ? 'text-indigo-500 dark:text-indigo-400' : 'text-gray-400 dark:text-white/35' }}"></i>
                            <div>
                                <p class="text-xs font-semibold text-gray-800 dark:text-white/80 leading-tight">{{ $j->mapel->nama_mapel }}</p>
                                <p class="text-[10px] text-gray-400 dark:text-white/35 mt-0.5">
                                    {{ $j->kelas->nama_kelas }} ·
                                    {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-300 dark:text-white/20 pt-1.5">Tidak ada jadwal</p>
                    @endforelse
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

<script>
function updateClock() {
    var el = document.getElementById('liveClock');
    if (el) el.textContent = new Date().toLocaleTimeString('id-ID', {
        timeZone: 'Asia/Jakarta', hour12: false, hour: '2-digit', minute: '2-digit'
    });
}
setInterval(updateClock, 1000);
updateClock();
</script>
@endsection