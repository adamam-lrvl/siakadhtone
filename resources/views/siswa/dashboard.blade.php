{{-- resources/views/siswa/dashboard.blade.php --}}
@extends('siswa.layouts.app')
@section('title', 'Dashboard Siswa')

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
                <p class="text-xs font-semibold text-blue-300 dark:text-white/40 uppercase tracking-widest mb-1">Siswa</p>
                <h1 class="text-2xl font-extrabold text-white dark:text-white/90 tracking-tight">
                    Selamat datang, {{ Auth::user()->siswa->nama }}!
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
                ['label' => 'Jadwal hari ini', 'value' => $jadwalsHariIni->count(), 'icon' => 'calendar-clock', 'from' => 'from-blue-500',   'to' => 'to-blue-600'],
                ['label' => 'Absensi hadir',   'value' => $absensi['H'] ?? 0,       'icon' => 'check-circle-2', 'from' => 'from-emerald-500','to' => 'to-teal-600'],
                ['label' => 'Total nilai',     'value' => $nilaiTerakhir->count(),  'icon' => 'trending-up',    'from' => 'from-indigo-500', 'to' => 'to-indigo-600'],
                ['label' => 'Pengumuman',      'value' => $pengumuman->count(),     'icon' => 'megaphone',      'from' => 'from-violet-500', 'to' => 'to-purple-600'],
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

        {{-- PROFIL SISWA --}}
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl border border-gray-200 dark:border-white/[0.07] rounded-2xl overflow-hidden">
            <div class="relative overflow-hidden px-5 py-4
                        bg-gradient-to-br from-blue-700 to-indigo-700
                        dark:bg-none dark:bg-white/[0.06] dark:border-b dark:border-white/[0.08]">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_70%)] dark:opacity-25 pointer-events-none"></div>
                <div class="relative flex items-center gap-3">
                    <div class="bg-white/15 dark:bg-white/[0.08] border border-white/20 dark:border-white/[0.10] rounded-xl p-2.5">
                        <i data-lucide="user" class="w-5 h-5 text-white dark:text-white/80"></i>
                    </div>
                    <p class="font-semibold text-white dark:text-white/80">Profil siswa</p>
                </div>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                @foreach([
                    ['Nama', Auth::user()->siswa->nama, 'text-right max-w-[60%] truncate'],
                    ['NIS', Auth::user()->siswa->nis ?? '-', ''],
                    ['Kelas', Auth::user()->siswa->kelas->nama_kelas ?? '-', ''],
                ] as [$label, $val, $extra])
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400 dark:text-white/30">{{ $label }}</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white/90 {{ $extra }}">{{ $val }}</span>
                </div>
                @endforeach
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400 dark:text-white/30">Status</span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                                 bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-400
                                 border border-emerald-200 dark:border-emerald-500/25">
                        <i data-lucide="circle-dot" class="w-3 h-3"></i> Aktif
                    </span>
                </div>
            </div>
        </div>

        {{-- JADWAL HARI INI --}}
        <div class="lg:col-span-2 bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl border border-gray-200 dark:border-white/[0.07] rounded-2xl overflow-hidden">
            <div class="relative overflow-hidden px-5 py-4
                        bg-gradient-to-br from-blue-700 to-indigo-700
                        dark:bg-none dark:bg-white/[0.06] dark:border-b dark:border-white/[0.08]">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_70%)] dark:opacity-25 pointer-events-none"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/15 dark:bg-white/[0.08] border border-white/20 dark:border-white/[0.10] rounded-xl p-2.5">
                            <i data-lucide="calendar-clock" class="w-5 h-5 text-white dark:text-white/80"></i>
                        </div>
                        <p class="font-semibold text-white dark:text-white/80">Jadwal hari ini</p>
                    </div>
                    <span class="text-xs text-blue-200 dark:text-white/40 bg-white/10 dark:bg-white/[0.06] border border-white/15 dark:border-white/[0.08] px-2.5 py-1 rounded-full">
                        {{ \Carbon\Carbon::now()->translatedFormat('l') }}
                    </span>
                </div>
            </div>
            @if($jadwalsHariIni->count() > 0)
                <div class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                    @foreach($jadwalsHariIni as $j)
                    <div class="flex items-center gap-4 px-5 py-4 hover:bg-indigo-50/30 dark:hover:bg-white/[0.04] transition">
                        <div class="bg-indigo-50 dark:bg-indigo-500/15 rounded-xl p-2.5 flex-shrink-0">
                            <i data-lucide="book-open" class="w-4 h-4 text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 dark:text-white/90 truncate">{{ $j->mapel->nama_mapel }}</p>
                            <p class="text-xs text-gray-400 dark:text-white/35 mt-0.5">{{ $j->guru->nama }}</p>
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
                    <p class="text-xs text-gray-400 dark:text-white/30 mt-1">Nikmati waktu istirahatmu!</p>
                </div>
            @endif
        </div>
    </div>

    {{-- CARD JADWAL SEMESTER INI (BARU) --}}
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl border border-gray-200 dark:border-white/[0.07] rounded-2xl overflow-hidden">
        <div class="relative overflow-hidden px-5 py-4
                    bg-gradient-to-br from-indigo-700 to-violet-700
                    dark:bg-none dark:bg-white/[0.06] dark:border-b dark:border-white/[0.08]">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_70%)] dark:opacity-25 pointer-events-none"></div>
            <div class="relative flex items-center gap-3">
                <div class="bg-white/15 dark:bg-white/[0.08] border border-white/20 dark:border-white/[0.10] rounded-xl p-2.5">
                    <i data-lucide="calendar" class="w-5 h-5 text-white"></i>
                </div>
                <p class="font-semibold text-white dark:text-white/90">Jadwal Semester Ini</p>
            </div>
        </div>
        <div class="p-5">
            @if($jadwalSemester && $jadwalSemester->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-7 gap-4">
                    @foreach($hariUrut as $hari)
                        @php $jadwalHari = $jadwalSemester[$hari] ?? collect(); @endphp
                        <div class="border border-gray-200 dark:border-white/[0.08] rounded-2xl overflow-hidden bg-white dark:bg-white/[0.03]">
                            <div class="bg-gray-50 dark:bg-white/[0.06] px-4 py-3 text-center font-semibold text-sm border-b dark:border-white/[0.08]">
                                {{ $hari }}
                            </div>
                            <div class="divide-y dark:divide-white/[0.08] min-h-[160px] text-sm">
                                @if($jadwalHari->count() > 0)
                                    @foreach($jadwalHari as $j)
                                    <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-white/[0.04] transition">
                                        <p class="font-medium text-gray-900 dark:text-white truncate">{{ $j->mapel->nama_mapel }}</p>
                                        <p class="text-xs text-gray-500 dark:text-white/50">{{ $j->guru->nama ?? '-' }}</p>
                                        <p class="text-xs text-indigo-600 dark:text-indigo-400 mt-1 font-medium">
                                            {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} – 
                                            {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                        </p>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="flex items-center justify-center h-full py-10 text-gray-400 dark:text-white/30 text-sm">
                                        Tidak ada jadwal
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <i data-lucide="calendar" class="w-12 h-12 text-gray-300 dark:text-white/20 mx-auto mb-4"></i>
                    <p class="font-semibold text-gray-700 dark:text-white/60">Belum ada jadwal semester ini</p>
                </div>
            @endif
        </div>
    </div>

    {{-- CHART NILAI + ABSENSI --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- CHART NILAI --}}
        <div class="lg:col-span-2 bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl border border-gray-200 dark:border-white/[0.07] rounded-2xl overflow-hidden">
            <div class="relative overflow-hidden px-5 py-4
                        bg-gradient-to-br from-blue-700 to-indigo-700
                        dark:bg-none dark:bg-white/[0.06] dark:border-b dark:border-white/[0.08]">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_70%)] dark:opacity-25 pointer-events-none"></div>
                <div class="relative flex items-center gap-3">
                    <div class="bg-white/15 dark:bg-white/[0.08] border border-white/20 dark:border-white/[0.10] rounded-xl p-2.5">
                        <i data-lucide="bar-chart-3" class="w-5 h-5 text-white dark:text-white/80"></i>
                    </div>
                    <p class="font-semibold text-white dark:text-white/80">Grafik nilai</p>
                </div>
            </div>
            <div class="p-5">
                @if($nilaiTerakhir->count() > 0)
                    <div class="relative h-64">
                        <canvas id="chartNilai"></canvas>
                    </div>
                @else
                    <div class="text-center py-14">
                        <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="bar-chart-3" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
                        </div>
                        <p class="font-semibold text-gray-700 dark:text-white/60">Belum ada nilai</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- CHART ABSENSI PER MAPEL --}}
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl border border-gray-200 dark:border-white/[0.07] rounded-2xl overflow-hidden">
            <div class="relative overflow-hidden px-5 py-4
                        bg-gradient-to-br from-blue-700 to-indigo-700
                        dark:bg-none dark:bg-white/[0.06] dark:border-b dark:border-white/[0.08]">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_70%)] dark:opacity-25 pointer-events-none"></div>
                <div class="relative flex items-center gap-3">
                    <div class="bg-white/15 dark:bg-white/[0.08] border border-white/20 dark:border-white/[0.10] rounded-xl p-2.5">
                        <i data-lucide="pie-chart" class="w-5 h-5 text-white dark:text-white/80"></i>
                    </div>
                    <p class="font-semibold text-white dark:text-white/80">Absensi per Mapel</p>
                </div>
            </div>
            <div class="p-5">
                @if($absensiPerMapel->count() > 0)
                    <div class="relative h-64">
                        <canvas id="chartAbsensi"></canvas>
                    </div>
                @else
                    <div class="text-center py-14">
                        <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="pie-chart" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
                        </div>
                        <p class="font-semibold text-gray-700 dark:text-white/60">Belum ada data absensi bulan ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function updateClock() {
    var el = document.getElementById('liveClock');
    if (el) el.textContent = new Date().toLocaleTimeString('id-ID', { timeZone: 'Asia/Jakarta', hour12: false, hour: '2-digit', minute: '2-digit' });
}
setInterval(updateClock, 1000); updateClock();
</script>

{{-- DATA CHART --}}
@php
    // Chart Nilai
    $nilaiPerMapel = $nilaiTerakhir
        ->groupBy(fn($n) => $n->mapel->nama_mapel ?? '-')
        ->map(fn($group) => round($group->avg('nilai'), 1));

    $nilaiLabels = $nilaiPerMapel->keys()->toArray();
    $nilaiValues = $nilaiPerMapel->values()->toArray();

    // Chart Absensi Per Mapel
    $absensiLabels = $absensiPerMapel->pluck('mapel')->toArray();
    $absensiValues = $absensiPerMapel->pluck('persen_hadir')->toArray();

    // Hari untuk jadwal semester
    $hariUrut = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
@endphp

@if(!isset($__chartJsLoaded))
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endif

<script>
function initSiswaCharts() {
    var isDark = document.documentElement.classList.contains('dark');
    var gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.05)';
    var textColor = isDark ? 'rgba(255,255,255,0.45)' : '#6b7280';

    // === CHART NILAI ===
    var nilaiCanvas = document.getElementById('chartNilai');
    if (nilaiCanvas) {
        new Chart(nilaiCanvas, {
            type: 'bar',
            data: {
                labels: @json($nilaiLabels),
                datasets: [{
                    label: 'Rata-rata nilai',
                    data: @json($nilaiValues),
                    backgroundColor: '#2563eb',
                    borderRadius: 8,
                    maxBarThickness: 48,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: gridColor },
                        ticks: { color: textColor }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor }
                    }
                }
            }
        });
    }

    // === CHART ABSENSI PER MAPEL ===
    var absensiCanvas = document.getElementById('chartAbsensi');
    if (absensiCanvas && @json($absensiLabels).length > 0) {
        new Chart(absensiCanvas, {
            type: 'bar',
            data: {
                labels: @json($absensiLabels),
                datasets: [{
                    label: 'Persentase Hadir (%)',
                    data: @json($absensiValues),
                    backgroundColor: '#10b981',
                    borderColor: '#059669',
                    borderWidth: 2,
                    borderRadius: 8,
                    maxBarThickness: 50,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { 
                        display: true, 
                        position: 'top',
                        labels: { color: textColor, boxWidth: 12 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: gridColor },
                        ticks: { 
                            color: textColor,
                            callback: function(value) { return value + '%'; }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor, font: { size: 11 } }
                    }
                }
            }
        });
    }
}

// Wait for Chart.js
(function waitForChart(retries) {
    if (typeof Chart !== 'undefined') {
        initSiswaCharts();
    } else if (retries > 0) {
        setTimeout(function () { waitForChart(retries - 1); }, 150);
    }
})(20);
</script>
@endsection