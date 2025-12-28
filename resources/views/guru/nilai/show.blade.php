{{-- resources/views/guru/nilai/show.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Rekap Nilai Siswa • ' . $mapel->nama_mapel)

@section('content')
<div class="min-h-screen bg-gray-50 px-4 py-12">

    <!-- HEADER REKAP -->
    <div class="max-w-6xl mx-auto mb-10">
        <div class="bg-white rounded-3xl shadow-xl p-8 border border-indigo-100 text-center">
            <h1 class="text-4xl font-extrabold text-indigo-900 mb-4">
                Rekap Nilai Siswa
            </h1>
            <div class="space-y-2 text-xl">
                <p class="text-purple-700 font-bold text-2xl">{{ $mapel->nama_mapel }}</p>
                <p class="text-indigo-800">{{ $kelas->nama_kelas }} • Semester {{ $semester }}</p>
            </div>

            <!-- TOMBOL EXPORT PDF & EXCEL -->
            <div class="mt-8 flex justify-center gap-6">
                <a href="{{ route('guru.nilai.export.pdf', [$kelas->id, $mapel->id, $semester]) }}"
                   class="inline-flex items-center gap-3 px-8 py-4 bg-red-600 hover:bg-red-700 text-white font-bold text-lg rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                    <i data-lucide="file-down" class="w-6 h-6"></i>
                    Export PDF
                </a>
                <a href="{{ route('guru.nilai.export.excel', [$kelas->id, $mapel->id, $semester]) }}"
                   class="inline-flex items-center gap-3 px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-bold text-lg rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                    <i data-lucide="file-spreadsheet" class="w-6 h-6"></i>
                    Export Excel
                </a>
            </div>
        </div>
    </div>

    <!-- TABEL REKAP NILAI -->
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-3xl shadow-xl border border-indigo-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                        <tr>
                            <th class="px-6 py-5 text-left font-bold">No</th>
                            <th class="px-6 py-5 text-left font-bold">Nama Siswa</th>
                            <th class="px-6 py-5 text-center font-bold">NIS</th>
                            <th class="px-6 py-5 text-center font-bold">Tugas 1</th>
                            <th class="px-6 py-5 text-center font-bold">Tugas 2</th>
                            <th class="px-6 py-5 text-center font-bold">Tugas 3</th>
                            <th class="px-6 py-5 text-center font-bold">Tugas 4</th>
                            <th class="px-6 py-5 text-center font-bold">Tugas 5</th>
                            <th class="px-6 py-5 text-center font-bold">Tugas 6</th>
                            <th class="px-6 py-5 text-center font-bold">UTS</th>
                            <th class="px-6 py-5 text-center font-bold">UAS</th>
                            <th class="px-6 py-5 text-center font-bold text-lg">Rata-rata</th>
                            <th class="px-6 py-5 text-center font-bold text-lg">Predikat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-indigo-100">
                        @forelse($rekapSiswa as $index => $r)
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="px-6 py-5 text-center font-medium">{{ $index + 1 }}</td>
                            <td class="px-6 py-5 font-semibold text-indigo-900">{{ $r['siswa']->nama }}</td>
                            <td class="px-6 py-5 text-center text-gray-600">{{ $r['siswa']->nis }}</td>
                            <td class="px-6 py-5 text-center {{ $r['nilai']['tugas_1'] ? 'text-green-700 font-bold' : 'text-gray-400' }}">
                                {{ $r['nilai']['tugas_1'] ?? '-' }}
                            </td>
                            <td class="px-6 py-5 text-center {{ $r['nilai']['tugas_2'] ? 'text-green-700 font-bold' : 'text-gray-400' }}">
                                {{ $r['nilai']['tugas_2'] ?? '-' }}
                            </td>
                            <td class="px-6 py-5 text-center {{ $r['nilai']['tugas_3'] ? 'text-green-700 font-bold' : 'text-gray-400' }}">
                                {{ $r['nilai']['tugas_3'] ?? '-' }}
                            </td>
                            <td class="px-6 py-5 text-center {{ $r['nilai']['tugas_4'] ? 'text-green-700 font-bold' : 'text-gray-400' }}">
                                {{ $r['nilai']['tugas_4'] ?? '-' }}
                            </td>
                            <td class="px-6 py-5 text-center {{ $r['nilai']['tugas_5'] ? 'text-green-700 font-bold' : 'text-gray-400' }}">
                                {{ $r['nilai']['tugas_5'] ?? '-' }}
                            </td>
                            <td class="px-6 py-5 text-center {{ $r['nilai']['tugas_6'] ? 'text-green-700 font-bold' : 'text-gray-400' }}">
                                {{ $r['nilai']['tugas_6'] ?? '-' }}
                            </td>
                            <td class="px-6 py-5 text-center {{ $r['nilai']['uts'] ? 'text-blue-700 font-bold' : 'text-gray-400' }}">
                                {{ $r['nilai']['uts'] ?? '-' }}
                            </td>
                            <td class="px-6 py-5 text-center {{ $r['nilai']['uas'] ? 'text-purple-700 font-bold' : 'text-gray-400' }}">
                                {{ $r['nilai']['uas'] ?? '-' }}
                            </td>
                            <td class="px-6 py-5 text-center text-2xl font-extrabold text-indigo-900">
                                {{ $r['rata_rata'] }}
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="px-6 py-3 rounded-full text-white font-bold text-xl shadow-lg
                                    {{ $r['predikat'] == 'A' ? 'bg-green-600' : '' }}
                                    {{ $r['predikat'] == 'B' ? 'bg-blue-600' : '' }}
                                    {{ $r['predikat'] == 'C' ? 'bg-yellow-600' : '' }}
                                    {{ $r['predikat'] == 'D' ? 'bg-orange-600' : '' }}
                                    {{ $r['predikat'] == 'E' ? 'bg-red-600' : '' }}">
                                    {{ $r['predikat'] }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="14" class="text-center py-20 text-gray-500">
                                <i data-lucide="users" class="w-24 h-24 mx-auto mb-6 text-gray-300"></i>
                                <p class="text-xl font-medium">Belum ada data siswa atau nilai</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- KEMBALI -->
        <div class="mt-12 text-center">
            <a href="{{ route('guru.nilai.index') }}"
               class="inline-flex items-center gap-4 px-12 py-5 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 text-white font-bold text-xl rounded-2xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
                Kembali ke Daftar Mapel
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
</script>
@endsection