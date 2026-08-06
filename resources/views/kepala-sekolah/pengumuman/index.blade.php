{{-- resources/views/kepala-sekolah/pengumuman/index.blade.php --}}
@extends('kepala-sekolah.layouts.app')
@section('title', 'Approval Pengumuman')

@section('content')
<div class="max-w-5xl mx-auto py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:border dark:border-white/[0.09]
                dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="relative p-6 flex flex-wrap sm:flex-nowrap items-start justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <div class="bg-white/15 backdrop-blur-sm border border-white/20 rounded-xl p-2.5 flex-shrink-0">
                    <i data-lucide="megaphone" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-white tracking-tight">Approval pengumuman</h1>
                    <p class="text-blue-200 dark:text-white/40 text-sm mt-0.5">Review dan setujui pengumuman dari admin</p>
                </div>
            </div>
            <div class="bg-white/15 dark:bg-white/[0.07] border border-white/20 dark:border-white/[0.09]
                        backdrop-blur-sm rounded-xl px-4 py-2 text-center flex-shrink-0 w-full sm:w-auto">
                <p class="text-xl font-bold text-white dark:text-white/90">{{ $pending->count() }}</p>
                <p class="text-xs text-blue-100 dark:text-white/40">Menunggu</p>
            </div>
        </div>
    </div>

    {{-- TAB + KONTEN --}}
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">

        {{-- TAB BUTTONS --}}
        <div class="flex border-b border-gray-100 dark:border-white/[0.06] overflow-x-auto no-scrollbar" id="tabs">
            <button onclick="showTab('pending')" id="tab-pending"
                    class="flex-none px-5 py-3.5 text-sm font-semibold transition flex items-center justify-center gap-2
                           border-b-2 border-blue-600 text-blue-700 dark:text-white whitespace-nowrap">
                <i data-lucide="clock" class="w-4 h-4"></i>
                Menunggu
                @if($pending->count() > 0)
                    <span class="bg-amber-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $pending->count() }}</span>
                @endif
            </button>
            <button onclick="showTab('approved')" id="tab-approved"
                    class="flex-none px-5 py-3.5 text-sm font-semibold transition flex items-center justify-center gap-2
                           border-b-2 border-transparent text-gray-500 dark:text-white/40 hover:text-gray-700 dark:hover:text-white/70 whitespace-nowrap">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                Disetujui
                <span class="bg-gray-100 dark:bg-white/[0.08] text-gray-600 dark:text-white/50 text-xs px-2 py-0.5 rounded-full">{{ $approved->count() }}</span>
            </button>
            <button onclick="showTab('rejected')" id="tab-rejected"
                    class="flex-none px-5 py-3.5 text-sm font-semibold transition flex items-center justify-center gap-2
                           border-b-2 border-transparent text-gray-500 dark:text-white/40 hover:text-gray-700 dark:hover:text-white/70 whitespace-nowrap">
                <i data-lucide="x-circle" class="w-4 h-4"></i>
                Ditolak
                <span class="bg-gray-100 dark:bg-white/[0.08] text-gray-600 dark:text-white/50 text-xs px-2 py-0.5 rounded-full">{{ $rejected->count() }}</span>
            </button>
        </div>

        {{-- TAB PENDING --}}
        <div id="content-pending">
            @forelse($pending as $p)
            <div class="p-4 border-b border-gray-100 dark:border-white/[0.05] last:border-0 hover:bg-gray-50 dark:hover:bg-white/[0.04] transition">
                <div class="flex items-start gap-4">
                    @if($p->gambar)
                        <div class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden bg-gray-100 dark:bg-white/[0.06]">
                            <img src="{{ Storage::url($p->gambar) }}" alt="{{ $p->judul }}" class="w-full h-full object-contain bg-gray-50 dark:bg-transparent">
                        </div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900 dark:text-white/90 text-sm">{{ $p->judul }}</p>
                                <p class="text-xs text-gray-400 dark:text-white/30 mt-1 flex items-center gap-1">
                                    <i data-lucide="calendar" class="w-3 h-3"></i>
                                    {{ $p->tanggal->translatedFormat('d F Y') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-white/40 mt-2 line-clamp-2">
                                    {!! Str::limit(strip_tags($p->isi), 120) !!}
                                </p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold flex-shrink-0
                                         bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-300
                                         border border-amber-200 dark:border-amber-500/25">
                                <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                Menunggu
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-3 pt-3 border-t border-gray-100 dark:border-white/[0.05]">
                            <a href="{{ route('kepsek.pengumuman.show', $p) }}"
                               class="flex-1 sm:flex-none flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg
                                      border border-gray-200 dark:border-white/[0.10] text-gray-600 dark:text-white/50
                                      hover:bg-gray-50 dark:hover:bg-white/[0.07] transition">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i> Lihat detail
                            </a>
                            <form action="{{ route('kepsek.pengumuman.approve', $p) }}" method="POST" class="inline approve-form flex-1 sm:flex-none">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="w-full flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg
                                               bg-emerald-50 dark:bg-emerald-500/15 border border-emerald-200 dark:border-emerald-500/25
                                               text-emerald-700 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-500/25 transition">
                                    <i data-lucide="check" class="w-3.5 h-3.5"></i> Setujui
                                </button>
                            </form>
                            <form action="{{ route('kepsek.pengumuman.reject', $p) }}" method="POST" class="inline reject-form flex-1 sm:flex-none">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="w-full flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg
                                               bg-red-50 dark:bg-red-500/15 border border-red-200 dark:border-red-500/25
                                               text-red-700 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-500/25 transition">
                                    <i data-lucide="x" class="w-3.5 h-3.5"></i> Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-16">
                <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                    <i data-lucide="check-circle" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
                </div>
                <p class="text-sm font-medium text-gray-400 dark:text-white/30">Tidak ada pengumuman yang menunggu</p>
            </div>
            @endforelse
        </div>

        {{-- TAB APPROVED --}}
        <div id="content-approved" class="hidden">
            @forelse($approved as $p)
            <div class="p-4 border-b border-gray-100 dark:border-white/[0.05] last:border-0 hover:bg-gray-50 dark:hover:bg-white/[0.04] transition">
                <div class="flex items-start gap-4">
                    @if($p->gambar)
                        <div class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden bg-gray-100 dark:bg-white/[0.06]">
                            <img src="{{ Storage::url($p->gambar) }}" alt="{{ $p->judul }}" class="w-full h-full object-contain">
                        </div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900 dark:text-white/90 text-sm">{{ $p->judul }}</p>
                                <p class="text-xs text-gray-400 dark:text-white/30 mt-1 flex items-center gap-2 flex-wrap">
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="calendar" class="w-3 h-3"></i>
                                        {{ $p->tanggal->translatedFormat('d F Y') }}
                                    </span>
                                    @if($p->approved_at)
                                        <span class="flex items-center gap-1 text-emerald-600 dark:text-emerald-400">
                                            <i data-lucide="check-circle" class="w-3 h-3"></i>
                                            Disetujui {{ $p->approved_at->diffForHumans() }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold flex-shrink-0
                                         bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-400
                                         border border-emerald-200 dark:border-emerald-500/25">
                                <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i> Disetujui
                            </span>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-100 dark:border-white/[0.05]">
                            <a href="{{ route('kepsek.pengumuman.show', $p) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg
                                      border border-gray-200 dark:border-white/[0.10] text-gray-600 dark:text-white/50
                                      hover:bg-gray-50 dark:hover:bg-white/[0.07] transition">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i> Lihat detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-16">
                <p class="text-sm font-medium text-gray-400 dark:text-white/30">Belum ada pengumuman yang disetujui</p>
            </div>
            @endforelse
        </div>

        {{-- TAB REJECTED --}}
        <div id="content-rejected" class="hidden">
            @forelse($rejected as $p)
            <div class="p-4 border-b border-gray-100 dark:border-white/[0.05] last:border-0 hover:bg-gray-50 dark:hover:bg-white/[0.04] transition">
                <div class="flex items-start gap-4">
                    @if($p->gambar)
                        <div class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden bg-gray-100 dark:bg-white/[0.06]">
                            <img src="{{ Storage::url($p->gambar) }}" alt="{{ $p->judul }}" class="w-full h-full object-contain">
                        </div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900 dark:text-white/90 text-sm">{{ $p->judul }}</p>
                                <p class="text-xs text-gray-400 dark:text-white/30 mt-1 flex items-center gap-1">
                                    <i data-lucide="calendar" class="w-3 h-3"></i>
                                    {{ $p->tanggal->translatedFormat('d F Y') }}
                                </p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold flex-shrink-0
                                         bg-red-50 dark:bg-red-500/15 text-red-700 dark:text-red-400
                                         border border-red-200 dark:border-red-500/25">
                                <i data-lucide="x-circle" class="w-3 h-3 mr-1"></i> Ditolak
                            </span>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-100 dark:border-white/[0.05]">
                            <a href="{{ route('kepsek.pengumuman.show', $p) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg
                                      border border-gray-200 dark:border-white/[0.10] text-gray-600 dark:text-white/50
                                      hover:bg-gray-50 dark:hover:bg-white/[0.07] transition">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i> Lihat detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-16">
                <p class="text-sm font-medium text-gray-400 dark:text-white/30">Belum ada pengumuman yang ditolak</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function showTab(tab) {
    ['pending','approved','rejected'].forEach(t => {
        document.getElementById('content-'+t).classList.add('hidden');
        var btn = document.getElementById('tab-'+t);
        btn.classList.remove('border-blue-600','text-blue-700','dark:text-white');
        btn.classList.add('border-transparent','text-gray-500','dark:text-white/40');
    });
    document.getElementById('content-'+tab).classList.remove('hidden');
    var active = document.getElementById('tab-'+tab);
    active.classList.add('border-blue-600','dark:text-white');
    active.classList.remove('border-transparent','text-gray-500','dark:text-white/40');
}

document.querySelectorAll('.reject-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Tolak pengumuman ini?', text: 'Pengumuman tidak akan ditampilkan ke siswa.',
            iconHtml: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#dc2626" width="52" height="52"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/></svg>',
            showCancelButton: true, confirmButtonText: 'Ya, tolak', cancelButtonText: 'Batal', reverseButtons: true,
            customClass: { popup: 'rounded-2xl shadow-xl border border-red-100', title: 'text-gray-900 font-bold text-lg', htmlContainer: 'text-gray-500 text-sm', confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-semibold text-sm px-5 py-2.5 rounded-xl', cancelButton: 'bg-white border border-gray-200 text-gray-700 font-semibold text-sm px-5 py-2.5 rounded-xl', icon: 'border-0 bg-red-50 rounded-2xl' },
            buttonsStyling: false,
        }).then(r => { if (r.isConfirmed) form.submit(); });
    });
});

document.querySelectorAll('.approve-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Setujui pengumuman ini?', text: 'Pengumuman akan langsung dipublikasikan ke siswa.',
            iconHtml: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#1d4ed8" width="52" height="52"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>',
            showCancelButton: true, confirmButtonText: 'Ya, setujui', cancelButtonText: 'Batal', reverseButtons: true,
            customClass: { popup: 'rounded-2xl shadow-xl border border-blue-100', title: 'text-gray-900 font-bold text-lg', htmlContainer: 'text-gray-500 text-sm', confirmButton: 'bg-blue-700 hover:bg-blue-800 text-white font-semibold text-sm px-5 py-2.5 rounded-xl', cancelButton: 'bg-white border border-gray-200 text-gray-700 font-semibold text-sm px-5 py-2.5 rounded-xl', icon: 'border-0 bg-blue-50 rounded-2xl' },
            buttonsStyling: false,
        }).then(r => { if (r.isConfirmed) form.submit(); });
    });
});
</script>
@endsection