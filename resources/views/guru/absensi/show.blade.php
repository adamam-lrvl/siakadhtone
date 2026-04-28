{{-- resources/views/guru/absensi/show.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Rekap Absensi • ' . $jadwal->mapel->nama_mapel)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER BIRU --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="list-checks" class="w-6 h-6 flex-shrink-0"></i>
                    <span>Rekap absensi</span>
                </h1>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2 text-sm text-blue-100">
                    <span class="flex items-center gap-1">
                        <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                        {{ $jadwal->mapel->nama_mapel }}
                    </span>
                    <span class="text-blue-300">•</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="users" class="w-3.5 h-3.5"></i>
                        {{ $jadwal->kelas->nama_kelas }}
                    </span>
                    <span class="text-blue-300">•</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} –
                        {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                    </span>
                    <span class="text-blue-300">•</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                    </span>
                </div>
            </div>

            {{-- EXPORT BUTTONS --}}
            <div class="flex gap-2 flex-shrink-0">
                <a href="{{ route('guru.absensi.export.excel', $jadwal) }}"
                   class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25
                          text-white text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Excel</span>
                </a>
                <a href="{{ route('guru.absensi.export.pdf', $jadwal) }}"
                   class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25
                          text-white text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">PDF</span>
                </a>
            </div>
        </div>
    </div>

    {{-- SUMMARY 4 CARDS --}}
    <div class="grid grid-cols-4 gap-3">
        <div class="bg-white rounded-2xl border border-gray-200 p-4 text-center">
            <div class="bg-emerald-50 rounded-xl w-10 h-10 flex items-center justify-center mx-auto mb-2">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
            </div>
            <p class="text-2xl font-bold text-emerald-700">{{ $summary['H'] ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Hadir</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-4 text-center">
            <div class="bg-blue-50 rounded-xl w-10 h-10 flex items-center justify-center mx-auto mb-2">
                <i data-lucide="mail" class="w-5 h-5 text-blue-600"></i>
            </div>
            <p class="text-2xl font-bold text-blue-700">{{ $summary['I'] ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Izin</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-4 text-center">
            <div class="bg-amber-50 rounded-xl w-10 h-10 flex items-center justify-center mx-auto mb-2">
                <i data-lucide="heart-handshake" class="w-5 h-5 text-amber-600"></i>
            </div>
            <p class="text-2xl font-bold text-amber-700">{{ $summary['S'] ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Sakit</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-4 text-center">
            <div class="bg-red-50 rounded-xl w-10 h-10 flex items-center justify-center mx-auto mb-2">
                <i data-lucide="x-circle" class="w-5 h-5 text-red-600"></i>
            </div>
            <p class="text-2xl font-bold text-red-700">{{ $summary['A'] ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Alpa</p>
        </div>
    </div>

    {{-- DAFTAR SISWA --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

        {{-- MOBILE: card per siswa --}}
        <div class="divide-y divide-gray-100 lg:hidden">
            @forelse($absensis as $index => $absen)
                <div class="flex items-center justify-between px-4 py-3.5 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-8 h-8 bg-indigo-50 rounded-full flex items-center justify-center
                                    text-indigo-600 font-bold text-xs flex-shrink-0">
                            {{ $index + 1 }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-900 text-sm truncate">{{ $absen->siswa->nama }}</p>
                            <p class="text-xs text-gray-400">{{ $absen->siswa->nis }}</p>
                        </div>
                    </div>
                    @php
                        $badge = match($absen->status) {
                            'H' => ['Hadir', 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                            'I' => ['Izin',  'bg-blue-50 text-blue-700 border-blue-200'],
                            'S' => ['Sakit', 'bg-amber-50 text-amber-700 border-amber-200'],
                            'A' => ['Alpa',  'bg-red-50 text-red-700 border-red-200'],
                            default => ['-', 'bg-gray-50 text-gray-500 border-gray-200'],
                        };
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badge[1] }} flex-shrink-0 ml-2">
                        {{ $badge[0] }}
                    </span>
                </div>
            @empty
                <div class="text-center py-16 text-gray-400">
                    <i data-lucide="calendar-x2" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                    <p class="text-sm font-medium">Belum ada data absensi</p>
                </div>
            @endforelse
        </div>

        {{-- DESKTOP: tabel --}}
        <table class="w-full text-sm hidden lg:table">
            <thead>
                <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                    <th class="px-5 py-3.5 text-center font-semibold w-12">No</th>
                    <th class="px-5 py-3.5 text-left font-semibold w-32">NIS</th>
                    <th class="px-5 py-3.5 text-left font-semibold">Nama Siswa</th>
                    <th class="px-5 py-3.5 text-center font-semibold w-28">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($absensis as $index => $absen)
                    @php
                        $badge = match($absen->status) {
                            'H' => ['Hadir', 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                            'I' => ['Izin',  'bg-blue-50 text-blue-700 border-blue-200'],
                            'S' => ['Sakit', 'bg-amber-50 text-amber-700 border-amber-200'],
                            'A' => ['Alpa',  'bg-red-50 text-red-700 border-red-200'],
                            default => ['-', 'bg-gray-50 text-gray-500 border-gray-200'],
                        };
                    @endphp
                    <tr class="hover:bg-indigo-50/30 transition {{ $loop->even ? 'bg-gray-50/50' : '' }}">
                        <td class="px-5 py-4 text-center text-gray-400 text-xs">{{ $index + 1 }}</td>
                        <td class="px-5 py-4 text-gray-500 text-xs">{{ $absen->siswa->nis }}</td>
                        <td class="px-5 py-4 font-semibold text-gray-900">{{ $absen->siswa->nama }}</td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $badge[1] }}">
                                {{ $badge[0] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-16 text-gray-400">
                            <p class="text-sm font-medium">Belum ada data absensi</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- TOMBOL BAWAH --}}
    <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-3">
        <a href="{{ route('guru.absensi.index') }}"
           class="px-5 py-2.5 border border-gray-200 rounded-xl text-gray-700 font-semibold
                  text-sm hover:bg-gray-50 hover:border-gray-300 transition
                  flex items-center justify-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
        <a href="{{ route('guru.absensi.edit', $jadwal) }}"
           class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600
                  hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl
                  font-semibold text-sm shadow-sm hover:shadow-md transition
                  flex items-center justify-center gap-2">
            <i data-lucide="edit-3" class="w-4 h-4"></i>
            Edit absensi
        </a>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
</script>
@endsection