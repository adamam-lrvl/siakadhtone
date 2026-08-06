{{-- resources/views/kepala-sekolah/dashboard.blade.php --}}
@extends('kepala-sekolah.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="max-w-6xl mx-auto py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:border dark:border-white/[0.09]
                dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="relative px-7 py-7 flex items-start justify-between gap-4">
            <div class="min-w-0">
                <p class="text-xs font-semibold text-blue-300 dark:text-white/40 uppercase tracking-widest mb-1">Kepala Sekolah</p>
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
                ['label' => 'Total siswa',        'value' => $totalSiswa,         'icon' => 'user-check', 'from' => 'from-blue-500',   'to' => 'to-blue-600',   'route' => null],
                ['label' => 'Total guru',         'value' => $totalGuru,          'icon' => 'users',      'from' => 'from-indigo-500', 'to' => 'to-indigo-600', 'route' => null],
                ['label' => 'Total kelas',        'value' => $totalKelas,         'icon' => 'school',     'from' => 'from-violet-500', 'to' => 'to-purple-600', 'route' => null],
                ['label' => 'Pengumuman pending', 'value' => $pendingPengumuman,  'icon' => 'megaphone',  'from' => 'from-amber-500',  'to' => 'to-orange-500', 'route' => 'kepsek.pengumuman.index'],
            ];
        @endphp
        @foreach($stats as $s)
        @php $tag = $s['route'] ? 'a' : 'div'; @endphp
        <{{ $tag }} {{ $s['route'] ? 'href="'.route($s['route']).'"' : '' }}
           class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                  border border-gray-200 dark:border-white/[0.07]
                  rounded-2xl p-5 hover:-translate-y-0.5 hover:shadow-lg dark:hover:bg-white/[0.08]
                  transition-all duration-200
                  {{ $loop->last && $s['value'] > 0 ? 'ring-2 ring-amber-300 dark:ring-amber-500/40' : '' }}">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $s['from'] }} {{ $s['to'] }}
                        flex items-center justify-center mb-4">
                <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5 text-white"></i>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white/90 tracking-tight">{{ $s['value'] }}</p>
            <p class="text-xs text-gray-400 dark:text-white/35 mt-0.5">{{ $s['label'] }}</p>
        </{{ $tag }}>
        @endforeach
    </div>

    {{-- CHARTS --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- Pie: Siswa per Jurusan --}}
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                    border border-gray-200 dark:border-white/[0.07] rounded-2xl p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-blue-50 dark:bg-blue-500/15 rounded-xl p-2">
                    <i data-lucide="pie-chart" class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white/90 text-sm">Siswa per jurusan</p>
                    <p class="text-xs text-gray-400 dark:text-white/35">Distribusi seluruh siswa</p>
                </div>
            </div>
            <div class="relative h-56">
                <canvas id="chartJurusan"></canvas>
            </div>
        </div>

        {{-- Bar: Absensi Bulan Ini --}}
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                    border border-gray-200 dark:border-white/[0.07] rounded-2xl p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-indigo-50 dark:bg-indigo-500/15 rounded-xl p-2">
                    <i data-lucide="bar-chart-2" class="w-4 h-4 text-indigo-600 dark:text-indigo-400"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white/90 text-sm">Rekap absensi bulan ini</p>
                    <p class="text-xs text-gray-400 dark:text-white/35">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
                </div>
            </div>
            <div class="relative h-56">
                <canvas id="chartAbsensi"></canvas>
            </div>
        </div>

        {{-- Bar: Siswa per Kelas --}}
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                    border border-gray-200 dark:border-white/[0.07] rounded-2xl p-5 lg:col-span-2">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-purple-50 dark:bg-purple-500/15 rounded-xl p-2">
                    <i data-lucide="bar-chart" class="w-4 h-4 text-purple-600 dark:text-purple-400"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white/90 text-sm">Jumlah siswa per kelas</p>
                    <p class="text-xs text-gray-400 dark:text-white/35">Seluruh kelas aktif</p>
                </div>
            </div>
            <div class="relative h-56">
                <canvas id="chartKelas"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateClock() {
    var el = document.getElementById('liveClock');
    if (el) el.textContent = new Date().toLocaleTimeString('id-ID', {
        timeZone: 'Asia/Jakarta', hour12: false, hour: '2-digit', minute: '2-digit'
    });
}
setInterval(updateClock, 1000);
updateClock();

// Helper: warna sesuai dark mode
var isDark = document.documentElement.classList.contains('dark');
var gridColor  = isDark ? 'rgba(255,255,255,0.06)' : '#f3f4f6';
var tickColor  = isDark ? 'rgba(255,255,255,0.40)' : '#6b7280';
var legendColor = isDark ? 'rgba(255,255,255,0.60)' : '#374151';

// DATA
var jurusanLabels = @json($siswasPerJurusan->keys());
var jurusanData   = @json($siswasPerJurusan->values());
var absensiData   = { H: {{ $absensiStats['H'] ?? 0 }}, I: {{ $absensiStats['I'] ?? 0 }}, S: {{ $absensiStats['S'] ?? 0 }}, A: {{ $absensiStats['A'] ?? 0 }} };
var kelasLabels   = @json($siswasPerKelas->keys());
var kelasData     = @json($siswasPerKelas->values());

// Chart 1: Doughnut jurusan
new Chart(document.getElementById('chartJurusan'), {
    type: 'doughnut',
    data: {
        labels: jurusanLabels,
        datasets: [{ data: jurusanData, backgroundColor: ['#3b82f6','#6366f1','#8b5cf6','#06b6d4','#10b981','#f59e0b'], borderWidth: 2, borderColor: isDark ? 'rgba(255,255,255,0.05)' : '#fff' }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 12, color: legendColor } } }
    }
});

// Chart 2: Bar absensi
new Chart(document.getElementById('chartAbsensi'), {
    type: 'bar',
    data: {
        labels: ['Hadir','Izin','Sakit','Alpa'],
        datasets: [{ label: 'Jumlah', data: [absensiData.H, absensiData.I, absensiData.S, absensiData.A], backgroundColor: ['#10b981','#3b82f6','#f59e0b','#ef4444'], borderRadius: 8, borderWidth: 0 }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: gridColor }, ticks: { font: { size: 11 }, color: tickColor } },
            x: { grid: { display: false }, ticks: { font: { size: 11 }, color: tickColor } }
        }
    }
});

// Chart 3: Bar siswa per kelas
new Chart(document.getElementById('chartKelas'), {
    type: 'bar',
    data: {
        labels: kelasLabels,
        datasets: [{ label: 'Jumlah siswa', data: kelasData, backgroundColor: isDark ? 'rgba(99,102,241,0.70)' : '#6366f1', borderRadius: 6, borderWidth: 0 }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: gridColor }, ticks: { font: { size: 11 }, color: tickColor } },
            x: { grid: { display: false }, ticks: { font: { size: 11 }, color: tickColor } }
        }
    }
});
</script>
@endpush