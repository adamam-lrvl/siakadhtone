{{-- resources/views/siswa/pengumuman/index.blade.php --}}
@extends('siswa.layouts.app')
@section('title', 'Pengumuman')

@section('content')
<div class="max-w-5xl mx-auto py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl dark:border dark:border-white/[0.09] dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="relative p-6 flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-extrabold text-white dark:text-white/90 flex items-center gap-2 tracking-tight">
                    <i data-lucide="megaphone" class="w-6 h-6 flex-shrink-0"></i> Pengumuman sekolah
                </h1>
                <p class="text-blue-200 dark:text-white/40 text-sm mt-1">Informasi terbaru untuk {{ Auth::user()->siswa->nama }}</p>
            </div>
            <div class="bg-white/15 dark:bg-white/[0.07] border border-white/20 dark:border-white/[0.09] backdrop-blur-sm rounded-xl px-4 py-2 text-center flex-shrink-0">
                <p class="text-xl font-bold text-white dark:text-white/90">{{ $pengumuman->total() }}</p>
                <p class="text-xs text-blue-100 dark:text-white/40">Pengumuman</p>
            </div>
        </div>
    </div>

    {{-- LIST --}}
    @forelse($pengumuman as $p)
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07]
                hover:border-indigo-300 dark:hover:border-indigo-400/30 hover:shadow-md dark:hover:bg-white/[0.08] transition-all">
        @if($p->gambar)
            <div class="bg-gray-50 dark:bg-white/[0.03] flex items-center justify-center px-6 py-4 border-b border-gray-100 dark:border-white/[0.06]">
                <img src="{{ Storage::url($p->gambar) }}" alt="{{ $p->judul }}" class="w-full max-w-2xl h-auto rounded-xl object-contain max-h-52">
            </div>
        @endif
        <div class="p-5">
            <div class="flex items-start justify-between gap-3 mb-3">
                <h3 class="font-bold text-gray-900 dark:text-white/90 text-base leading-snug">{{ $p->judul }}</h3>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold flex-shrink-0
                             bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-400
                             border border-emerald-200 dark:border-emerald-500/25">
                    <i data-lucide="circle-dot" class="w-3 h-3"></i> Aktif
                </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-white/50 leading-relaxed line-clamp-3">
                {!! Str::limit(strip_tags($p->isi), 200) !!}
            </p>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-white/[0.06] flex items-center gap-3 text-xs text-gray-400 dark:text-white/30">
                <span class="flex items-center gap-1">
                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                    {{ $p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d F Y') : $p->created_at->translatedFormat('d F Y') }}
                </span>
                <span class="flex items-center gap-1">
                    <i data-lucide="user" class="w-3.5 h-3.5"></i>
                    {{ $p->user->name ?? 'Admin' }}
                </span>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] p-16 text-center">
        <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
            <i data-lucide="volume-x" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
        </div>
        <p class="font-semibold text-gray-700 dark:text-white/60">Belum ada pengumuman</p>
        <p class="text-xs text-gray-400 dark:text-white/30 mt-1">Tunggu info terbaru dari sekolah ya!</p>
    </div>
    @endforelse

    @if($pengumuman->hasPages())
    <div class="px-1">{{ $pengumuman->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection