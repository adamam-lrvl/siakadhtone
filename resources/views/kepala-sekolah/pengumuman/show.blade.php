{{-- resources/views/kepala-sekolah/pengumuman/show.blade.php --}}
@extends('kepala-sekolah.layouts.app')
@section('title', 'Detail Pengumuman')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
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
                </div>
            </div>
            @php
                $badge = match($pengumuman->status) {
                    'approved' => ['Disetujui', 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                    'rejected' => ['Ditolak',   'bg-red-50 text-red-700 border-red-200'],
                    default    => ['Menunggu',  'bg-amber-50 text-amber-700 border-amber-200'],
                };
            @endphp
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs
                         font-semibold border {{ $badge[1] }} flex-shrink-0">
                {{ $badge[0] }}
            </span>
        </div>
    </div>

    {{-- KONTEN --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900">{{ $pengumuman->judul }}</h2>
        </div>
        <div class="px-6 py-5">
            <article class="prose prose-sm max-w-none
                            prose-headings:font-bold prose-headings:text-gray-900
                            prose-p:text-gray-700 prose-p:leading-relaxed
                            prose-a:text-blue-600 prose-strong:text-gray-900
                            prose-blockquote:border-l-4 prose-blockquote:border-blue-500
                            prose-blockquote:bg-blue-50 prose-blockquote:px-5 prose-blockquote:py-3
                            prose-blockquote:rounded-r-xl prose-blockquote:not-italic">
                {!! $pengumuman->isi !!}
            </article>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            <div class="flex flex-wrap items-center gap-x-5 gap-y-1 text-xs text-gray-400">
                <span class="flex items-center gap-1">
                    <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                    Dibuat {{ $pengumuman->created_at->diffForHumans() }}
                </span>
                @if($pengumuman->approved_at)
                    <span class="flex items-center gap-1">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                        {{ $pengumuman->status === 'approved' ? 'Disetujui' : 'Ditolak' }}
                        {{ $pengumuman->approved_at->diffForHumans() }}
                        oleh {{ $pengumuman->approvedBy->name ?? '-' }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- TOMBOL AKSI --}}
    <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-3">
        <a href="{{ route('kepsek.pengumuman.index') }}"
           class="px-5 py-2.5 border border-gray-200 rounded-xl text-gray-700 font-semibold
                  text-sm hover:bg-gray-50 transition flex items-center justify-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>

        @if($pengumuman->status === 'pending')
        <div class="flex gap-3">
            <form action="{{ route('kepsek.pengumuman.reject', $pengumuman) }}"
                  method="POST" class="reject-form">
                @csrf @method('PATCH')
                <button type="submit"
                        class="px-5 py-2.5 bg-red-50 border border-red-200 text-red-700
                               font-semibold text-sm rounded-xl hover:bg-red-100 transition
                               flex items-center gap-2">
                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                    Tolak
                </button>
            </form>
            <form action="{{ route('kepsek.pengumuman.approve', $pengumuman) }}"
                  method="POST">
                @csrf @method('PATCH')
                <button type="submit"
                        class="px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600
                               hover:from-emerald-600 hover:to-teal-700 text-white rounded-xl
                               font-semibold text-sm shadow-sm hover:shadow-md transition
                               flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    Setujui & publikasikan
                </button>
            </form>
        </div>
        @endif
    </div>

</div>

<script>
document.querySelectorAll('.reject-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Tolak pengumuman?',
            text: 'Pengumuman tidak akan dipublikasikan ke siswa.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, tolak',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl' }
        }).then(result => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endsection