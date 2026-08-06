{{-- resources/views/siswa/nilai/index.blade.php --}}
@extends('siswa.layouts.app')
@section('title', 'Rekap Nilai Saya')

@section('content')
<div class="max-w-5xl mx-auto py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl dark:border dark:border-white/[0.09] dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="relative p-6 flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-extrabold text-white dark:text-white/90 flex items-center gap-2 tracking-tight">
                    <i data-lucide="trending-up" class="w-6 h-6 flex-shrink-0"></i> Rekap nilai saya
                </h1>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2 text-sm text-blue-200 dark:text-white/40">
                    <span class="flex items-center gap-1"><i data-lucide="user" class="w-3.5 h-3.5"></i>{{ Auth::user()->siswa->nama }}</span>
                    <span>·</span>
                    <span class="flex items-center gap-1"><i data-lucide="school" class="w-3.5 h-3.5"></i>{{ Auth::user()->siswa->kelas->nama_kelas??'-' }}</span>
                </div>
            </div>
            <div class="flex gap-2 flex-shrink-0 z-10">
                <a href="{{ route('siswa.nilai.export.excel') }}" class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25 border border-white/20 text-white text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i><span class="hidden sm:inline">Excel</span>
                </a>
                <a href="{{ route('siswa.nilai.export.pdf') }}" class="flex items-center gap-1.5 px-3 py-2 bg-white/15 hover:bg-white/25 border border-white/20 text-white text-xs font-semibold rounded-xl transition">
                    <i data-lucide="file-text" class="w-4 h-4"></i><span class="hidden sm:inline">PDF</span>
                </a>
            </div>
        </div>
    </div>

    @php $smt1 = collect($rekapNilai)->where('semester',1); $smt2 = collect($rekapNilai)->where('semester',2); @endphp

    @foreach([1=>$smt1, 2=>$smt2] as $smt=>$data)
    @if($data->count() > 0)
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-white/[0.06]">
            <div class="flex items-center gap-3">
                <div class="{{ $smt==1 ? 'bg-blue-50 dark:bg-blue-500/15' : 'bg-indigo-50 dark:bg-indigo-500/15' }} rounded-xl p-2">
                    <i data-lucide="calendar" class="w-4 h-4 {{ $smt==1 ? 'text-blue-600 dark:text-blue-400' : 'text-indigo-600 dark:text-indigo-400' }}"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white/90 text-sm">Semester {{ $smt }}</p>
                    <p class="text-xs text-gray-400 dark:text-white/35">{{ $data->count() }} mata pelajaran</p>
                </div>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                         {{ $smt==1 ? 'bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-400/25' : 'bg-indigo-50 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-400/25' }}">
                {{ $smt==1 ? 'Ganjil' : 'Genap' }}
            </span>
        </div>

        {{-- MOBILE --}}
        <div class="lg:hidden divide-y divide-gray-100 dark:divide-white/[0.05]">
            @foreach($data as $r)
            @php $badge = match($r->predikat) { 'A'=>'bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/25','B'=>'bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-500/25','C'=>'bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/25','D'=>'bg-orange-50 dark:bg-orange-500/15 text-orange-700 dark:text-orange-400 border-orange-200 dark:border-orange-500/25',default=>'bg-red-50 dark:bg-red-500/15 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/25' }; @endphp
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-white/[0.04] transition">
                <div class="flex items-center justify-between mb-3">
                    <p class="font-semibold text-gray-900 dark:text-white/90 text-sm">{{ $r->mapel->nama_mapel }}</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $badge }}">{{ $r->predikat }}</span>
                </div>
                <div class="grid grid-cols-4 gap-2 text-center">
                    <div class="bg-gray-50 dark:bg-white/[0.04] rounded-xl p-2.5"><p class="text-xs text-gray-400 dark:text-white/30">Tugas</p><p class="font-bold text-gray-800 dark:text-white/80 text-sm">{{ $r->tugas }}</p></div>
                    <div class="bg-gray-50 dark:bg-white/[0.04] rounded-xl p-2.5"><p class="text-xs text-gray-400 dark:text-white/30">UTS</p><p class="font-bold text-gray-800 dark:text-white/80 text-sm">{{ $r->uts }}</p></div>
                    <div class="bg-gray-50 dark:bg-white/[0.04] rounded-xl p-2.5"><p class="text-xs text-gray-400 dark:text-white/30">UAS</p><p class="font-bold text-gray-800 dark:text-white/80 text-sm">{{ $r->uas }}</p></div>
                    <div class="{{ $smt==1 ? 'bg-blue-50 dark:bg-blue-500/10' : 'bg-indigo-50 dark:bg-indigo-500/10' }} rounded-xl p-2.5">
                        <p class="text-xs {{ $smt==1 ? 'text-blue-400 dark:text-blue-400' : 'text-indigo-400 dark:text-indigo-400' }}">Rata</p>
                        <p class="font-bold {{ $smt==1 ? 'text-blue-700 dark:text-blue-400' : 'text-indigo-700 dark:text-indigo-400' }} text-sm">{{ $r->rata_rata }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- DESKTOP --}}
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-white/[0.03] border-b border-gray-100 dark:border-white/[0.05]">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-white/40">Mata Pelajaran</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-white/40">Tugas</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-white/40">UTS</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-white/40">UAS</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-white/40">Rata-rata</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-white/40">Predikat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                    @foreach($data as $r)
                    @php $badge = match($r->predikat) { 'A'=>'bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/25','B'=>'bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-500/25','C'=>'bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/25','D'=>'bg-orange-50 dark:bg-orange-500/15 text-orange-700 dark:text-orange-400 border-orange-200 dark:border-orange-500/25',default=>'bg-red-50 dark:bg-red-500/15 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/25' }; @endphp
                    <tr class="hover:bg-gray-50/70 dark:hover:bg-white/[0.04] transition {{ $loop->even ? 'bg-gray-50/30 dark:bg-white/[0.02]' : '' }}">
                        <td class="px-5 py-4 font-semibold text-gray-900 dark:text-white/90">{{ $r->mapel->nama_mapel }}</td>
                        <td class="px-5 py-4 text-center text-gray-600 dark:text-white/60">{{ $r->tugas }}</td>
                        <td class="px-5 py-4 text-center text-gray-600 dark:text-white/60">{{ $r->uts }}</td>
                        <td class="px-5 py-4 text-center text-gray-600 dark:text-white/60">{{ $r->uas }}</td>
                        <td class="px-5 py-4 text-center font-bold {{ $smt==1 ? 'text-blue-700 dark:text-blue-400' : 'text-indigo-700 dark:text-indigo-400' }}">{{ $r->rata_rata }}</td>
                        <td class="px-5 py-4 text-center"><span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badge }}">{{ $r->predikat }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    @endforeach

    @if(collect($rekapNilai)->isEmpty())
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] p-16 text-center">
        <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
            <i data-lucide="book-x" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
        </div>
        <p class="font-semibold text-gray-700 dark:text-white/60">Belum ada nilai</p>
        <p class="text-xs text-gray-400 dark:text-white/30 mt-1">Nilai akan muncul setelah guru menginput</p>
    </div>
    @endif
</div>
@endsection