{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Dashboard Admin')

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
                ['label' => 'Total guru',      'value' => $totalGuru ?? 0,  'icon' => 'users',      'bg' => 'bg-blue-50',   'text' => 'text-blue-600'],
                ['label' => 'Total siswa',     'value' => $totalSiswa ?? 0, 'icon' => 'user-check', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-600'],
                ['label' => 'Total kelas',     'value' => $totalKelas ?? 0, 'icon' => 'school',     'bg' => 'bg-purple-50', 'text' => 'text-purple-600'],
                ['label' => 'Mata pelajaran',  'value' => $totalMapel ?? 0, 'icon' => 'book-open',  'bg' => 'bg-emerald-50','text' => 'text-emerald-600'],
            ];
        @endphp
        @foreach($stats as $s)
        <div class="bg-white rounded-2xl border border-gray-200 p-4 hover:border-indigo-300 transition-all">
            <div class="mb-3">
                <div class="{{ $s['bg'] }} rounded-xl p-2.5 inline-flex">
                    <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5 {{ $s['text'] }}"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $s['value'] }}</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ $s['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- PROFIL + AKTIVITAS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- PROFIL ADMIN --}}
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-5 py-4 text-white">
                <div class="flex items-center gap-3">
                    <div class="bg-white/15 rounded-xl p-2.5">
                        <i data-lucide="shield" class="w-5 h-5"></i>
                    </div>
                    <p class="font-semibold">Profil admin</p>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400">Nama</span>
                    <span class="text-sm font-semibold text-gray-900 text-right max-w-[60%] truncate">
                        {{ Auth::user()->name }}
                    </span>
                </div>
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400">Email</span>
                    <span class="text-xs font-semibold text-gray-900 text-right max-w-[60%] truncate">
                        {{ Auth::user()->email }}
                    </span>
                </div>
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400">Role</span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                 bg-indigo-50 text-indigo-700 border border-indigo-200">
                        Super admin
                    </span>
                </div>
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400">Status</span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                                 bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <i data-lucide="circle-dot" class="w-3 h-3"></i>
                        Aktif
                    </span>
                </div>
            </div>
        </div>

        {{-- AKTIVITAS TERBARU --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-5 py-4 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/15 rounded-xl p-2.5">
                            <i data-lucide="activity" class="w-5 h-5"></i>
                        </div>
                        <p class="font-semibold">Aktivitas terbaru</p>
                    </div>
                    <span class="text-xs text-blue-100">Hari ini</span>
                </div>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($activities as $activity)
                    @php
                        $icon  = 'activity';
                        $bg    = 'bg-gray-50';
                        $text  = 'text-gray-500';

                        if ($activity->subject_type) {
                            $type  = class_basename($activity->subject_type);
                            $event = $activity->event ?? 'updated';

                            $map = [
                                'Guru'  => ['created' => ['user-plus','bg-emerald-50','text-emerald-600'],  'deleted' => ['user-minus','bg-red-50','text-red-600'],    'default' => ['user-pen','bg-blue-50','text-blue-600']],
                                'Siswa' => ['created' => ['user-plus','bg-emerald-50','text-emerald-600'],  'deleted' => ['user-minus','bg-red-50','text-red-600'],    'default' => ['user-pen','bg-indigo-50','text-indigo-600']],
                                'Kelas' => ['created' => ['school','bg-purple-50','text-purple-600'],       'deleted' => ['building-2','bg-red-50','text-red-600'],   'default' => ['school','bg-purple-50','text-purple-600']],
                                'Mapel' => ['created' => ['book-open','bg-green-50','text-green-600'],      'deleted' => ['book-x','bg-red-50','text-red-600'],       'default' => ['book','bg-green-50','text-green-600']],
                            ];

                            $cfg  = $map[$type][$event] ?? $map[$type]['default'] ?? null;
                            if ($cfg) [$icon, $bg, $text] = $cfg;
                        }
                    @endphp

                    <div class="flex items-start gap-4 px-5 py-4 hover:bg-gray-50 transition">
                        <div class="{{ $bg }} rounded-xl p-2.5 flex-shrink-0">
                            <i data-lucide="{{ $icon }}" class="w-4 h-4 {{ $text }}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $activity->description }}
                                @if($activity->subject)
                                    <span class="font-normal text-gray-500">:
                                        {{ $activity->subject->nama
                                            ?? $activity->subject->nama_kelas
                                            ?? $activity->subject->nama_mapel
                                            ?? 'Data' }}
                                    </span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $activity->causer->name ?? 'System' }} •
                                {{ $activity->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 text-gray-400">
                        <div class="bg-gray-50 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="inbox" class="w-7 h-7 text-gray-300"></i>
                        </div>
                        <p class="text-sm font-medium">Belum ada aktivitas hari ini</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

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
</script>
@endsection