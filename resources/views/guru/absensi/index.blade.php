{{-- resources/views/guru/absensi/index.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Absensi Hari Ini')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-5 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <h1 class="text-xl sm:text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="calendar-check" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                    Absensi hari ini
                </h1>
                <p class="text-blue-100 text-sm mt-1">
                    {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}
                </p>
            </div>

            {{-- STATS --}}
            <div class="flex gap-2">
                <div class="bg-white/15 rounded-xl px-3 py-2 text-center flex-1">
                    <p class="text-lg sm:text-xl font-bold">{{ $jadwals->count() }}</p>
                    <p class="text-[10px] sm:text-xs text-blue-100">Jadwal</p>
                </div>
                <div class="bg-white/15 rounded-xl px-3 py-2 text-center flex-1">
                    <p class="text-lg sm:text-xl font-bold">
                        {{ $jadwals->filter(fn($j) => $j->absensi->count() > 0)->count() }}
                    </p>
                    <p class="text-[10px] sm:text-xs text-blue-100">Diabsen</p>
                </div>
            </div>

        </div>
    </div>

    {{-- LIST --}}
    <div class="space-y-3">
        @forelse($jadwals as $j)

        <div class="bg-white rounded-2xl border border-gray-200 p-4 hover:border-indigo-300 hover:shadow-md transition">

            {{-- TOP --}}
            <div class="flex flex-col sm:flex-row sm:items-start gap-3">

                {{-- LEFT --}}
                <div class="flex items-start gap-3 flex-1">
                    <div class="bg-indigo-50 rounded-xl p-2">
                        <i data-lucide="book-open" class="w-5 h-5 text-indigo-600"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900 text-sm sm:text-base leading-snug">
                            {{ $j->mapel->nama_mapel }}
                            @if($j->mapel->kode)
                                <span class="text-xs text-gray-400">({{ $j->mapel->kode }})</span>
                            @endif
                        </p>

                        <div class="flex flex-wrap gap-x-3 gap-y-1 mt-1 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i data-lucide="users" class="w-3 h-3"></i>
                                {{ $j->kelas->nama_kelas }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i data-lucide="clock" class="w-3 h-3"></i>
                                {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} –
                                {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- BADGE --}}
                <div class="self-start sm:self-auto">
                    @if($j->absensi->count() > 0)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] sm:text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <i data-lucide="check-circle" class="w-3 h-3"></i>
                            Sudah
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] sm:text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            Belum
                        </span>
                    @endif
                </div>

            </div>

            {{-- ACTION --}}
            <div class="mt-4 pt-3 border-t border-gray-100 flex flex-col sm:flex-row gap-2">

                @if($j->absensi->count() > 0)

                    <a href="{{ route('guru.absensi.show', $j) }}"
                       class="w-full sm:w-auto px-4 py-2 text-xs font-semibold rounded-xl bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 transition flex items-center justify-center gap-1.5">
                        <i data-lucide="eye" class="w-3 h-3"></i>
                        Lihat rekap
                    </a>

                    <a href="{{ route('guru.absensi.edit', $j) }}"
                       class="w-full sm:w-auto px-4 py-2 text-xs font-semibold rounded-xl bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 transition flex items-center justify-center gap-1.5">
                        <i data-lucide="edit-3" class="w-3 h-3"></i>
                        Edit absen
                    </a>

                @else

                    <a href="{{ route('guru.absensi.create', $j) }}"
                       class="w-full sm:w-auto px-5 py-2 text-xs font-bold rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white shadow-sm transition flex items-center justify-center gap-1.5">
                        <i data-lucide="user-check" class="w-3 h-3"></i>
                        Absen sekarang
                    </a>

                @endif

            </div>

        </div>

        @empty
        <div class="bg-white rounded-2xl border border-gray-200 p-12 sm:p-16 text-center">
            <div class="bg-indigo-50 rounded-full w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="calendar-x2" class="w-6 h-6 sm:w-8 sm:h-8 text-indigo-400"></i>
            </div>
            <p class="font-semibold text-gray-700">Tidak ada jadwal hari ini</p>
            <p class="text-sm text-gray-400 mt-1">Nikmati hari libur Anda!</p>
        </div>
        @endforelse
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    lucide.createIcons();
});
</script>
@endsection