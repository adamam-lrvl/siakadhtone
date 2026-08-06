{{-- resources/views/guru/nilai/edit.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Input Nilai')

@section('content')
<div class="max-w-6xl mx-auto py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:border dark:border-white/[0.09]
                dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="relative p-6 flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-extrabold text-white dark:text-white/90 flex items-center gap-2 tracking-tight">
                    <i data-lucide="edit-3" class="w-6 h-6 flex-shrink-0"></i>
                    Input nilai siswa
                </h1>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2 text-sm text-blue-200 dark:text-white/40">
                    <span class="flex items-center gap-1">
                        <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                        {{ $mapel->nama_mapel }}
                    </span>
                    <span>·</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="users" class="w-3.5 h-3.5"></i>
                        {{ $kelas->nama_kelas }}
                    </span>
                </div>
            </div>
            <div class="bg-white/15 dark:bg-white/[0.07] border border-white/20 dark:border-white/[0.09]
                        backdrop-blur-sm rounded-xl px-4 py-2 text-center flex-shrink-0">
                <p class="text-xl font-bold text-white dark:text-white/90">{{ $siswa->count() }}</p>
                <p class="text-xs text-blue-100 dark:text-white/40">Siswa</p>
            </div>
        </div>
    </div>

    <form action="{{ route('guru.nilai.update', [$kelas->id, $mapel->id]) }}" method="POST">
        @csrf @method('PUT')

        {{-- SEMESTER SELECTOR --}}
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                    rounded-2xl border border-gray-200 dark:border-white/[0.07] px-5 py-4 mb-4">
            @php
            $ic = "px-4 py-2.5 text-sm rounded-xl transition bg-white dark:bg-white/[0.06] text-gray-900 dark:text-white/90 border border-gray-200 dark:border-white/[0.10] focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-indigo-400/50";
            $lc = "block text-xs font-semibold text-gray-600 dark:text-white/40 mb-1.5";
            @endphp
            <label class="{{ $lc }}">Semester</label>
            <select name="semester" class="{{ $ic }} w-48">
                <option value="1" {{ old('semester', 1) == 1 ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                <option value="2" {{ old('semester', 1) == 2 ? 'selected' : '' }}>Semester 2 (Genap)</option>
            </select>
        </div>

        {{-- TABEL --}}
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                            <th class="px-4 py-3.5 text-center font-semibold w-10">No</th>
                            <th class="px-4 py-3.5 text-left font-semibold w-28">NIS</th>
                            <th class="px-4 py-3.5 text-left font-semibold">Nama Siswa</th>
                            @foreach($kategori as $kat)
                                <th class="px-4 py-3.5 text-center font-semibold capitalize w-24">
                                    {{ str_replace('_', ' ', $kat) }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                        @foreach($siswa as $index => $sis)
                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-white/[0.04] transition {{ $loop->even ? 'bg-gray-50/50 dark:bg-white/[0.02]' : '' }}">
                            <td class="px-4 py-3.5 text-center text-gray-400 dark:text-white/30 text-xs">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3.5 text-gray-500 dark:text-white/40 text-xs">{{ $sis->nis }}</td>
                            <td class="px-4 py-3.5 font-semibold text-gray-900 dark:text-white/90">{{ $sis->nama }}</td>
                            @foreach($kategori as $kat)
                            @php
                                $nilaiKategori = optional(
                                    $sis->nilai->where('mapel_id', $mapel->id)->where('kategori', $kat)->first()
                                )->nilai ?? '';
                            @endphp
                            <td class="px-2 py-3 text-center">
                                <input type="number"
                                       name="nilai[{{ $sis->id }}][{{ $kat }}]"
                                       value="{{ old('nilai.'.$sis->id.'.'.$kat, $nilaiKategori) }}"
                                       min="0" max="100" step="0.01" placeholder="0"
                                       class="w-20 px-2 py-1.5 text-center font-bold text-gray-900 dark:text-white/90 text-sm
                                              border border-gray-200 dark:border-white/[0.10] rounded-xl
                                              bg-gray-50 dark:bg-white/[0.05]
                                              focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-indigo-400/50
                                              focus:bg-white dark:focus:bg-white/[0.10] transition
                                              [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none
                                              @error('nilai.'.$sis->id.'.'.$kat) border-red-400 @enderror">
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-3 mt-6">
            <a href="{{ route('guru.nilai.index') }}"
               class="px-5 py-2.5 border-2 border-gray-200 dark:border-white/[0.10] rounded-xl
                      text-gray-600 dark:text-white/50 font-semibold text-sm
                      hover:bg-gray-50 dark:hover:bg-white/[0.07] transition
                      flex items-center justify-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
            <button type="submit"
                    class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-xl font-bold text-sm transition flex items-center justify-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan semua nilai
            </button>
        </div>
    </form>
</div>
@endsection