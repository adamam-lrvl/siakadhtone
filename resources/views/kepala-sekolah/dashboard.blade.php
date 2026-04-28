{{-- resources/views/kepala-sekolah/dashboard.blade.php --}}
@extends('kepala-sekolah.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

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
                ['label' => 'Total siswa',   'value' => $totalSiswa,         'icon' => 'user-check',  'bg' => 'bg-blue-50',   'text' => 'text-blue-600'],
                ['label' => 'Total guru',    'value' => $totalGuru,          'icon' => 'users',       'bg' => 'bg-indigo-50', 'text' => 'text-indigo-600'],
                ['label' => 'Total kelas',   'value' => $totalKelas,         'icon' => 'school',      'bg' => 'bg-purple-50', 'text' => 'text-purple-600'],
                ['label' => 'Pengumuman pending', 'value' => $pendingPengumuman, 'icon' => 'megaphone', 'bg' => 'bg-amber-50', 'text' => 'text-amber-600'],
            ];
        @endphp
        @foreach($stats as $s)
        <a href="{{ $loop->last ? route('kepsek.pengumuman.index') : '#' }}"
           class="bg-white rounded-2xl border border-gray-200 p-4 hover:border-indigo-300
                  transition-all {{ $loop->last && $s['value'] > 0 ? 'ring-2 ring-amber-300' : '' }}">
            <div class="mb-3">
                <div class="{{ $s['bg'] }} rounded-xl p-2.5 inline-flex">
                    <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5 {{ $s['text'] }}"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $s['value'] }}</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ $s['label'] }}</p>
        </a>
        @endforeach
    </div>

    {{-- CHARTS --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- Chart: Siswa per Jurusan --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-blue-50 rounded-xl p-2">
                    <i data-lucide="pie-chart" class="w-4 h-4 text-blue-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">Siswa per jurusan</p>
                    <p class="text-xs text-gray-400">Distribusi seluruh siswa</p>
                </div>
            </div>
            <div class="relative h-56">
                <canvas id="chartJurusan"></canvas>
            </div>
        </div>

        {{-- Chart: Absensi Bulan Ini --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-indigo-50 rounded-xl p-2">
                    <i data-lucide="bar-chart-2" class="w-4 h-4 text-indigo-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">Rekap absensi bulan ini</p>
                    <p class="text-xs text-gray-400">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
                </div>
            </div>
            <div class="relative h-56">
                <canvas id="chartAbsensi"></canvas>
            </div>
        </div>

        {{-- Chart: Siswa per Kelas --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5 lg:col-span-2">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-purple-50 rounded-xl p-2">
                    <i data-lucide="bar-chart" class="w-4 h-4 text-purple-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">Jumlah siswa per kelas</p>
                    <p class="text-xs text-gray-400">Seluruh kelas aktif</p>
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
    const now = new Date();
    document.getElementById('liveClock').textContent =
        now.toLocaleTimeString('id-ID', {
            timeZone: 'Asia/Jakarta',
            hour12: false,
            hour: '2-digit',
            minute: '2-digit'
        });
}
setInterval(updateClock, 1000);
updateClock();

// DATA DARI LARAVEL
const jurusanLabels = @json($siswasPerJurusan->keys());
const jurusanData   = @json($siswasPerJurusan->values());

const absensiData = {
    H: {{ $absensiStats['H'] ?? 0 }},
    I: {{ $absensiStats['I'] ?? 0 }},
    S: {{ $absensiStats['S'] ?? 0 }},
    A: {{ $absensiStats['A'] ?? 0 }},
};

const kelasLabels = @json($siswasPerKelas->keys());
const kelasData   = @json($siswasPerKelas->values());

// CHART 1: Pie jurusan
new Chart(document.getElementById('chartJurusan'), {
    type: 'doughnut',
    data: {
        labels: jurusanLabels,
        datasets: [{
            data: jurusanData,
            backgroundColor: ['#3b82f6','#6366f1','#8b5cf6','#06b6d4','#10b981','#f59e0b'],
            borderWidth: 2,
            borderColor: '#fff',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 12 } }
        }
    }
});

// CHART 2: Bar absensi
new Chart(document.getElementById('chartAbsensi'), {
    type: 'bar',
    data: {
        labels: ['Hadir', 'Izin', 'Sakit', 'Alpa'],
        datasets: [{
            label: 'Jumlah',
            data: [absensiData.H, absensiData.I, absensiData.S, absensiData.A],
            backgroundColor: ['#10b981','#3b82f6','#f59e0b','#ef4444'],
            borderRadius: 8,
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { font: { size: 11 } } },
            x: { grid: { display: false }, ticks: { font: { size: 11 } } }
        }
    }
});

// CHART 3: Bar siswa per kelas
new Chart(document.getElementById('chartKelas'), {
    type: 'bar',
    data: {
        labels: kelasLabels,
        datasets: [{
            label: 'Jumlah siswa',
            data: kelasData,
            backgroundColor: '#6366f1',
            borderRadius: 6,
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { font: { size: 11 } } },
            x: { grid: { display: false }, ticks: { font: { size: 11 } } }
        }
    }
});
</script>
@endpush