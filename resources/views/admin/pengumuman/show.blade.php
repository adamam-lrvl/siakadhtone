{{-- resources/views/admin/pengumuman/show.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Pengumuman - ' . $pengumuman->judul)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER BIRU --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="megaphone" class="w-6 h-6 flex-shrink-0"></i>
                    <span>Detail pengumuman</span>
                </h1>
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2 text-sm text-blue-100">
                    <span class="flex items-center gap-1">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        {{ $pengumuman->tanggal->translatedFormat('d F Y') }}
                    </span>
                    <span class="text-blue-300">•</span>
                    @if($pengumuman->aktif)
                        <span class="flex items-center gap-1">
                            <i data-lucide="circle-dot" class="w-3.5 h-3.5 text-emerald-300"></i>
                            Dipublikasikan
                        </span>
                    @else
                        <span class="flex items-center gap-1">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-300"></i>
                            Draft
                        </span>
                    @endif
                </div>
            </div>

            {{-- BADGE STATUS --}}
            @if($pengumuman->aktif)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs
                             font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 flex-shrink-0">
                    <i data-lucide="check-circle" class="w-3 h-3"></i>
                    Aktif
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs
                             font-semibold bg-amber-50 text-amber-700 border border-amber-200 flex-shrink-0">
                    <i data-lucide="clock" class="w-3 h-3"></i>
                    Draft
                </span>
            @endif
        </div>
    </div>

    {{-- KONTEN UTAMA --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

        {{-- JUDUL --}}
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900 leading-snug">
                {{ $pengumuman->judul }}
            </h2>
        </div>

        {{-- ISI --}}
        <div class="px-6 py-5">
            <article class="prose prose-sm max-w-none
                            prose-headings:font-bold prose-headings:text-gray-900
                            prose-p:text-gray-700 prose-p:leading-relaxed
                            prose-a:text-blue-600 hover:prose-a:text-blue-800
                            prose-strong:text-gray-900
                            prose-ul:list-disc prose-ol:list-decimal
                            prose-li:text-gray-700
                            prose-img:rounded-xl prose-img:my-6
                            prose-blockquote:border-l-4 prose-blockquote:border-blue-500
                            prose-blockquote:bg-blue-50 prose-blockquote:px-5 prose-blockquote:py-3
                            prose-blockquote:rounded-r-xl prose-blockquote:text-blue-900
                            prose-blockquote:not-italic">
                {!! $pengumuman->isi !!}
            </article>
        </div>

        {{-- FOOTER INFO --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            <div class="flex flex-wrap items-center gap-x-5 gap-y-1 text-xs text-gray-400">
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
           class="px-5 py-2.5 border border-gray-200 rounded-xl text-gray-700 font-semibold
                  text-sm hover:bg-gray-50 hover:border-gray-300 transition
                  flex items-center justify-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
        <a href="{{ route('admin.pengumuman.edit', $pengumuman) }}"
           class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600
                  hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl
                  font-semibold text-sm shadow-sm hover:shadow-md transition
                  flex items-center justify-center gap-2">
            <i data-lucide="edit-3" class="w-4 h-4"></i>
            Edit pengumuman
        </a>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endpush
@endsection