{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:shadow-[0_0_40px_rgba(99,102,241,0.15),inset_0_1px_0_rgba(255,255,255,0.12),inset_0_-1px_0_rgba(255,255,255,0.04)]
                dark:border dark:border-white/[0.10]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)]
                    dark:bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.05),transparent_60%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(99,102,241,0.3),transparent_60%)]
                    dark:hidden"></div>
        <div class="relative px-7 py-7 flex items-start justify-between gap-4">
            <div class="min-w-0">
                <p class="text-xs font-semibold text-blue-300 dark:text-white/40 uppercase tracking-widest mb-1">Admin Panel</p>
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
                ['label' => 'Total guru',     'value' => $totalGuru ?? 0,  'icon' => 'users',      'from' => 'from-blue-500',    'to' => 'to-blue-600'],
                ['label' => 'Total siswa',    'value' => $totalSiswa ?? 0, 'icon' => 'user-check', 'from' => 'from-indigo-500',  'to' => 'to-indigo-600'],
                ['label' => 'Total kelas',    'value' => $totalKelas ?? 0, 'icon' => 'school',     'from' => 'from-violet-500',  'to' => 'to-purple-600'],
                ['label' => 'Mata pelajaran', 'value' => $totalMapel ?? 0, 'icon' => 'book-open',  'from' => 'from-emerald-500', 'to' => 'to-teal-600'],
            ];
        @endphp
        @foreach($stats as $s)
        {{-- Light: putih biasa. Dark: glass gelap subtle, bukan biru terang --}}
        <div class="bg-white dark:bg-white/[0.04] dark:backdrop-blur-xl
                    border border-gray-200 dark:border-white/[0.07]
                    rounded-2xl p-5 hover:-translate-y-0.5
                    dark:hover:bg-white/[0.07] hover:shadow-md
                    transition-all duration-200">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $s['from'] }} {{ $s['to'] }}
                        flex items-center justify-center mb-4 opacity-90">
                <i data-lucide="{{ $s['icon'] }}" class="w-5 h-5 text-white"></i>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white/90 tracking-tight">{{ $s['value'] }}</p>
            <p class="text-xs text-gray-400 dark:text-white/35 mt-0.5">{{ $s['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- PROFIL + AKTIVITAS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- PROFIL ADMIN --}}
        <div class="bg-white dark:bg-white/[0.04] dark:backdrop-blur-xl
                    border border-gray-200 dark:border-white/[0.07]
                    dark:shadow-[0_0_30px_rgba(99,102,241,0.08)]
                    rounded-2xl overflow-hidden">
            <div class="relative overflow-hidden px-5 py-4
                        bg-gradient-to-br from-blue-700 to-indigo-700
                        dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                        dark:shadow-[inset_0_1px_0_rgba(255,255,255,0.12),inset_0_-1px_0_rgba(255,255,255,0.04)]
                        dark:border-b dark:border-white/[0.08]">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_70%)] dark:opacity-30 pointer-events-none"></div>
                <div class="relative flex items-center gap-3">
                    <div class="bg-white/15 dark:bg-white/[0.08] backdrop-blur-sm border border-white/20 dark:border-white/[0.10] rounded-xl p-2.5">
                        <i data-lucide="shield" class="w-5 h-5 text-white dark:text-white/80"></i>
                    </div>
                    <p class="font-semibold text-white dark:text-white/80">Profil admin</p>
                </div>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400 dark:text-white/30">Nama</span>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white/85 text-right max-w-[60%] truncate">
                        {{ Auth::user()->name }}
                    </span>
                </div>
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400 dark:text-white/30">Email</span>
                    <span class="text-xs font-semibold text-gray-900 dark:text-white/85 text-right max-w-[60%] truncate">
                        {{ Auth::user()->email }}
                    </span>
                </div>
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400 dark:text-white/30">Role</span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                 bg-indigo-50 dark:bg-white/[0.07] text-indigo-700 dark:text-white/70
                                 border border-indigo-200 dark:border-white/[0.10]">
                        Super admin
                    </span>
                </div>
                <div class="flex justify-between items-center px-5 py-3.5">
                    <span class="text-xs text-gray-400 dark:text-white/30">Status</span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                                 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-300
                                 border border-emerald-200 dark:border-emerald-500/20">
                        <i data-lucide="circle-dot" class="w-3 h-3"></i>
                        Aktif
                    </span>
                </div>
            </div>
        </div>

        {{-- AKTIVITAS TERBARU --}}
        <div class="lg:col-span-2 bg-white dark:bg-white/[0.04] dark:backdrop-blur-xl
                    border border-gray-200 dark:border-white/[0.07]
                    dark:shadow-[0_0_30px_rgba(99,102,241,0.08)]
                    rounded-2xl overflow-hidden">
            <div class="relative overflow-hidden px-5 py-4
                        bg-gradient-to-br from-blue-700 to-indigo-700
                        dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                        dark:shadow-[inset_0_1px_0_rgba(255,255,255,0.12),inset_0_-1px_0_rgba(255,255,255,0.04)]
                        dark:border-b dark:border-white/[0.08]">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_70%)] dark:opacity-30 pointer-events-none"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/15 dark:bg-white/[0.08] backdrop-blur-sm border border-white/20 dark:border-white/[0.10] rounded-xl p-2.5">
                            <i data-lucide="activity" class="w-5 h-5 text-white dark:text-white/80"></i>
                        </div>
                        <p class="font-semibold text-white dark:text-white/80">Aktivitas terbaru</p>
                    </div>
                    <span class="text-xs text-blue-200 dark:text-white/40 bg-white/10 dark:bg-white/[0.06]
                                 border border-white/15 dark:border-white/[0.08]
                                 px-2.5 py-1 rounded-full backdrop-blur-sm">Hari ini</span>
                </div>
            </div>

            <div class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                @forelse($activities as $activity)
                    @php
                        $icon = 'activity';
                        $bg   = 'bg-gray-50 dark:bg-white/[0.04]';
                        $text = 'text-gray-500 dark:text-white/50';
                        if ($activity->subject_type) {
                            $type  = class_basename($activity->subject_type);
                            $event = $activity->event ?? 'updated';
                            $map = [
                                'Guru'  => [
                                    'created' => ['user-plus',  'bg-emerald-50 dark:bg-emerald-500/10', 'text-emerald-600 dark:text-emerald-400'],
                                    'deleted' => ['user-minus', 'bg-red-50 dark:bg-red-500/10',         'text-red-600 dark:text-red-400'],
                                    'default' => ['user-pen',   'bg-blue-50 dark:bg-blue-500/10',       'text-blue-600 dark:text-blue-300'],
                                ],
                                'Siswa' => [
                                    'created' => ['user-plus',  'bg-emerald-50 dark:bg-emerald-500/10', 'text-emerald-600 dark:text-emerald-400'],
                                    'deleted' => ['user-minus', 'bg-red-50 dark:bg-red-500/10',         'text-red-600 dark:text-red-400'],
                                    'default' => ['user-pen',   'bg-indigo-50 dark:bg-indigo-500/10',   'text-indigo-600 dark:text-indigo-300'],
                                ],
                                'Kelas' => [
                                    'created' => ['school',     'bg-purple-50 dark:bg-purple-500/10',   'text-purple-600 dark:text-purple-300'],
                                    'deleted' => ['building-2', 'bg-red-50 dark:bg-red-500/10',         'text-red-600 dark:text-red-400'],
                                    'default' => ['school',     'bg-purple-50 dark:bg-purple-500/10',   'text-purple-600 dark:text-purple-300'],
                                ],
                                'Mapel' => [
                                    'created' => ['book-open',  'bg-green-50 dark:bg-green-500/10',     'text-green-600 dark:text-green-400'],
                                    'deleted' => ['book-x',     'bg-red-50 dark:bg-red-500/10',         'text-red-600 dark:text-red-400'],
                                    'default' => ['book',       'bg-green-50 dark:bg-green-500/10',     'text-green-600 dark:text-green-400'],
                                ],
                            ];
                            $cfg = $map[$type][$event] ?? $map[$type]['default'] ?? null;
                            if ($cfg) [$icon, $bg, $text] = $cfg;
                        }
                    @endphp
                    <div class="flex items-start gap-4 px-5 py-4 hover:bg-gray-50 dark:hover:bg-white/[0.03] transition">
                        <div class="{{ $bg }} rounded-xl p-2.5 flex-shrink-0">
                            <i data-lucide="{{ $icon }}" class="w-4 h-4 {{ $text }}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white/80">
                                {{ $activity->description }}
                                @if($activity->subject)
                                    <span class="font-normal text-gray-500 dark:text-white/35">:
                                        {{ $activity->subject->nama
                                            ?? $activity->subject->nama_kelas
                                            ?? $activity->subject->nama_mapel
                                            ?? 'Data' }}
                                    </span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-400 dark:text-white/25 mt-0.5">
                                {{ $activity->causer->name ?? 'System' }} ·
                                {{ $activity->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16">
                        <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14
                                    flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="inbox" class="w-7 h-7 text-gray-300 dark:text-white/15"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-500 dark:text-white/25">
                            Belum ada aktivitas hari ini
                        </p>
                    </div>
                @endforelse
            </div>
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