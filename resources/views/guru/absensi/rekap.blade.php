@extends('guru.layouts.app')
@section('title', 'Rekap Absensi Semester')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">

    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">

        <!-- HEADER -->
        <div class="bg-gradient-to-r from-blue-700 to-indigo-800 px-6 py-6 text-white">
            <h2 class="text-3xl font-bold">Rekap Absensi Semester</h2>
        </div>

        <!-- INFO -->
        <div class="px-6 py-5 bg-gray-50 border-b-2 border-gray-200 grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center md:text-left">
                <p class="text-sm font-medium text-gray-600">Status Guru</p>
                <p class="text-xl font-bold text-indigo-700 mt-1">Aktif</p>
            </div>
            <div class="text-center md:text-left">
                <p class="text-sm font-medium text-gray-600">Angkatan</p>
                <p class="text-xl font-bold text-indigo-700 mt-1">2025</p>
            </div>
            <div class="text-center md:text-left">
                <p class="text-sm font-medium text-gray-600">Total SKS / IPK Lulus</p>
                <p class="text-xl font-bold text-indigo-700 mt-1">80 / 3.55</p>
            </div>
            <div class="text-center md:text-right">
                <p class="text-sm font-medium text-gray-600">Periode</p>
                <select class="mt-1 px-4 py-2 border border-gray-300 rounded-xl bg-white font-bold text-indigo-700">
                    <option>2025</option>
                </select>
            </div>
        </div>

        <!-- TABEL -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-blue-700 text-white">
                    <tr>
                        <th class="px-4 py-4 text-left">No</th>
                        <th class="px-4 py-4 text-left">Mata Kuliah</th>
                        <th class="px-4 py-4 text-center">Kelas</th>
                        <th class="px-4 py-4 text-center">Pertemuan</th>
                        <th class="px-4 py-4 text-center">Alfa</th>
                        <th class="px-4 py-4 text-center">Hadir</th>
                        <th class="px-4 py-4 text-center">Izin</th>
                        <th class="px-4 py-4 text-center">Sakit</th>
                        <th class="px-4 py-4 text-center">Belum Presensi</th>
                        <th class="px-4 py-4 text-center">Hadir (%)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($rekap as $index => $item)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-4 py-4 text-center font-medium">{{ $index + 1 }}</td>
                        <td class="px-4 py-4 font-semibold text-gray-900">{{ $item['mapel'] }}</td>
                        <td class="px-4 py-4 text-center">{{ $item['kelas'] }}</td>
                        <td class="px-4 py-4 text-center font-bold text-indigo-700">{{ $item['pertemuan'] }}</td>
                        <td class="px-4 py-4 text-center text-red-600 font-medium">{{ $item['alpa'] }}</td>
                        <td class="px-4 py-4 text-center text-emerald-700 font-medium">{{ $item['hadir'] }}</td>
                        <td class="px-4 py-4 text-center text-blue-700 font-medium">{{ $item['izin'] }}</td>
                        <td class="px-4 py-4 text-center text-amber-700 font-medium">{{ $item['sakit'] }}</td>
                        <td class="px-4 py-4 text-center text-gray-600">{{ $item['belum'] }}</td>
                        <td class="px-4 py-4 text-center font-bold text-indigo-700">{{ $item['persen'] }}%</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-16 text-gray-500">
                            <p class="font-medium">Belum ada data absensi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-blue-50 font-bold border-t-4 border-blue-200">
                    <tr>
                        <td colspan="3" class="px-4 py-5 text-right text-lg">Total:</td>
                        <td class="px-4 py-5 text-center text-indigo-700 text-lg">
                            {{ $grandTotalPertemuanSelesai }}/16 Pertemuan sudah selesai
                        </td>
                        <td colspan="6"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection