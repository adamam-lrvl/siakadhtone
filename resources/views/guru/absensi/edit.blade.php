{{-- resources/views/guru/absensi/edit.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Edit Absensi • ' . $jadwal->mapel->nama_mapel)

@section('content')
<div class="max-w-4xl mx-auto py-6 space-y-6">

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
                    Edit absensi
                </h1>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2 text-sm text-blue-200 dark:text-white/40">
                    <span class="flex items-center gap-1">
                        <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                        {{ $jadwal->mapel->nama_mapel }}
                    </span>
                    <span>·</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="users" class="w-3.5 h-3.5"></i>
                        {{ $jadwal->kelas->nama_kelas }}
                    </span>
                    <span>·</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} –
                        {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                    </span>
                </div>
            </div>
            <div class="bg-white/15 dark:bg-white/[0.07] border border-white/20 dark:border-white/[0.09]
                        backdrop-blur-sm rounded-xl px-4 py-2 text-center flex-shrink-0">
                <p class="text-xl font-bold text-white dark:text-white/90">{{ $siswas->count() }}</p>
                <p class="text-xs text-blue-100 dark:text-white/40">Siswa</p>
            </div>
        </div>
    </div>

    <form action="{{ route('guru.absensi.update', $jadwal) }}" method="POST">
        @csrf @method('PUT')

        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">
            @forelse($siswas as $index => $siswa)
            @php
                $absen  = $siswa->absensi->where('jadwal_id', $jadwal->id)->first();
                $status = $absen?->status ?? 'H';
            @endphp
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 px-5 py-4
                        border-b border-gray-100 dark:border-white/[0.05] last:border-none
                        hover:bg-gray-50 dark:hover:bg-white/[0.04] transition">

                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 bg-indigo-50 dark:bg-indigo-500/15 rounded-full flex items-center justify-center
                                text-indigo-600 dark:text-indigo-400 font-bold text-xs flex-shrink-0">
                        {{ $index + 1 }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900 dark:text-white/90 text-sm truncate">{{ $siswa->nama }}</p>
                        <p class="text-xs text-gray-400 dark:text-white/35">{{ $siswa->nis }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-2 w-full lg:w-auto">
                    @foreach([
                        'H' => ['Hadir', 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20', 'check-circle'],
                        'I' => ['Izin',  'bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-500/20', 'mail'],
                        'S' => ['Sakit', 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/20', 'heart-handshake'],
                        'A' => ['Alpa',  'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/20', 'x-circle'],
                    ] as $kode => [$label, $style, $icon])
                        <label class="cursor-pointer">
                            <input type="radio" name="kehadiran[{{ $siswa->id }}]" value="{{ $kode }}"
                                   class="sr-only peer" {{ $status == $kode ? 'checked' : '' }}>
                            <span class="flex items-center justify-center gap-1.5 px-2 py-1.5 rounded-xl text-xs font-semibold border transition
                                         {{ $style }}
                                         peer-checked:ring-2 peer-checked:ring-indigo-500 dark:peer-checked:ring-indigo-400/60 peer-checked:ring-offset-1 dark:peer-checked:ring-offset-0">
                                <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                                <span class="hidden sm:inline">{{ $label }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
            @empty
            <div class="text-center py-16">
                <i data-lucide="users-x" class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-white/20"></i>
                <p class="text-sm font-medium text-gray-400 dark:text-white/30">Tidak ada siswa</p>
            </div>
            @endforelse
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-3 mt-6">
            <a href="{{ route('guru.absensi.show', $jadwal) }}"
               class="px-5 py-2.5 border-2 border-gray-200 dark:border-white/[0.10] rounded-xl
                      text-gray-600 dark:text-white/50 font-semibold text-sm
                      hover:bg-gray-50 dark:hover:bg-white/[0.07] transition
                      flex items-center justify-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
            <button type="submit"
                    class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-xl font-bold text-sm transition flex items-center justify-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan perubahan
            </button>
        </div>
    </form>
</div>
@endsection