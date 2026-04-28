{{-- resources/views/guru/absensi/edit.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Edit Absensi • ' . $jadwal->mapel->nama_mapel)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER (SAMA PERSIS SHOW) --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="edit-3" class="w-6 h-6"></i>
                    Edit Absensi
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

            {{-- TOTAL SISWA --}}
            <div class="bg-white/15 rounded-xl px-4 py-2 text-center min-w-[60px]">
                <p class="text-xl font-bold">{{ $siswas->count() }}</p>
                <p class="text-xs text-blue-100">Siswa</p>
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <form action="{{ route('guru.absensi.update', $jadwal) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

            @forelse($siswas as $index => $siswa)
                @php
                    $absen = $siswa->absensi->where('jadwal_id', $jadwal->id)->first();
                    $status = $absen?->status ?? 'H';
                @endphp

                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 px-5 py-4 border-b last:border-none hover:bg-gray-50 transition">

                    {{-- INFO SISWA --}}
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-8 h-8 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600 font-bold text-xs">
                            {{ $index + 1 }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-900 text-sm truncate">
                                {{ $siswa->nama }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $siswa->nis }}
                            </p>
                        </div>
                    </div>

                    {{-- STATUS (PILL STYLE KAYAK SHOW) --}}
                    <div class="grid grid-cols-4 gap-2 w-full lg:w-auto">
                        @foreach([
                            'H' => ['Hadir', 'bg-emerald-50 text-emerald-700 border-emerald-200', 'check-circle'],
                            'I' => ['Izin',  'bg-blue-50 text-blue-700 border-blue-200', 'mail'],
                            'S' => ['Sakit', 'bg-amber-50 text-amber-700 border-amber-200', 'heart-handshake'],
                            'A' => ['Alpa',  'bg-red-50 text-red-700 border-red-200', 'x-circle'],
                        ] as $kode => [$label, $style, $icon])

                            <label class="cursor-pointer">
                                <input type="radio"
                                       name="kehadiran[{{ $siswa->id }}]"
                                       value="{{ $kode }}"
                                       class="sr-only peer"
                                       {{ $status == $kode ? 'checked' : '' }}>

                                <span class="flex items-center justify-center gap-1.5 px-2 py-1.5 rounded-xl text-xs font-semibold border transition
                                    {{ $style }}
                                    peer-checked:ring-2 peer-checked:ring-indigo-500 peer-checked:ring-offset-1">

                                    <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                                    <span class="hidden sm:inline">{{ $label }}</span>
                                </span>
                            </label>

                        @endforeach
                    </div>
                </div>

            @empty
                <div class="text-center py-16 text-gray-400">
                    <i data-lucide="users-x" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                    <p class="text-sm font-medium">Tidak ada siswa</p>
                </div>
            @endforelse

        </div>

        {{-- ACTION BUTTONS (SAMA SHOW) --}}
        <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-3 mt-6">
            <a href="{{ route('guru.absensi.show', $jadwal) }}"
               class="px-5 py-2.5 border border-gray-200 rounded-xl text-gray-700 font-semibold
                      text-sm hover:bg-gray-50 transition flex items-center justify-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali
            </a>

            <button type="submit"
                    class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600
                           hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl
                           font-semibold text-sm shadow-sm hover:shadow-md transition
                           flex items-center justify-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan Perubahan
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