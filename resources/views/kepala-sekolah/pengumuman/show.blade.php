{{-- resources/views/kepala-sekolah/pengumuman/show.blade.php --}}
@extends('kepala-sekolah.layouts.app')
@section('title', 'Detail Pengumuman')

@section('content')
<div class="max-w-4xl mx-auto py-6 space-y-5">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:border dark:border-white/[0.09]
                dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="absolute -right-10 -top-10 w-52 h-52 bg-white/[0.04] rounded-full pointer-events-none"></div>

        <div class="relative p-7">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 bg-white/15 border border-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i data-lucide="megaphone" class="w-5 h-5 text-white"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-blue-300 dark:text-white/35 uppercase tracking-widest mb-1">Pengumuman</p>
                        <h1 class="text-2xl font-extrabold text-white dark:text-white/90 leading-tight tracking-tight">Detail pengumuman</h1>
                        <div class="flex items-center gap-2 mt-2 text-sm text-blue-200 dark:text-white/40">
                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                            {{ $pengumuman->tanggal->translatedFormat('d F Y') }}
                        </div>
                    </div>
                </div>

                @php
                    $badge = match($pengumuman->status) {
                        'approved' => ['Disetujui', 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-300 border-emerald-300 dark:border-emerald-500/35'],
                        'rejected' => ['Ditolak',   'bg-red-100 dark:bg-red-500/20 text-red-800 dark:text-red-300 border-red-300 dark:border-red-500/35'],
                        default    => ['Menunggu',  'bg-amber-100 dark:bg-amber-500/20 text-amber-800 dark:text-amber-300 border-amber-300 dark:border-amber-500/35'],
                    };
                @endphp
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold border-2 {{ $badge[1] }} flex-shrink-0">
                    {{ $badge[0] }}
                </span>
            </div>

            <div class="h-px bg-white/10 dark:bg-white/[0.08] mb-5"></div>
            <p class="text-base font-bold text-white dark:text-white/85 leading-relaxed relative z-10">{{ $pengumuman->judul }}</p>
        </div>
    </div>

    {{-- KONTEN --}}
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">

        @if($pengumuman->gambar)
            <div class="bg-gray-50 dark:bg-white/[0.03] border-b border-gray-100 dark:border-white/[0.06] flex items-center justify-center px-6 py-5">
                <img src="{{ Storage::url($pengumuman->gambar) }}" alt="{{ $pengumuman->judul }}"
                     class="w-full max-w-2xl h-auto rounded-xl object-contain">
            </div>
        @endif

        <div class="px-6 py-6">
            <p class="text-xs font-bold text-gray-400 dark:text-white/30 uppercase tracking-widest mb-4 flex items-center gap-2">
                <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                Isi pengumuman
            </p>
            <article class="prose prose-sm max-w-none
                            prose-headings:text-gray-900 dark:prose-headings:text-white/90
                            prose-p:text-gray-700 dark:prose-p:text-white/70
                            prose-strong:text-gray-900 dark:prose-strong:text-white/90
                            prose-a:text-blue-600 dark:prose-a:text-blue-400">
                {!! $pengumuman->isi !!}
            </article>
        </div>

        <div class="px-6 py-4 bg-gray-50 dark:bg-white/[0.03] border-t border-gray-100 dark:border-white/[0.06]">
            <div class="flex flex-wrap items-center gap-x-5 gap-y-1 text-xs text-gray-400 dark:text-white/30">
                <span class="flex items-center gap-1.5">
                    <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                    Dibuat {{ $pengumuman->created_at->diffForHumans() }}
                </span>
                @if($pengumuman->approved_at)
                    <span class="flex items-center gap-1.5 {{ $pengumuman->status === 'approved' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                        {{ $pengumuman->status === 'approved' ? 'Disetujui' : 'Ditolak' }}
                        {{ $pengumuman->approved_at->diffForHumans() }}
                        oleh {{ $pengumuman->approvedBy->name ?? '-' }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- TOMBOL --}}
    <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-3">
        <a href="{{ route('kepsek.pengumuman.index') }}"
           class="px-5 py-2.5 border-2 border-gray-200 dark:border-white/[0.10] rounded-xl
                  text-gray-600 dark:text-white/50 font-semibold text-sm
                  hover:bg-gray-50 dark:hover:bg-white/[0.07] transition
                  flex items-center justify-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>

        @if($pengumuman->status === 'pending')
        <div class="flex gap-3">
            <form action="{{ route('kepsek.pengumuman.reject', $pengumuman) }}" method="POST" class="reject-form">
                @csrf @method('PATCH')
                <button type="submit"
                        class="px-5 py-2.5 bg-white dark:bg-red-500/10 border-2 border-red-300 dark:border-red-500/30
                               text-red-600 dark:text-red-400 font-bold text-sm rounded-xl
                               hover:bg-red-50 dark:hover:bg-red-500/20 transition flex items-center gap-2">
                    <i data-lucide="x-circle" class="w-4 h-4"></i> Tolak
                </button>
            </form>
            <form action="{{ route('kepsek.pengumuman.approve', $pengumuman) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit"
                        class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold text-sm rounded-xl transition flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i> Setujui & publikasikan
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
            title: 'Tolak pengumuman?', text: 'Pengumuman tidak akan dipublikasikan ke siswa.', icon: 'warning',
            showCancelButton: true, confirmButtonText: 'Ya, tolak', cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl' }
        }).then(r => { if (r.isConfirmed) form.submit(); });
    });
});
</script>
@endsection