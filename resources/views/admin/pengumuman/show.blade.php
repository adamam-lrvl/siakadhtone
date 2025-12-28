{{-- resources/views/admin/pengumuman/show.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Pengumuman - ' . $pengumuman->judul)

@section('content')
<div class="space-y-6">

    <!-- HEADER CARD — SAMA PERSIS KAYAK INDEX & JADWAL -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-2xl p-6 shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-indigo-900 flex items-center gap-3">
                    <i data-lucide="megaphone" class="w-9 h-9 sm:w-10 sm:h-10 text-purple-600"></i>
                    Detail Pengumuman
                </h2>
                <p class="text-sm sm:text-base text-indigo-700 mt-1">Lihat isi lengkap pengumuman</p>
            </div>
        </div>
    </div>

    <!-- MAIN DETAIL CARD -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">

        <!-- HEADER CARD DENGAN GRADIENT + INFO -->
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-7 text-white">
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-black leading-tight mb-5">
                {{ $pengumuman->judul }}
            </h1>

            <div class="flex flex-wrap items-center gap-5 text-sm lg:text-base opacity-95">
                <div class="flex items-center gap-2">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                    <span class="font-medium">{{ $pengumuman->tanggal->translatedFormat('d F Y') }}</span>
                </div>

                <div class="flex items-center gap-2">
                    <i data-lucide="{{ $pengumuman->aktif ? 'eye' : 'eye-off' }}" class="w-5 h-5"></i>
                    <span class="font-bold text-lg">
                        {{ $pengumuman->aktif ? 'DIPUBLIKASIKAN' : 'DRAFT' }}
                    </span>
                    @if($pengumuman->aktif)
                        <i data-lucide="circle-dot" class="w-4 h-4 animate-pulse text-emerald-300"></i>
                    @endif
                </div>
            </div>
        </div>

        <!-- ISI PENGUMUMAN -->
        <div class="p-6 lg:p-10">
            <article class="prose prose-lg max-w-none 
                            prose-headings:font-bold prose-headings:text-indigo-900 prose-headings:mt-8
                            prose-p:text-gray-700 prose-p:leading-relaxed
                            prose-a:text-indigo-600 hover:prose-a:text-indigo-800 font-medium
                            prose-strong:text-indigo-800 font-bold
                            prose-ul:list-disc prose-ol:list-decimal prose-li:text-gray-700 prose-li:my-2
                            prose-img:rounded-2xl prose-img:shadow-2xl prose-img:border-8 prose-img:border-white prose-img:my-10
                            prose-blockquote:border-l-8 prose-blockquote:border-indigo-500 
                            prose-blockquote:bg-indigo-50 prose-blockquote:p-8 prose-blockquote:rounded-r-2xl 
                            prose-blockquote:text-indigo-900 prose-blockquote:font-medium">
                {!! $pengumuman->isi !!}
            </article>

            <!-- FOOTER INFO -->
            <div class="border-t-2 border-dashed border-indigo-100 mt-12 pt-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-600">
                    <div class="flex items-center gap-3">
                        <i data-lucide="clock" class="w-5 h-5 text-indigo-600"></i>
                        <span>Dibuat <strong>{{ $pengumuman->created_at->diffForHumans() }}</strong></span>
                    </div>
                    @if($pengumuman->updated_at->ne($pengumuman->created_at))
                    <div class="flex items-center gap-3">
                        <i data-lucide="refresh-cw" class="w-5 h-5 text-purple-600"></i>
                        <span>Diperbarui <strong>{{ $pengumuman->updated_at->diffForHumans() }}</strong></span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- TOMBOL AKSI -->
            <div class="flex flex-col sm:flex-row gap-5 mt-10">
                <a href="{{ route('admin.pengumuman.edit', $pengumuman) }}"
                   class="inline-flex items-center justify-center gap-3 px-8 py-5 bg-gradient-to-r from-indigo-600 to-purple-700 
                          hover:from-indigo-700 hover:to-purple-800 text-white font-bold text-lg rounded-2xl shadow-xl 
                          hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                    <i data-lucide="edit-3" class="w-6 h-6"></i>
                    Edit Pengumuman
                </a>

                <a href="{{ route('admin.pengumuman.index') }}"
                   class="inline-flex items-center justify-center gap-3 px-8 py-5 bg-white border-2 border-gray-300 
                          hover:border-indigo-400 text-gray-700 hover:text-indigo-700 font-bold text-lg rounded-2xl 
                          shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition">
                    <i data-lucide="arrow-left" class="w-6 h-6"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
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