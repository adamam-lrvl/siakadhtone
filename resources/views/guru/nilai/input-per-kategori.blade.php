{{-- resources/views/guru/nilai/input-kategori.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Input Nilai • ' . ucwords(str_replace('_', ' ', $kategori)))

@section('content')
<div class="min-h-screen bg-gray-50 px-4 py-8">

    <!-- HEADER INDIGO-PURPLE -->
    <div class="max-w-4xl mx-auto text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900 mb-4">
            Input Nilai {{ ucwords(str_replace('_', ' ', $kategori)) }}
        </h1>
        <div class="bg-white rounded-3xl shadow-xl p-6 border border-indigo-200">
            <p class="text-xl md:text-2xl font-bold text-purple-700">
                {{ $mapel->nama_mapel }}
            </p>
            <p class="text-lg md:text-xl text-indigo-800 mt-1">
                {{ $kelas->nama_kelas }}
            </p>
        </div>
    </div>

    <!-- FORM -->
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('guru.nilai.simpan-kategori', [$kelas->id, $mapel->id, $kategori]) }}" method="POST">
            @csrf

            <!-- SEMESTER SELECT INDIGO -->
            <div class="text-center mb-10">
                <label class="text-base font-bold text-indigo-900 mr-4">Semester</label>
                <select name="semester" class="px-8 py-4 text-xl font-bold rounded-2xl border-4 border-indigo-500 focus:ring-8 focus:ring-indigo-300 focus:outline-none transition-all bg-white shadow-lg">
                    <option value="1" {{ old('semester', 1) == 1 ? 'selected' : '' }}>Semester 1</option>
                    <option value="2" {{ old('semester', 1) == 2 ? 'selected' : '' }}>Semester 2</option>
                </select>
            </div>

            <!-- DAFTAR SISWA — PREMIUM CARD -->
            <div class="space-y-6">
                @foreach($siswa as $index => $s)
                    @php
                        $nilaiLama = optional($s->nilai->first())->nilai ?? '';
                    @endphp

                    <div class="bg-white rounded-3xl shadow-xl border-2 border-indigo-100 p-6 hover:shadow-2xl hover:border-indigo-300 transition-all duration-300">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                            
                            <!-- INFO SISWA -->
                            <div class="flex items-center gap-5 min-w-0 flex-1">
                                <span class="text-3xl font-extrabold text-purple-600 w-12 text-right flex-shrink-0">
                                    {{ $index + 1 }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="font-extrabold text-indigo-900 text-xl truncate">{{ $s->nama }}</p>
                                    <p class="text-sm text-indigo-600 font-medium">NIS: {{ $s->nis }}</p>
                                </div>
                            </div>

                            <!-- INPUT NILAI + BADGE -->
                            <div class="flex items-center gap-4 flex-shrink-0">
                                @if($nilaiLama)
                                    <span class="px-5 py-2 bg-purple-100 text-purple-800 rounded-full text-base font-extrabold whitespace-nowrap shadow-md">
                                        {{ number_format($nilaiLama, 2) }}
                                    </span>
                                @endif
                                <input type="number"
                                       name="nilai[{{ $s->id }}]"
                                       value="{{ old('nilai.' . $s->id, $nilaiLama) }}"
                                       class="w-32 px-6 py-5 text-2xl font-extrabold text-center rounded-2xl border-4 border-indigo-300 focus:border-purple-600 focus:ring-8 focus:ring-purple-200 transition-all shadow-inner [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                       min="0"
                                       max="100"
                                       step="0.01"
                                       placeholder="0"
                                       oninput="if(this.value > 100) this.value = 100; if(this.value < 0) this.value = 0;">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- TOMBOL INDIGO-PURPLE -->
            <div class="mt-12 flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('guru.nilai.pilih-kategori', [$kelas->id, $mapel->id]) }}"
                   class="px-12 py-5 bg-gradient-to-r from-gray-600 to-gray-800 hover:from-gray-700 hover:to-gray-900 text-white font-bold text-xl rounded-2xl shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all text-center">
                    Kembali
                </a>
                <button type="submit"
                        class="px-20 py-5 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 text-white font-extrabold text-2xl rounded-2xl shadow-2xl hover:shadow-3xl transform hover:scale-110 transition-all">
                    Simpan Semua Nilai
                </button>
            </div>
        </form>
        
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
</script>
@endsection