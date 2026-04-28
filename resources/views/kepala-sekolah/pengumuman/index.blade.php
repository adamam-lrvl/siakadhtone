{{-- resources/views/kepala-sekolah/pengumuman/index.blade.php --}}
@extends('kepala-sekolah.layouts.app')
@section('title', 'Approval Pengumuman')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="megaphone" class="w-6 h-6 flex-shrink-0"></i>
                    <span>Approval pengumuman</span>
                </h1>
                <p class="text-blue-100 text-sm mt-1">
                    Review dan setujui pengumuman dari admin
                </p>
            </div>
            <div class="flex gap-2 flex-shrink-0">
                <div class="bg-white/15 rounded-xl px-4 py-2 text-center">
                    <p class="text-xl font-bold">{{ $pending->count() }}</p>
                    <p class="text-xs text-blue-100">Menunggu</p>
                </div>
            </div>
        </div>
    </div>

    {{-- TAB NAVIGATION --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div class="flex border-b border-gray-100" id="tabs">
            <button onclick="showTab('pending')"
                    id="tab-pending"
                    class="flex-1 px-4 py-3.5 text-sm font-semibold transition flex items-center justify-center gap-2
                           border-b-2 border-blue-600 text-blue-700">
                <i data-lucide="clock" class="w-4 h-4"></i>
                Menunggu
                @if($pending->count() > 0)
                    <span class="bg-amber-500 text-white text-xs px-2 py-0.5 rounded-full">
                        {{ $pending->count() }}
                    </span>
                @endif
            </button>
            <button onclick="showTab('approved')"
                    id="tab-approved"
                    class="flex-1 px-4 py-3.5 text-sm font-semibold transition flex items-center justify-center gap-2
                           border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                Disetujui
                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">
                    {{ $approved->count() }}
                </span>
            </button>
            <button onclick="showTab('rejected')"
                    id="tab-rejected"
                    class="flex-1 px-4 py-3.5 text-sm font-semibold transition flex items-center justify-center gap-2
                           border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                <i data-lucide="x-circle" class="w-4 h-4"></i>
                Ditolak
                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">
                    {{ $rejected->count() }}
                </span>
            </button>
        </div>

        {{-- TAB PENDING --}}
        <div id="content-pending">
            @forelse($pending as $p)
            <div class="p-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-gray-900 text-sm">{{ $p->judul }}</p>
                        <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                            <i data-lucide="calendar" class="w-3 h-3"></i>
                            {{ $p->tanggal->translatedFormat('d F Y') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-2 line-clamp-2">
                            {!! Str::limit(strip_tags($p->isi), 120) !!}
                        </p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs
                                 font-semibold bg-amber-50 text-amber-700 border border-amber-200 flex-shrink-0">
                        <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                        Menunggu
                    </span>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="flex gap-2 mt-4 pt-3 border-t border-gray-100">
                    <a href="{{ route('kepsek.pengumuman.show', $p) }}"
                       class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold
                              rounded-lg border border-gray-200 text-gray-600
                              hover:bg-gray-50 transition">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                        Lihat detail
                    </a>
                    <form action="{{ route('kepsek.pengumuman.approve', $p) }}" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold
                                       rounded-lg bg-emerald-50 border border-emerald-200
                                       text-emerald-700 hover:bg-emerald-100 transition">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                            Setujui
                        </button>
                    </form>
                    <form action="{{ route('kepsek.pengumuman.reject', $p) }}" method="POST" class="inline reject-form">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold
                                       rounded-lg bg-red-50 border border-red-200
                                       text-red-700 hover:bg-red-100 transition">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            Tolak
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-16 text-gray-400">
                <div class="bg-gray-50 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                    <i data-lucide="check-circle" class="w-7 h-7 text-gray-300"></i>
                </div>
                <p class="text-sm font-medium">Tidak ada pengumuman yang menunggu</p>
            </div>
            @endforelse
        </div>

        {{-- TAB APPROVED --}}
        <div id="content-approved" class="hidden">
            @forelse($approved as $p)
            <div class="p-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-gray-900 text-sm">{{ $p->judul }}</p>
                        <p class="text-xs text-gray-400 mt-1 flex items-center gap-2 flex-wrap">
                            <span class="flex items-center gap-1">
                                <i data-lucide="calendar" class="w-3 h-3"></i>
                                {{ $p->tanggal->translatedFormat('d F Y') }}
                            </span>
                            @if($p->approved_at)
                                <span class="flex items-center gap-1">
                                    <i data-lucide="check-circle" class="w-3 h-3 text-emerald-500"></i>
                                    Disetujui {{ $p->approved_at->diffForHumans() }}
                                </span>
                            @endif
                        </p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs
                                 font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 flex-shrink-0">
                        <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>
                        Disetujui
                    </span>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <a href="{{ route('kepsek.pengumuman.show', $p) }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold
                              rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 transition">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                        Lihat detail
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-16 text-gray-400">
                <p class="text-sm font-medium">Belum ada pengumuman yang disetujui</p>
            </div>
            @endforelse
        </div>

        {{-- TAB REJECTED --}}
        <div id="content-rejected" class="hidden">
            @forelse($rejected as $p)
            <div class="p-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-gray-900 text-sm">{{ $p->judul }}</p>
                        <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                            <i data-lucide="calendar" class="w-3 h-3"></i>
                            {{ $p->tanggal->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs
                                 font-semibold bg-red-50 text-red-700 border border-red-200 flex-shrink-0">
                        <i data-lucide="x-circle" class="w-3 h-3 mr-1"></i>
                        Ditolak
                    </span>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-100 flex gap-2">
                    <a href="{{ route('kepsek.pengumuman.show', $p) }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold
                              rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 transition">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                        Lihat detail
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-16 text-gray-400">
                <p class="text-sm font-medium">Belum ada pengumuman yang ditolak</p>
            </div>
            @endforelse
        </div>

    </div>
</div>

<script>
function showTab(tab) {
    ['pending', 'approved', 'rejected'].forEach(t => {
        document.getElementById('content-' + t).classList.add('hidden');
        document.getElementById('tab-' + t).classList.remove('border-blue-600', 'text-blue-700');
        document.getElementById('tab-' + t).classList.add('border-transparent', 'text-gray-500');
    });
    document.getElementById('content-' + tab).classList.remove('hidden');
    document.getElementById('tab-' + tab).classList.add('border-blue-600', 'text-blue-700');
    document.getElementById('tab-' + tab).classList.remove('border-transparent', 'text-gray-500');
}

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