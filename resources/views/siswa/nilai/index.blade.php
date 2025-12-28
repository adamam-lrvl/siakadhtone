{{-- resources/views/siswa/nilai/index.blade.php --}}
@extends('siswa.layouts.app')
@section('title', 'Rekap Nilai Saya')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <!-- HEADER INDIGO-PURPLE -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-8 text-white shadow-2xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">
                    Rekap Nilai Saya
                </h1>
                <p class="text-indigo-100 text-lg">
                    {{ Auth::user()->siswa->nama }} • Kelas {{ Auth::user()->siswa->kelas->nama_kelas ?? '-' }}
                </p>
            </div>
        </div>
    </div>

    <!-- CARD MODE HP -->
    <div class="space-y-6 lg:hidden">
        @forelse($rekapNilai as $r)
            <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 p-6 hover:shadow-2xl transition">
                <div class="flex items-center justify-between mb-4">
                    <p class="font-extrabold text-purple-800 text-xl">{{ $r->mapel->nama_mapel }}</p>
                    <span class="px-4 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                        Semester {{ $r->semester }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-200">
                        <p class="text-sm text-indigo-700">Rata-rata</p>
                        <p class="text-3xl font-extrabold text-indigo-900">{{ $r->rata_rata }}</p>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
                        <p class="text-sm text-purple-700">Predikat</p>
                        <p class="text-3xl font-extrabold text-purple-900">{{ $r->predikat }}</p>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-3 text-sm text-center">
                    <div>
                        <p class="text-gray-500">Tugas</p>
                        <p class="font-bold text-indigo-700">{{ $r->tugas }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">UTS</p>
                        <p class="font-bold text-indigo-700">{{ $r->uts }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">UAS</p>
                        <p class="font-bold text-indigo-700">{{ $r->uas }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-20 text-gray-500">
                <i data-lucide="book-x" class="w-24 h-24 mx-auto mb-6 text-gray-300"></i>
                <p class="text-xl font-medium">Belum ada nilai</p>
            </div>
        @endforelse
    </div>

    <!-- TABLE MODE DESKTOP -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left">Mata Pelajaran</th>
                        <th class="px-6 py-4 text-center">Semester</th>
                        <th class="px-6 py-4 text-center">Tugas</th>
                        <th class="px-6 py-4 text-center">UTS</th>
                        <th class="px-6 py-4 text-center">UAS</th>
                        <th class="px-6 py-4 text-center">Rata-rata</th>
                        <th class="px-6 py-4 text-center">Predikat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-100">
                    @forelse($rekapNilai as $r)
                        <tr class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition">
                            <td class="px-6 py-5 font-bold text-purple-800">{{ $r->mapel->nama_mapel }}</td>
                            <td class="px-6 py-5 text-center">
                                <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-800 text-xs font-bold">
                                    {{ $r->semester }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center text-indigo-700">{{ $r->tugas }}</td>
                            <td class="px-6 py-5 text-center text-indigo-700">{{ $r->uts }}</td>
                            <td class="px-6 py-5 text-center text-indigo-700">{{ $r->uas }}</td>
                            <td class="px-6 py-5 text-center font-extrabold text-indigo-900">{{ $r->rata_rata }}</td>
                            <td class="px-6 py-5 text-center">
                                <span class="px-4 py-1 rounded-full text-xs font-bold
                                    {{ $r->predikat == 'A' ? 'bg-green-100 text-green-800' :
                                       ($r->predikat == 'B' ? 'bg-blue-100 text-blue-800' :
                                       ($r->predikat == 'C' ? 'bg-yellow-100 text-yellow-800' :
                                       ($r->predikat == 'D' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800'))) }}">
                                    {{ $r->predikat }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-16 text-gray-500">
                                Belum ada nilai
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection