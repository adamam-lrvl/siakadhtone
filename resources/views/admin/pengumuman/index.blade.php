{{-- resources/views/admin/pengumuman/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Pengumuman')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER BIRU --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="megaphone" class="w-6 h-6 flex-shrink-0"></i>
                    <span>Pengumuman</span>
                </h1>
                <p class="text-blue-100 text-sm mt-1">Kelola semua pengumuman sekolah</p>
            </div>
            <a href="{{ route('admin.pengumuman.create') }}"
               class="flex items-center gap-2 px-4 py-2 bg-white/15 hover:bg-white/25
                      text-white text-sm font-semibold rounded-xl transition flex-shrink-0">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span class="hidden sm:inline">Buat pengumuman</span>
                <span class="sm:hidden">Tambah</span>
            </a>
        </div>

        {{-- SEARCH --}}
        <form action="{{ route('admin.pengumuman.index') }}" method="GET" class="mt-4">
            <div class="relative">
                <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari judul pengumuman..."
                       class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl
                              text-sm text-gray-700 focus:outline-none focus:ring-2
                              focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
        </form>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3
                    rounded-xl flex items-center gap-3 text-sm font-medium">
            <i data-lucide="check-circle" class="w-4 h-4 flex-shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- TABEL / CARD --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

        {{-- DESKTOP: TABEL --}}
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                        <th class="px-5 py-3.5 text-center font-semibold w-12">No</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Judul</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-32">Tanggal</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-36">Status</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengumumans as $i => $p)
                    <tr class="hover:bg-indigo-50/30 transition {{ $loop->even ? 'bg-gray-50/50' : '' }}">
                        <td class="px-5 py-4 text-center text-gray-400 text-xs">
                            {{ $pengumumans->firstItem() + $i }}
                        </td>
                        <td class="px-5 py-4 font-semibold text-gray-900">{{ $p->judul }}</td>
                        <td class="px-5 py-4 text-center text-gray-500 text-xs">
                            {{ $p->tanggal->format('d/m/Y') }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($p->aktif)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                             text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <i data-lucide="circle-dot" class="w-3 h-3"></i>
                                    Dipublikasikan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                             text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                    Draft
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.pengumuman.show', $p) }}"
                                   class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.pengumuman.edit', $p) }}"
                                   class="p-2 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg transition">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.pengumuman.destroy', $p) }}"
                                      method="POST" class="inline delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-16 text-gray-400">
                            <div class="bg-gray-50 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                                <i data-lucide="inbox" class="w-7 h-7 text-gray-300"></i>
                            </div>
                            <p class="text-sm font-medium">Belum ada pengumuman</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE: CARD LIST --}}
        <div class="lg:hidden divide-y divide-gray-100">
            @forelse($pengumumans as $i => $p)
            <div class="p-4 hover:bg-gray-50 transition">

                {{-- BARIS ATAS: judul + badge --}}
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900 leading-snug">{{ $p->judul }}</p>
                        <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                            <i data-lucide="calendar" class="w-3 h-3"></i>
                            {{ $p->tanggal->format('d F Y') }}
                        </p>
                    </div>
                    @if($p->aktif)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full
                                     text-xs font-semibold bg-emerald-50 text-emerald-700
                                     border border-emerald-200 flex-shrink-0">
                            <i data-lucide="circle-dot" class="w-3 h-3"></i>
                            Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full
                                     text-xs font-semibold bg-amber-50 text-amber-700
                                     border border-amber-200 flex-shrink-0">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            Draft
                        </span>
                    @endif
                </div>

                {{-- BARIS BAWAH: tombol aksi --}}
                <div class="flex gap-2 justify-end pt-2 border-t border-gray-100">
                    <a href="{{ route('admin.pengumuman.show', $p) }}"
                       class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100
                              text-blue-600 text-xs font-semibold rounded-lg transition">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                        Lihat
                    </a>
                    <a href="{{ route('admin.pengumuman.edit', $p) }}"
                       class="flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 hover:bg-amber-100
                              text-amber-600 text-xs font-semibold rounded-lg transition">
                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                        Edit
                    </a>
                    <form action="{{ route('admin.pengumuman.destroy', $p) }}"
                          method="POST" class="inline delete-form">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100
                                       text-red-600 text-xs font-semibold rounded-lg transition">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-16 text-gray-400">
                <div class="bg-gray-50 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                    <i data-lucide="inbox" class="w-7 h-7 text-gray-300"></i>
                </div>
                <p class="text-sm font-medium">Belum ada pengumuman</p>
            </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if($pengumumans->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $pengumumans->appends(request()->query())->links() }}
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endpush

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false,
    customClass: { popup: 'rounded-2xl' }
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: "{{ session('error') }}",
    customClass: { popup: 'rounded-2xl' }
});
</script>
@endif

<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin hapus?',
            text: 'Data tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl' }
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endsection