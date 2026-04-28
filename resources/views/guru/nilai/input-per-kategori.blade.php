{{-- resources/views/guru/nilai/input-kategori.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Input Nilai • ' . ucwords(str_replace('_', ' ', $kategori)))

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER BIRU --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="edit-3" class="w-6 h-6 flex-shrink-0"></i>
                    <span>Input nilai {{ ucwords(str_replace('_', ' ', $kategori)) }}</span>
                </h1>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2 text-sm text-blue-100">
                    <span class="flex items-center gap-1">
                        <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                        {{ $mapel->nama_mapel }}
                    </span>
                    <span class="text-blue-300">•</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="users" class="w-3.5 h-3.5"></i>
                        {{ $kelas->nama_kelas }}
                    </span>
                    <span class="text-blue-300">•</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        Semester {{ request('semester', 1) }}
                        ({{ request('semester', 1) == 1 ? 'Ganjil' : 'Genap' }})
                    </span>
                </div>
            </div>
            <div class="bg-white/15 rounded-xl px-4 py-2 text-center flex-shrink-0">
                <p class="text-xl font-bold">{{ $siswa->count() }}</p>
                <p class="text-xs text-blue-100">Siswa</p>
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <form action="{{ route('guru.nilai.simpan-kategori', [$kelas->id, $mapel->id, $kategori]) }}"
          method="POST">
        @csrf

        {{-- SEMESTER — hidden + display --}}
        <input type="hidden" name="semester" value="{{ request('semester', 1) }}">

        <div class="bg-white rounded-2xl border border-gray-200 px-5 py-3.5 mb-4
                    flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="{{ request('semester', 1) == 1 ? 'bg-blue-50' : 'bg-indigo-50' }} rounded-xl p-2">
                    <i data-lucide="calendar" class="w-4 h-4 {{ request('semester', 1) == 1 ? 'text-blue-600' : 'text-indigo-600' }}"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">
                        Semester {{ request('semester', 1) }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ request('semester', 1) == 1 ? 'Ganjil' : 'Genap' }}
                    </p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                         {{ request('semester', 1) == 1
                             ? 'bg-blue-50 text-blue-700 border border-blue-200'
                             : 'bg-indigo-50 text-indigo-700 border border-indigo-200' }}">
                {{ request('semester', 1) == 1 ? 'Semester 1' : 'Semester 2' }}
            </span>
        </div>

        {{-- DAFTAR SISWA --}}
        <div class="space-y-3">
            @foreach($siswa as $index => $s)
                @php
                    $nilaiLama = optional($s->nilai->first())->nilai ?? '';
                @endphp

                <div class="bg-white rounded-2xl border border-gray-200 p-4
                            hover:border-indigo-300 transition-all">
                    <div class="flex items-center gap-3">

                        {{-- NOMOR --}}
                        <div class="w-8 h-8 bg-indigo-50 rounded-full flex items-center justify-center
                                    text-indigo-600 font-bold text-xs flex-shrink-0">
                            {{ $index + 1 }}
                        </div>

                        {{-- INFO SISWA --}}
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $s->nama }}</p>
                            <p class="text-xs text-gray-400">NIS: {{ $s->nis }}</p>
                        </div>

                        {{-- NILAI LAMA --}}
                        @if($nilaiLama)
                            <div class="flex-shrink-0 text-center hidden sm:block">
                                <p class="text-xs text-gray-400">Nilai lama</p>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs
                                             font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                    {{ number_format($nilaiLama, 2) }}
                                </span>
                            </div>
                        @endif

                        {{-- INPUT NILAI --}}
                        <div class="flex-shrink-0">
                            <input type="number"
                                   name="nilai[{{ $s->id }}]"
                                   value="{{ old('nilai.' . $s->id, $nilaiLama) }}"
                                   min="0" max="100" step="0.01"
                                   placeholder="0"
                                   oninput="if(this.value > 100) this.value = 100; if(this.value < 0) this.value = 0;"
                                   class="w-20 px-3 py-2 text-center font-bold text-gray-900 text-sm
                                          border border-gray-200 rounded-xl bg-gray-50
                                          focus:outline-none focus:ring-2 focus:ring-blue-500
                                          focus:border-blue-500 focus:bg-white transition
                                          [appearance:textfield]
                                          [&::-webkit-outer-spin-button]:appearance-none
                                          [&::-webkit-inner-spin-button]:appearance-none">
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- TOMBOL --}}
        <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-3 mt-6">
            <a href="{{ route('guru.nilai.pilih-kategori', [$kelas->id, $mapel->id]) }}"
               class="px-5 py-2.5 border border-gray-200 rounded-xl text-gray-700 font-semibold
                      text-sm hover:bg-gray-50 hover:border-gray-300 transition
                      flex items-center justify-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali
            </a>
            <button type="submit"
                    class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600
                           hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl
                           font-semibold text-sm shadow-sm hover:shadow-md transition
                           flex items-center justify-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan semua nilai
            </button>
        </div>

    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
</script>
@endsection