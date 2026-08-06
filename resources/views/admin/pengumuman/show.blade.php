{{-- resources/views/admin/pengumuman/show.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Pengumuman - ' . $pengumuman->judul)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:border dark:border-white/[0.09]
                dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="relative p-6 flex items-start justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <div class="bg-white/15 backdrop-blur-sm border border-white/20 rounded-xl p-2.5 flex-shrink-0">
                    <i data-lucide="megaphone" class="w-5 h-5 text-white"></i>
                </div>
                <div class="min-w-0">
                    <h1 class="text-xl font-extrabold text-white tracking-tight">Detail pengumuman</h1>
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 text-sm text-blue-200 dark:text-white/40">
                        <span class="flex items-center gap-1">
                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                            {{ $pengumuman->tanggal->translatedFormat('d F Y') }}
                        </span>
                        <span>·</span>
                        @if($pengumuman->aktif)
                            <span class="flex items-center gap-1 text-emerald-300 dark:text-emerald-400">
                                <i data-lucide="circle-dot" class="w-3.5 h-3.5"></i>
                                Dipublikasikan
                            </span>
                        @else
                            <span class="flex items-center gap-1 text-amber-300 dark:text-amber-400">
                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                Draft
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @if($pengumuman->aktif)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold flex-shrink-0
                             bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-300
                             border border-emerald-200 dark:border-emerald-500/25">
                    <i data-lucide="check-circle" class="w-3 h-3"></i> Aktif
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold flex-shrink-0
                             bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300
                             border border-amber-200 dark:border-amber-500/25">
                    <i data-lucide="clock" class="w-3 h-3"></i> Draft
                </span>
            @endif
        </div>
    </div>

    {{-- KONTEN --}}
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">

        @if($pengumuman->gambar)
            <div class="border-b border-gray-100 dark:border-white/[0.06] flex justify-center bg-gray-50 dark:bg-white/[0.03] px-6 py-5">
                <img src="{{ Storage::url($pengumuman->gambar) }}" alt="{{ $pengumuman->judul }}"
                     class="w-full max-w-2xl h-auto rounded-xl object-contain">
            </div>
        @endif

        <div class="px-6 py-5 border-b border-gray-100 dark:border-white/[0.06]">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white/90 leading-snug">{{ $pengumuman->judul }}</h2>
        </div>

        <div class="px-6 py-5">
            <article class="prose prose-sm max-w-none
                            prose-headings:text-gray-900 dark:prose-headings:text-white/90
                            prose-p:text-gray-700 dark:prose-p:text-white/70
                            prose-strong:text-gray-900 dark:prose-strong:text-white/90
                            prose-li:text-gray-700 dark:prose-li:text-white/70
                            prose-a:text-blue-600 dark:prose-a:text-blue-400">
                {!! $pengumuman->isi !!}
            </article>
        </div>

        <div class="px-6 py-4 bg-gray-50 dark:bg-white/[0.03] border-t border-gray-100 dark:border-white/[0.06]">
            <div class="flex flex-wrap items-center gap-x-5 gap-y-1 text-xs text-gray-400 dark:text-white/30">
                <span class="flex items-center gap-1">
                    <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                    Dibuat {{ $pengumuman->created_at->diffForHumans() }}
                </span>
                @if($pengumuman->updated_at->ne($pengumuman->created_at))
                    <span class="flex items-center gap-1">
                        <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                        Diperbarui {{ $pengumuman->updated_at->diffForHumans() }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- TOMBOL --}}
    <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-3">
        <a href="{{ route('admin.pengumuman.index') }}"
           class="px-5 py-2.5 border-2 border-gray-200 dark:border-white/[0.10] rounded-xl
                  text-gray-600 dark:text-white/50 font-semibold text-sm
                  hover:bg-gray-50 dark:hover:bg-white/[0.07] transition
                  flex items-center justify-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
        <a href="{{ route('admin.pengumuman.edit', $pengumuman) }}"
           class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-xl
                  font-bold text-sm transition flex items-center justify-center gap-2">
            <i data-lucide="edit-3" class="w-4 h-4"></i> Edit pengumuman
        </a>
    </div>
</div>
@endsection