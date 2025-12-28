{{-- resources/views/guru/absensi/show.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Rekap Absensi • ' . $jadwal->mapel->nama_mapel)

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">

    <!-- CARD UTAMA -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

        <!-- HEADER INDIGO GRADIENT + ICON -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-5 text-white">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                    <i data-lucide="list-checks" class="w-7 h-7"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Rekap Absensi</h2>
                    <p class="text-indigo-100 text-sm opacity-90">
                        {{ $jadwal->mapel->nama_mapel }} • {{ $jadwal->kelas->nama_kelas }}
                    </p>
                    <p class="text-indigo-100 text-sm opacity-90 mt-1">
                        {{ $jadwal->hari }} • {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                        {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                    </p>
                    <p class="text-indigo-100 text-sm opacity-90 mt-2">
                        Tanggal: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- BODY -->
        <div class="p-5 md:p-7">

            <!-- RINGKASAN 4 CARD KECIL + ICON -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-center">
                    <i data-lucide="check-circle" class="w-8 h-8 text-emerald-700 mx-auto mb-2"></i>
                    <p class="text-3xl font-bold text-emerald-700">{{ $summary['H'] ?? 0 }}</p>
                    <p class="text-sm text-emerald-800 font-medium mt-1">Hadir</p>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
                    <i data-lucide="mail-warning" class="w-8 h-8 text-blue-700 mx-auto mb-2"></i>
                    <p class="text-3xl font-bold text-blue-700">{{ $summary['I'] ?? 0 }}</p>
                    <p class="text-sm text-blue-800 font-medium mt-1">Izin</p>
                </div>
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-center">
                    <i data-lucide="heart-handshake" class="w-8 h-8 text-amber-700 mx-auto mb-2"></i>
                    <p class="text-3xl font-bold text-amber-700">{{ $summary['S'] ?? 0 }}</p>
                    <p class="text-sm text-amber-800 font-medium mt-1">Sakit</p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
                    <i data-lucide="x-circle" class="w-8 h-8 text-red-700 mx-auto mb-2"></i>
                    <p class="text-3xl font-bold text-red-700">{{ $summary['A'] ?? 0 }}</p>
                    <p class="text-sm text-red-800 font-medium mt-1">Alpa</p>
                </div>
            </div>

            <!-- DAFTAR KEHADIRAN — CARD DI HP, TABEL DI PC -->
            <!-- Mobile Card View + ICON STATUS -->
            <div class="lg:hidden space-y-4">
                @forelse($absensis as $index => $absen)
                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <span class="text-xl font-bold text-indigo-600 w-8 text-right">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $absen->siswa->nama }}</p>
                                    <p class="text-sm text-gray-600">NIS: {{ $absen->siswa->nis }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @switch($absen->status)
                                    @case('H') 
                                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-700"></i>
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full font-bold text-sm">Hadir</span> 
                                        @break
                                    @case('I') 
                                        <i data-lucide="mail-warning" class="w-5 h-5 text-blue-700"></i>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-bold text-sm">Izin</span> 
                                        @break
                                    @case('S') 
                                        <i data-lucide="heart-handshake" class="w-5 h-5 text-amber-700"></i>
                                        <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full font-bold text-sm">Sakit</span> 
                                        @break
                                    @case('A') 
                                        <i data-lucide="x-circle" class="w-5 h-5 text-red-700"></i>
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full font-bold text-sm">Alpa</span> 
                                        @break
                                @endswitch
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500">
                        <p class="font-medium">Belum ada data absensi</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View + ICON STATUS -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold text-gray-700">No</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-700">NIS</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-700">Nama Siswa</th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-700">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($absensis as $index => $absen)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $absen->siswa->nis }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $absen->siswa->nama }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @switch($absen->status)
                                        @case('H') 
                                            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-700"></i>
                                            <span class="px-4 py-2 bg-emerald-100 text-emerald-800 rounded-full font-bold">Hadir</span> 
                                            @break
                                        @case('I') 
                                            <i data-lucide="mail-warning" class="w-5 h-5 text-blue-700"></i>
                                            <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full font-bold">Izin</span> 
                                            @break
                                        @case('S') 
                                            <i data-lucide="heart-handshake" class="w-5 h-5 text-amber-700"></i>
                                            <span class="px-4 py-2 bg-amber-100 text-amber-800 rounded-full font-bold">Sakit</span> 
                                            @break
                                        @case('A') 
                                            <i data-lucide="x-circle" class="w-5 h-5 text-red-700"></i>
                                            <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full font-bold">Alpa</span> 
                                            @break
                                    @endswitch
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-16 text-gray-500">
                                <p class="font-medium">Belum ada data absensi</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- TOMBOL EKSPORT & KEMBALI + ICON -->
            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('guru.absensi.export.pdf', $jadwal) }}"
                   class="px-6 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition text-center flex items-center justify-center gap-2">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                    Export PDF
                </a>
                <a href="{{ route('guru.absensi.export.excel', $jadwal) }}"
                   class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition text-center flex items-center justify-center gap-2">
                    <i data-lucide="file-spreadsheet" class="w-5 h-5"></i>
                    Export Excel
                </a>
                <a href="{{ route('guru.absensi.index') }}"
                   class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition text-center flex items-center justify-center gap-2">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
</script>
@endsection