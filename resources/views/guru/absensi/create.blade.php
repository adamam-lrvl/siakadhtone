{{-- resources/views/guru/absensi/create.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Absensi • ' . $jadwal->mapel->nama_mapel)

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
                    <i data-lucide="clipboard-check" class="w-6 h-6 flex-shrink-0"></i>
                    Absensi siswa
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

    @if($errors->any())
        <div class="p-4 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-xl text-red-700 dark:text-red-300 text-sm">
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li class="flex items-center gap-2"><i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('guru.absensi.store', $jadwal->id) }}" method="POST">
        @csrf
        <div class="space-y-3">
            @forelse($siswas as $siswa)
            @php
                $absen  = $siswa->absensi->firstWhere('jadwal_id', $jadwal->id);
                $status = $absen ? $absen->status : 'H';
            @endphp
            <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                        rounded-2xl border border-gray-200 dark:border-white/[0.07]
                        p-4 hover:border-indigo-300 dark:hover:border-indigo-400/30
                        dark:hover:bg-white/[0.08] transition-all">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 bg-indigo-50 dark:bg-indigo-500/15 rounded-full flex items-center justify-center
                                text-indigo-600 dark:text-indigo-400 font-bold text-sm flex-shrink-0">
                        {{ $loop->iteration }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900 dark:text-white/90 truncate">{{ $siswa->nama }}</p>
                        <p class="text-xs text-gray-400 dark:text-white/35">NIS: {{ $siswa->nis }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-2">
                    @foreach([
                        'H' => ['Hadir', 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-800 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20 peer-checked:bg-emerald-100 dark:peer-checked:bg-emerald-500/25 peer-checked:border-emerald-500 dark:peer-checked:border-emerald-400 peer-checked:ring-2 peer-checked:ring-emerald-400 dark:peer-checked:ring-emerald-500/50', 'check-circle'],
                        'I' => ['Izin',  'bg-blue-50 dark:bg-blue-500/10 text-blue-800 dark:text-blue-400 border-blue-200 dark:border-blue-500/20 peer-checked:bg-blue-100 dark:peer-checked:bg-blue-500/25 peer-checked:border-blue-500 dark:peer-checked:border-blue-400 peer-checked:ring-2 peer-checked:ring-blue-400 dark:peer-checked:ring-blue-500/50', 'mail'],
                        'S' => ['Sakit', 'bg-amber-50 dark:bg-amber-500/10 text-amber-800 dark:text-amber-400 border-amber-200 dark:border-amber-500/20 peer-checked:bg-amber-100 dark:peer-checked:bg-amber-500/25 peer-checked:border-amber-500 dark:peer-checked:border-amber-400 peer-checked:ring-2 peer-checked:ring-amber-400 dark:peer-checked:ring-amber-500/50', 'heart-handshake'],
                        'A' => ['Alpa',  'bg-red-50 dark:bg-red-500/10 text-red-800 dark:text-red-400 border-red-200 dark:border-red-500/20 peer-checked:bg-red-100 dark:peer-checked:bg-red-500/25 peer-checked:border-red-500 dark:peer-checked:border-red-400 peer-checked:ring-2 peer-checked:ring-red-400 dark:peer-checked:ring-red-500/50', 'x-circle'],
                    ] as $kode => [$label, $style, $icon])
                        <label class="cursor-pointer">
                            <input type="radio" name="kehadiran[{{ $siswa->id }}]" value="{{ $kode }}"
                                   class="sr-only peer" {{ $status == $kode ? 'checked' : '' }}>
                            <span class="flex flex-col items-center gap-1 px-2 py-2.5 rounded-xl border text-xs font-semibold transition-all hover:scale-105 active:scale-95 {{ $style }}">
                                <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                                {{ $label }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
            @empty
            <div class="bg-white dark:bg-white/[0.05] rounded-2xl border border-gray-200 dark:border-white/[0.07] p-16 text-center">
                <div class="bg-indigo-50 dark:bg-indigo-500/15 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="users" class="w-8 h-8 text-indigo-400 dark:text-indigo-400"></i>
                </div>
                <p class="font-semibold text-gray-700 dark:text-white/60">Tidak ada siswa di kelas ini</p>
            </div>
            @endforelse
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 mt-6">
            <a href="{{ route('guru.absensi.index') }}"
               class="px-5 py-2.5 border-2 border-gray-200 dark:border-white/[0.10] rounded-xl
                      text-gray-600 dark:text-white/50 font-semibold text-sm
                      hover:bg-gray-50 dark:hover:bg-white/[0.07] transition
                      flex items-center justify-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit"
                    class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-xl font-bold text-sm transition flex items-center justify-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan absensi
            </button>
        </div>
    </form>
</div>
@endsection