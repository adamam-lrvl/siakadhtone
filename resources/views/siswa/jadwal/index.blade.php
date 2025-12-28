{{-- resources/views/siswa/jadwal/index.blade.php --}}
@extends('siswa.layouts.app')
@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <!-- HEADER INDIGO-PURPLE GRADIENT (GANG ABIS) -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-8 text-white shadow-2xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">
                    Jadwal Pelajaran
                </h1>
                <p class="text-indigo-100 text-lg">
                    Kelas {{ Auth::user()->siswa->kelas->nama_kelas ?? 'Belum Ditentukan' }} • Tahun Ajaran 2025/2026
                </p>
            </div>
            <div class="mt-6 md:mt-0 text-right">
                <p class="text-sm opacity-90">Hari Ini</p>
                <p class="text-2xl font-bold">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
        </div>
    </div>

    <!-- CARD MODE DI HP — INDIGO-PURPLE GANG -->
    <div class="space-y-6 lg:hidden">
        @foreach($hariUrut as $hari)
            <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 p-6 hover:shadow-2xl transition">
                <h3 class="text-2xl font-bold text-indigo-900 mb-5 text-center">{{ $hari }}</h3>
                @if(isset($jadwals[$hari]) && $jadwals[$hari]->count() > 0)
                    <div class="space-y-4">
                        @foreach($jadwals[$hari] as $j)
                            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-5 border border-purple-200 hover:shadow-md transition">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="font-bold text-indigo-900 text-lg">{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</p>
                                    <i data-lucide="clock" class="w-7 h-7 text-purple-600"></i>
                                </div>
                                <p class="font-extrabold text-purple-700 text-xl">{{ $j->mapel->nama_mapel }}</p>
                                <p class="text-sm text-indigo-700 mt-2">Guru: {{ $j->guru->nama }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-500 py-8 font-medium">Tidak ada jadwal</p>
                @endif
            </div>
        @endforeach
    </div>

    <!-- TABLE MODE DI DESKTOP — INDIGO-PURPLE GANG -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Hari</th>
                        <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Jam</th>
                        <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Guru Pengajar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-100">
                    @foreach($hariUrut as $hari)
                        @if(isset($jadwals[$hari]) && $jadwals[$hari]->count() > 0)
                            @foreach($jadwals[$hari] as $j)
                                <tr class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition">
                                    <td class="px-6 py-5 font-medium text-indigo-900">
                                        {{ $hari }}
                                        @if($loop->first)
                                            <span class="block text-xs text-purple-600 mt-1">({{ $jadwals[$hari]->count() }} pelajaran)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center gap-2 text-indigo-700">
                                            <i data-lucide="clock" class="w-5 h-5 text-purple-600"></i>
                                            {{ $j->jam_mulai }} - {{ $j->jam_selesai }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 font-bold text-purple-800">
                                        {{ $j->mapel->nama_mapel }}
                                    </td>
                                    <td class="px-6 py-5 text-indigo-700">
                                        {{ $j->guru->nama }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    {{ $hari }} — Tidak ada jadwal
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection