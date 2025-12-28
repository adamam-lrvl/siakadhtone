{{-- resources/views/guru/nilai/edit.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Input Nilai')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">

    <!-- HEADER -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Input Nilai Siswa</h2>
        <p class="text-gray-600 mt-1">
            <span class="font-semibold text-blue-600">Mapel:</span> {{ $mapel->nama_mapel }}
            <span class="mx-2">•</span>
            <span class="font-semibold text-blue-600">Kelas:</span> {{ $kelas->nama_kelas }}
        </p>
    </div>

    <!-- CARD -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 overflow-x-auto">

        <form action="{{ route('guru.nilai.update', [$kelas->id, $mapel->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- SELECT SEMESTER -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Semester</label>
                <select name="semester" class="border rounded-lg px-4 py-2 w-48 focus:ring-2 focus:ring-blue-500">
                    <option value="1" {{ old('semester', 1) == 1 ? 'selected' : '' }}>Semester 1</option>
                    <option value="2" {{ old('semester', 1) == 2 ? 'selected' : '' }}>Semester 2</option>
                </select>
            </div>

            <table class="w-full text-sm border-collapse min-w-max">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="border p-3 text-left font-semibold">No</th>
                        <th class="border p-3 text-left font-semibold">NIS</th>
                        <th class="border p-3 text-left font-semibold">Nama Siswa</th>

                        @foreach($kategori as $kat)
                            <th class="border p-3 text-center capitalize font-semibold">
                                {{ str_replace('_', ' ', $kat) }}
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach($siswa as $index => $sis)
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition">
                            <td class="border p-3 text-center">{{ $loop->iteration }}</td>
                            <td class="border p-3">{{ $sis->nis }}</td>
                            <td class="border p-3 font-medium text-gray-900">
                                {{ $sis->nama }}
                            </td>

                            @foreach($kategori as $kat)
                                @php
                                    // FIX: PAKAI optional() biar gak error kalau nilai belum ada
                                    $nilaiKategori = optional(
                                        $sis->nilai
                                            ->where('mapel_id', $mapel->id)
                                            ->where('kategori', $kat)
                                            ->first()
                                    )->nilai ?? '';
                                @endphp

                                <td class="border p-2 text-center">
                                    <input type="number"
                                           name="nilai[{{ $sis->id }}][{{ $kat }}]"
                                           value="{{ old('nilai.'.$sis->id.'.'.$kat, $nilaiKategori) }}"
                                           min="0"
                                           max="100"
                                           step="0.01"
                                           class="w-20 border-gray-300 rounded-lg px-2 py-1 text-center
                                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                                  @error('nilai.'.$sis->id.'.'.$kat) border-red-500 @enderror"
                                           placeholder="0">
                                    @error('nilai.'.$sis->id.'.'.$kat)
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex justify-end mt-6 space-x-3">
                <a href="{{ route('guru.nilai.index') }}"
                   class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium text-sm hover:bg-gray-50 transition">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Kembali
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium shadow-sm flex items-center transition">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    Simpan Semua Nilai
                </button>
            </div>

        </form>

    </div>
</div>
@endsection