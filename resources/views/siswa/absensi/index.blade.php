{{-- resources/views/siswa/absensi/index.blade.php --}}
@extends('siswa.layouts.app')
@section('title', 'Absensi Saya')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <!-- HEADER INDIGO-PURPLE GRADIENT -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-8 text-white shadow-2xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">
                    Absensi Saya
                </h1>
                <p class="text-indigo-100 text-lg">
                    {{ Auth::user()->siswa->nama }} • Kelas {{ Auth::user()->siswa->kelas->nama_kelas ?? 'Belum Ditentukan' }}
                </p>
            </div>

            <!-- TOTAL RECORD + EXPORT BUTTONS -->
            <div class="mt-6 md:mt-0 flex flex-col md:flex-row md:items-end gap-4 md:gap-6">
                <div class="text-right">
                    <p class="text-sm opacity-90">Total Rekord</p>
                    <p class="text-2xl font-bold">{{ $absensis->total() }}</p>
                </div>

                <!-- EXPORT BUTTONS -->
                <div class="flex gap-3">
                    <a href="{{ route('siswa.absensi.export.excel') }}" 
                       class="flex items-center px-6 py-3 bg-white text-indigo-700 font-semibold rounded-xl hover:bg-indigo-100 transition shadow-lg">
                        <i data-lucide="file-spreadsheet" class="w-5 h-5 mr-2"></i>
                        Excel
                    </a>

                    <a href="{{ route('siswa.absensi.export.pdf') }}" 
                       class="flex items-center px-6 py-3 bg-white text-purple-700 font-semibold rounded-xl hover:bg-purple-100 transition shadow-lg">
                        <i data-lucide="file-text" class="w-5 h-5 mr-2"></i>
                        PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- CARD MODE DI HP — TANPA JAM ABSEN -->
    <div class="space-y-6 lg:hidden">
        @forelse($absensis as $a)
            <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 p-6 hover:shadow-2xl transition">
                <div class="flex items-center justify-between mb-4">
                    <p class="font-bold text-indigo-900 text-lg">
                        {{ $a->tanggal->translatedFormat('l, d F Y') }}
                    </p>
                    <span class="px-4 py-1 rounded-full text-xs font-bold
                        {{ $a->status == 'hadir' ? 'bg-green-100 text-green-800' :
                           ($a->status == 'alpa' ? 'bg-red-100 text-red-800' :
                           ($a->status == 'izin' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                        {{ ucfirst($a->status ?? '-') }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-gray-500">Mata Pelajaran</p>
                        <p class="font-bold text-purple-700">{{ $a->jadwal->mapel->nama_mapel ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Guru</p>
                        <p class="font-medium text-indigo-700">{{ $a->jadwal->guru->nama ?? '-' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-500">Jam Jadwal</p>
                        <p class="font-medium text-indigo-900">
                            <i data-lucide="clock" class="w-5 h-5 inline text-purple-600 mr-2"></i>
                            {{ $a->jadwal->jam_mulai ?? '-' }} - {{ $a->jadwal->jam_selesai ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-20 text-gray-500">
                <i data-lucide="calendar-x2" class="w-24 h-24 mx-auto mb-6 text-gray-300"></i>
                <p class="text-xl font-medium">Belum ada data absensi</p>
            </div>
        @endforelse
    </div>

    <!-- TABLE MODE DI DESKTOP — TANPA JAM ABSEN -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Guru</th>
                        <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Jam Jadwal</th>
                        <th class="px-6 py-4 text-center font-bold uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-100">
                    @forelse($absensis as $a)
                        <tr class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition">
                            <td class="px-6 py-5 font-medium text-indigo-900">
                                {{ $a->tanggal->translatedFormat('l, d F Y') }}
                            </td>
                            <td class="px-6 py-5 font-bold text-purple-800">
                                {{ $a->jadwal->mapel->nama_mapel ?? '-' }}
                            </td>
                            <td class="px-6 py-5 text-indigo-700">
                                {{ $a->jadwal->guru->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center gap-2">
                                    <i data-lucide="clock" class="w-5 h-5 text-purple-600"></i>
                                    {{ $a->jadwal->jam_mulai ?? '-' }} - {{ $a->jadwal->jam_selesai ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="px-4 py-1 rounded-full text-xs font-bold
                                    {{ $a->status == 'hadir' ? 'bg-green-100 text-green-800' :
                                       ($a->status == 'alpa' ? 'bg-red-100 text-red-800' :
                                       ($a->status == 'izin' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                    {{ ucfirst($a->status ?? '-') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-16 text-gray-500">
                                Belum ada data absensi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border-t px-6 py-4">
            {{ $absensis->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection