{{-- resources/views/guru/nilai/input-kategori.blade.php --}}
@extends('guru.layouts.app')
@section('title', 'Input Nilai • ' . ucwords(str_replace('_', ' ', $kategori)))

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
                    Input nilai {{ ucwords(str_replace('_', ' ', $kategori)) }}
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
                    <span>·</span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        Semester {{ request('semester', 1) }}
                        ({{ request('semester', 1) == 1 ? 'Ganjil' : 'Genap' }})
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

    <form action="{{ route('guru.nilai.simpan-kategori', [$kelas->id, $mapel->id, $kategori]) }}" method="POST">
        @csrf
        <input type="hidden" name="semester" value="{{ request('semester', 1) }}">

        {{-- INFO SEMESTER --}}
        <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                    rounded-2xl border border-gray-200 dark:border-white/[0.07] px-5 py-3.5 mb-4
                    flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="{{ request('semester', 1) == 1 ? 'bg-blue-50 dark:bg-blue-500/15' : 'bg-indigo-50 dark:bg-indigo-500/15' }} rounded-xl p-2">
                    <i data-lucide="calendar" class="w-4 h-4 {{ request('semester', 1) == 1 ? 'text-blue-600 dark:text-blue-400' : 'text-indigo-600 dark:text-indigo-400' }}"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white/90">Semester {{ request('semester', 1) }}</p>
                    <p class="text-xs text-gray-400 dark:text-white/35">{{ request('semester', 1) == 1 ? 'Ganjil' : 'Genap' }}</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                         {{ request('semester', 1) == 1
                             ? 'bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-400/25'
                             : 'bg-indigo-50 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-400/25' }}">
                {{ request('semester', 1) == 1 ? 'Semester 1' : 'Semester 2' }}
            </span>
        </div>

        {{-- DAFTAR SISWA --}}
        <div class="space-y-3">
            @foreach($siswa as $index => $s)
            @php $nilaiLama = optional($s->nilai->first())->nilai ?? ''; @endphp
            <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl
                        rounded-2xl border border-gray-200 dark:border-white/[0.07]
                        p-4 hover:border-indigo-300 dark:hover:border-indigo-400/30
                        dark:hover:bg-white/[0.08] transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-indigo-50 dark:bg-indigo-500/15 rounded-full flex items-center justify-center
                                text-indigo-600 dark:text-indigo-400 font-bold text-xs flex-shrink-0">
                        {{ $index + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-900 dark:text-white/90 truncate">{{ $s->nama }}</p>
                        <p class="text-xs text-gray-400 dark:text-white/35">NIS: {{ $s->nis }}</p>
                    </div>
                    @if($nilaiLama)
                        <div class="flex-shrink-0 text-center hidden sm:block">
                            <p class="text-xs text-gray-400 dark:text-white/30">Nilai lama</p>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                         bg-indigo-50 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300
                                         border border-indigo-200 dark:border-indigo-400/25">
                                {{ number_format($nilaiLama, 2) }}
                            </span>
                        </div>
                    @endif
                    <div class="flex-shrink-0">
                        <input type="number" name="nilai[{{ $s->id }}]"
                               value="{{ old('nilai.' . $s->id, $nilaiLama) }}"
                               min="0" max="100" step="0.01" placeholder="0"
                               oninput="if(this.value > 100) this.value = 100; if(this.value < 0) this.value = 0;"
                               class="w-20 px-3 py-2 text-center font-bold text-gray-900 dark:text-white/90 text-sm
                                      border border-gray-200 dark:border-white/[0.12] rounded-xl
                                      bg-gray-50 dark:bg-white/[0.06]
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-indigo-400/50
                                      focus:border-blue-500 dark:focus:border-indigo-400
                                      focus:bg-white dark:focus:bg-white/[0.10] transition
                                      [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-3 mt-6">
            <a href="{{ route('guru.nilai.pilih-kategori', [$kelas->id, $mapel->id]) }}"
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