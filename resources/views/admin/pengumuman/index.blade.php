{{-- resources/views/admin/pengumuman/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Pengumuman')

@section('content')
<div class="space-y-6">

    <!-- HEADER CARD — SAMA PERSIS KAYAK JADWAL -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-2xl p-6 shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-indigo-900 flex items-center gap-3">
                    <i data-lucide="megaphone" class="w-9 h-9 sm:w-10 sm:h-10 text-purple-600"></i>
                    Pengumuman
                </h2>
                <p class="text-sm sm:text-base text-indigo-700 mt-1">Kelola semua pengumuman sekolah</p>
            </div>

            <a href="{{ route('admin.pengumuman.create') }}"
               class="inline-flex items-center justify-center gap-3 px-7 py-4 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition">
                <i data-lucide="plus" class="w-6 h-6"></i>
                <span class="hidden sm:inline">Buat Pengumuman</span>
                <span class="sm:hidden">Tambah</span>
            </a>
        </div>

        <!-- Search Bar -->
        <div class="mt-5 sm:mt-0 sm:col-span-2 lg:col-span-1">
            <form action="{{ route('admin.pengumuman.index') }}" method="GET">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 w-5 h-5"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari judul pengumuman..."
                           class="w-full pl-12 pr-5 py-4 bg-white border-2 border-indigo-100 rounded-2xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition text-base">
                </div>
            </form>
        </div>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="bg-emerald-50 border-2 border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl shadow-md flex items-center gap-4">
            <i data-lucide="check-circle-2" class="w-8 h-8 flex-shrink-0"></i>
            <span class="font-medium text-lg">{{ session('success') }}</span>
        </div>
    @endif

    <!-- MAIN CARD CONTAINER -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">

        <!-- DESKTOP: TABEL CANTIK -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                    <tr>
                        <th class="px-8 py-5 text-left font-bold">No</th>
                        <th class="px-8 py-5 text-left font-bold">Judul Pengumuman</th>
                        <th class="px-8 py-5 text-center font-bold">Tanggal</th>
                        <th class="px-8 py-5 text-center font-bold">Status</th>
                        <th class="px-8 py-5 text-center font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengumumans as $i => $p)
                    <tr class="hover:bg-indigo-50 transition">
                        <td class="px-8 py-5 font-medium text-gray-700">{{ $pengumumans->firstItem() + $i }}</td>
                        <td class="px-8 py-5">
                            <p class="font-bold text-gray-900">{{ $p->judul }}</p>
                        </td>
                        <td class="px-8 py-5 text-center text-gray-600">
                            {{ $p->tanggal->format('d/m/Y') }}
                        </td>
                        <td class="px-8 py-5 text-center">
                            @if($p->aktif)
                                <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-100 text-emerald-700 rounded-full font-bold text-sm">
                                    <i data-lucide="circle-dot" class="w-4 h-4 animate-pulse"></i>
                                    Dipublikasikan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-100 text-orange-700 rounded-full font-bold text-sm">
                                    <i data-lucide="clock" class="w-4 h-4"></i>
                                    Draft
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center gap-5">
                                <a href="{{ route('admin.pengumuman.show', $p) }}" class="p-3 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-xl transition">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </a>
                                <a href="{{ route('admin.pengumuman.edit', $p) }}" class="p-3 bg-amber-100 hover:bg-amber-200 text-amber-700 rounded-xl transition">
                                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                                </a>
                                <form action="{{ route('admin.pengumuman.destroy', $p) }}" method="POST" class="inline delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-20 text-gray-500">
                            <i data-lucide="inbox" class="w-16 h-16 mx-auto mb-4 text-gray-300"></i>
                            <p class="text-lg font-medium">Belum ada pengumuman</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE: CARD LIST PREMIUM -->
        <div class="lg:hidden p-5 space-y-5">
            @forelse($pengumumans as $i => $p)
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 shadow-md hover:shadow-xl transition p-6">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-indigo-700 font-bold text-lg">#{{ $pengumumans->firstItem() + $i }}</span>
                    @if($p->aktif)
                        <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-sm font-bold flex items-center gap-2">
                            <i data-lucide="circle-dot" class="w-4 h-4 animate-pulse"></i> Aktif
                        </span>
                    @else
                        <span class="bg-orange-100 text-orange-700 px-4 py-2 rounded-full text-sm font-bold flex items-center gap-2">
                            <i data-lucide="clock" class="w-4 h-4"></i> Draft
                        </span>
                    @endif
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                    {{ $p->judul }}
                </h3>

                <p class="text-indigo-700 font-semibold flex items-center gap-2 mb-5">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                    {{ $p->tanggal->format('d F Y') }}
                </p>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.pengumuman.show', $p) }}" class="p-3.5 bg-blue-100 text-blue-700 rounded-2xl hover:bg-blue-200 transition">
                        <i data-lucide="eye" class="w-6 h-6"></i>
                    </a>
                    <a href="{{ route('admin.pengumuman.edit', $p) }}" class="p-3.5 bg-amber-100 text-amber-700 rounded-2xl hover:bg-amber-200 transition">
                        <i data-lucide="edit-3" class="w-6 h-6"></i>
                    </a>
                    <form action="{{ route('admin.pengumuman.destroy', $p) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Yakin hapus?')" class="p-3.5 bg-red-100 text-red-700 rounded-2xl hover:bg-red-200 transition">
                            <i data-lucide="trash-2" class="w-6 h-6"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-20 text-gray-500">
                <i data-lucide="inbox" class="w-24 h-24 mx-auto mb-6 text-gray-300"></i>
                <p class="text-xl font-medium">Belum ada pengumuman</p>
            </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        <div class="px-6 py-5 bg-gradient-to-r from-indigo-50 to-purple-50 border-t border-gray-200">
            {{ $pengumumans->appends(request()->query())->links() }}
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

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false,
    customClass:{ popup:'rounded-2xl' }
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: "{{ session('error') }}",
    customClass:{ popup:'rounded-2xl' }
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
            customClass:{ popup:'rounded-2xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection