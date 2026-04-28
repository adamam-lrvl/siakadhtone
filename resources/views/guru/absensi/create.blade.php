{{-- resources/views/guru/absensi/create.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Absensi • ' . $jadwal->mapel->nama_mapel)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER BIRU --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="clipboard-check" class="w-6 h-6 flex-shrink-0"></i>
                    <span>Absensi siswa</span>
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
                </div>
            </div>
            <div class="bg-white/15 rounded-xl px-4 py-2 text-center flex-shrink-0">
                <p class="text-xl font-bold">{{ $siswas->count() }}</p>
                <p class="text-xs text-blue-100">Siswa</p>
            </div>
        </div>
    </div>

    {{-- ERROR --}}
    @if($errors->any())
        <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li class="flex items-center gap-2">
                        <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('guru.absensi.store', $jadwal->id) }}" method="POST">
        @csrf

        <div class="space-y-3">
            @forelse($siswas as $siswa)
                @php
                    $absen  = $siswa->absensi->firstWhere('jadwal_id', $jadwal->id);
                    $status = $absen ? $absen->status : 'H';
                @endphp

                <div class="bg-white rounded-2xl border border-gray-200 p-4 hover:border-indigo-300 transition-all">

                    {{-- BARIS ATAS: avatar + info --}}
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 bg-indigo-50 rounded-full flex items-center justify-center
                                    text-indigo-600 font-bold text-sm flex-shrink-0">
                            {{ $loop->iteration }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $siswa->nama }}</p>
                            <p class="text-xs text-gray-400">NIS: {{ $siswa->nis }}</p>
                        </div>
                    </div>

                    {{-- BARIS BAWAH: radio status --}}
                    <div class="grid grid-cols-4 gap-2">
                        @foreach([
                            'H' => ['Hadir', 'bg-emerald-50 text-emerald-800 border-emerald-200 peer-checked:bg-emerald-100 peer-checked:border-emerald-500 peer-checked:ring-2 peer-checked:ring-emerald-400', 'check-circle'],
                            'I' => ['Izin',  'bg-blue-50 text-blue-800 border-blue-200 peer-checked:bg-blue-100 peer-checked:border-blue-500 peer-checked:ring-2 peer-checked:ring-blue-400', 'mail'],
                            'S' => ['Sakit', 'bg-amber-50 text-amber-800 border-amber-200 peer-checked:bg-amber-100 peer-checked:border-amber-500 peer-checked:ring-2 peer-checked:ring-amber-400', 'heart-handshake'],
                            'A' => ['Alpa',  'bg-red-50 text-red-800 border-red-200 peer-checked:bg-red-100 peer-checked:border-red-500 peer-checked:ring-2 peer-checked:ring-red-400', 'x-circle'],
                        ] as $kode => [$label, $style, $icon])
                            <label class="cursor-pointer">
                                <input type="radio"
                                       name="kehadiran[{{ $siswa->id }}]"
                                       value="{{ $kode }}"
                                       class="sr-only peer"
                                       {{ $status == $kode ? 'checked' : '' }}>
                                <span class="flex flex-col items-center gap-1 px-2 py-2.5 rounded-xl
                                             border text-xs font-semibold transition-all
                                             hover:scale-105 active:scale-95 {{ $style }}">
                                    <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                                    {{ $label }}
                                </span>
                            </label>
                        @endforeach
                    </div>

                </div>
            @empty
                <div class="bg-white rounded-2xl border border-gray-200 p-16 text-center">
                    <div class="bg-indigo-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="users" class="w-8 h-8 text-indigo-400"></i>
                    </div>
                    <p class="font-semibold text-gray-700">Tidak ada siswa di kelas ini</p>
                </div>
            @endforelse
        </div>

        {{-- TOMBOL --}}
        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 mt-6">
            <a href="{{ route('guru.jadwal.index') }}"
               class="px-5 py-2.5 border border-gray-200 rounded-xl text-gray-700 font-semibold
                      text-sm hover:bg-gray-50 hover:border-gray-300 transition
                      flex items-center justify-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Batal
            </a>
            <button type="submit"
                    class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600
                           hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl
                           font-semibold text-sm shadow-sm hover:shadow-md transition
                           flex items-center justify-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan absensi
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