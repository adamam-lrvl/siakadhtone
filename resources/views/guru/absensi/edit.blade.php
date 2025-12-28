{{-- resources/views/guru/absensi/edit.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Edit Absensi • ' . $jadwal->mapel->nama_mapel)

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">

    <!-- CARD UTAMA -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

        <!-- HEADER INDIGO GRADIENT + ICON -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-5 text-white">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                    <i data-lucide="edit-3" class="w-7 h-7"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Edit Absensi</h2>
                    <p class="text-indigo-100 text-sm opacity-90">
                        {{ $jadwal->mapel->nama_mapel }} • {{ $jadwal->kelas->nama_kelas }}
                    </p>
                    <p class="text-indigo-100 text-sm opacity-90 mt-1">
                        {{ $jadwal->hari }} • {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                        {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- BODY -->
        <div class="p-5 md:p-7">
            <form action="{{ route('guru.absensi.update', $jadwal) }}" method="POST">
                @csrf @method('PUT')

                <!-- DAFTAR SISWA -->
                <div class="space-y-6">
                    @forelse($siswas as $siswa)
                        @php
                            $absen = $siswa->absensi->where('jadwal_id', $jadwal->id)->first();
                            $status = $absen?->status ?? 'H';
                        @endphp

                        <div class="bg-gray-50 rounded-2xl border border-gray-200 p-5 md:p-6 hover:border-indigo-400 transition-all">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <!-- Info Siswa -->
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold text-xl">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 text-lg">{{ $siswa->nama }}</p>
                                        <p class="text-sm text-gray-600">NIS: {{ $siswa->nis }}</p>
                                    </div>
                                </div>

                                <!-- Radio Status + ICON KECIL DI DALAM PILL -->
                                <div class="flex flex-wrap gap-3 justify-center md:justify-end">
                                    @foreach([
                                        'H' => ['Hadir', 'bg-emerald-100 text-emerald-800 ring-emerald-600', 'check-circle'],
                                        'I' => ['Izin',  'bg-blue-100 text-blue-800 ring-blue-600', 'mail-warning'],
                                        'S' => ['Sakit', 'bg-amber-100 text-amber-800 ring-amber-600', 'heart-handshake'],
                                        'A' => ['Alpa',  'bg-red-100 text-red-800 ring-red-600', 'x-circle'],
                                    ] as $kode => [$label, $style, $icon])
                                        <label class="cursor-pointer">
                                            <input type="radio"
                                                   name="kehadiran[{{ $siswa->id }}]"
                                                   value="{{ $kode }}"
                                                   class="sr-only peer"
                                                   {{ $status == $kode ? 'checked' : '' }}>
                                            <span class="inline-flex items-center gap-2 px-5 py-3 rounded-full text-sm font-bold transition-all
                                                         peer-checked:ring-4 peer-checked:ring-offset-2 {{ $style }}
                                                         hover:scale-105 active:scale-95">
                                                <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                                                {{ $label }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 text-gray-500">
                            <p class="text-lg font-medium">Tidak ada siswa di kelas ini</p>
                        </div>
                    @endforelse
                </div>

                <!-- TOMBOL + ICON -->
                <div class="mt-8 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition flex items-center justify-center gap-2">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('guru.absensi.show', $jadwal) }}"
                       class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition text-center flex items-center justify-center gap-2">
                        <i data-lucide="x" class="w-5 h-5"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
</script>
@endsection