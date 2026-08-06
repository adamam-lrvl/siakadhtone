{{-- resources/views/siswa/absensi/index.blade.php --}}
@extends('siswa.layouts.app')
@section('title', 'Absensi Saya')

@section('content')
<div class="max-w-5xl mx-auto py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:border dark:border-white/[0.09]
                dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="relative p-6 flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-extrabold text-white dark:text-white/90 flex items-center gap-2 tracking-tight">
                    <i data-lucide="list-checks" class="w-6 h-6 flex-shrink-0"></i>
                    Absensi saya
                </h1>
                <p class="text-blue-200 dark:text-white/40 text-sm mt-1">
                    {{ $siswa->nama }} · Kelas {{ $siswa->kelas->nama_kelas ?? '-' }}
                </p>
            </div>
            <div class="flex gap-2 flex-shrink-0 z-10">
                <a href="{{ route('siswa.absensi.export.excel') }}"
                   class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25 border border-white/20 text-white text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Excel</span>
                </a>
                <a href="{{ route('siswa.absensi.export.pdf') }}"
                   class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25 border border-white/20 text-white text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">PDF</span>
                </a>
            </div>
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        @php
            $summaryCards = [
                ['label' => 'Total hadir', 'key' => 'H', 'from' => 'from-emerald-500', 'to' => 'to-teal-500',   'icon' => 'check-circle'],
                ['label' => 'Total izin',  'key' => 'I', 'from' => 'from-blue-500',    'to' => 'to-blue-600',   'icon' => 'mail'],
                ['label' => 'Total sakit', 'key' => 'S', 'from' => 'from-amber-500',   'to' => 'to-orange-500', 'icon' => 'heart-handshake'],
                ['label' => 'Total alpa',  'key' => 'A', 'from' => 'from-red-500',     'to' => 'to-rose-600',   'icon' => 'x-circle'],
            ];
        @endphp
        @foreach($summaryCards as $sc)
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl border border-gray-200 dark:border-white/[0.07] rounded-2xl p-4 text-center">
            <div class="w-10 h-10 bg-gradient-to-br {{ $sc['from'] }} {{ $sc['to'] }} rounded-xl flex items-center justify-center mx-auto mb-2">
                <i data-lucide="{{ $sc['icon'] }}" class="w-5 h-5 text-white"></i>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white/90">{{ $summary[$sc['key']] }}</p>
            <p class="text-xs text-gray-400 dark:text-white/35 mt-0.5">{{ $sc['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- TABEL --}}
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">
        {{-- DESKTOP --}}
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                        <th class="px-5 py-3.5 text-center font-semibold w-10">No</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Mata Pelajaran</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Guru</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-24">Hadir</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-20">Izin</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-20">Sakit</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-20">Alpa</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-20">Belum</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-32">Kehadiran</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-16">%</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                    @forelse($rekapMapel as $index => $r)
                    @php
                        $persen    = $r['persen'];
                        $bgBar     = $persen >= 75 ? 'bg-emerald-500' : ($persen >= 50 ? 'bg-amber-500' : 'bg-red-500');
                        $txtPersen = $persen >= 75 ? 'text-emerald-700 dark:text-emerald-400 font-bold' : ($persen >= 50 ? 'text-amber-700 dark:text-amber-400 font-bold' : 'text-red-700 dark:text-red-400 font-bold');
                    @endphp
                    <tr class="hover:bg-indigo-50/30 dark:hover:bg-white/[0.04] transition {{ $loop->even ? 'bg-gray-50/50 dark:bg-white/[0.02]' : '' }}">
                        <td class="px-5 py-4 text-center text-gray-400 dark:text-white/30 text-xs">{{ $index + 1 }}</td>
                        <td class="px-5 py-4 font-semibold text-gray-900 dark:text-white/90">{{ $r['mapel']->nama_mapel ?? '-' }}</td>
                        <td class="px-5 py-4 text-gray-500 dark:text-white/40 text-xs">{{ $r['guru']->nama ?? '-' }}</td>
                        <td class="px-5 py-4 text-center">
                            <span class="font-bold text-emerald-700 dark:text-emerald-400">{{ $r['H'] }}</span>
                            <span class="text-gray-300 dark:text-white/20 text-xs">/{{ $totalPertemuan }}</span>
                        </td>
                        <td class="px-5 py-4 text-center font-semibold text-blue-700 dark:text-blue-400">{{ $r['I'] }}</td>
                        <td class="px-5 py-4 text-center font-semibold text-amber-700 dark:text-amber-400">{{ $r['S'] }}</td>
                        <td class="px-5 py-4 text-center font-semibold text-red-700 dark:text-red-400">{{ $r['A'] }}</td>
                        <td class="px-5 py-4 text-center text-gray-400 dark:text-white/30 text-xs">{{ $r['belum'] }}</td>
                        <td class="px-5 py-4">
                            <div class="w-full bg-gray-100 dark:bg-white/[0.08] rounded-full h-2">
                                <div class="{{ $bgBar }} h-2 rounded-full" style="width: {{ min($persen, 100) }}%"></div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center {{ $txtPersen }}">{{ number_format($persen, 0) }}%</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-16">
                            <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                                <i data-lucide="calendar-x2" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-400 dark:text-white/30">Belum ada data absensi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE --}}
        <div class="lg:hidden divide-y divide-gray-100 dark:divide-white/[0.05]">
            @forelse($rekapMapel as $index => $r)
            @php
                $persen    = $r['persen'];
                $bgBar     = $persen >= 75 ? 'bg-emerald-500' : ($persen >= 50 ? 'bg-amber-500' : 'bg-red-500');
                $txtPersen = $persen >= 75 ? 'text-emerald-700 dark:text-emerald-400' : ($persen >= 50 ? 'text-amber-700 dark:text-amber-400' : 'text-red-700 dark:text-red-400');
            @endphp
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-white/[0.04] transition">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white/90 text-sm">{{ $r['mapel']->nama_mapel ?? '-' }}</p>
                        <p class="text-xs text-gray-400 dark:text-white/35 mt-0.5">{{ $r['guru']->nama ?? '-' }}</p>
                    </div>
                    <span class="font-bold text-sm {{ $txtPersen }}">{{ number_format($persen, 0) }}%</span>
                </div>
                <div class="grid grid-cols-4 gap-2 text-center text-xs mb-3">
                    <div class="bg-emerald-50 dark:bg-emerald-500/10 rounded-lg py-1.5">
                        <p class="font-bold text-emerald-700 dark:text-emerald-400">{{ $r['H'] }}/{{ $totalPertemuan }}</p>
                        <p class="text-gray-400 dark:text-white/30">Hadir</p>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-500/10 rounded-lg py-1.5">
                        <p class="font-bold text-blue-700 dark:text-blue-400">{{ $r['I'] }}</p>
                        <p class="text-gray-400 dark:text-white/30">Izin</p>
                    </div>
                    <div class="bg-amber-50 dark:bg-amber-500/10 rounded-lg py-1.5">
                        <p class="font-bold text-amber-700 dark:text-amber-400">{{ $r['S'] }}</p>
                        <p class="text-gray-400 dark:text-white/30">Sakit</p>
                    </div>
                    <div class="bg-red-50 dark:bg-red-500/10 rounded-lg py-1.5">
                        <p class="font-bold text-red-700 dark:text-red-400">{{ $r['A'] }}</p>
                        <p class="text-gray-400 dark:text-white/30">Alpa</p>
                    </div>
                </div>
                <div class="w-full bg-gray-100 dark:bg-white/[0.08] rounded-full h-1.5">
                    <div class="{{ $bgBar }} h-1.5 rounded-full" style="width: {{ min($persen, 100) }}%"></div>
                </div>
            </div>
            @empty
            <div class="text-center py-16">
                <p class="text-sm font-medium text-gray-400 dark:text-white/30">Belum ada data absensi</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection