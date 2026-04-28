{{-- resources/views/admin/mapel/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Data Mata Pelajaran')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER BIRU --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="book-open" class="w-6 h-6 flex-shrink-0"></i>
                    <span>Data mata pelajaran</span>
                </h1>
                <p class="text-blue-100 text-sm mt-1">Kelola mata pelajaran dan KKM</p>
            </div>
            <a href="{{ route('admin.mapel.create') }}"
               class="flex items-center gap-2 px-4 py-2 bg-white/15 hover:bg-white/25
                      text-white text-sm font-semibold rounded-xl transition flex-shrink-0">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span class="hidden sm:inline">Tambah mapel</span>
                <span class="sm:hidden">Tambah</span>
            </a>
        </div>

        {{-- SEARCH --}}
        <form action="{{ route('admin.mapel.index') }}" method="GET" class="mt-4 flex gap-2">
            <div class="flex-1 relative">
                <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari kode atau nama mata pelajaran..."
                       class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl
                              text-sm text-gray-700 focus:outline-none focus:ring-2
                              focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
            <button type="submit"
                    class="px-4 py-2.5 bg-white/15 hover:bg-white/25 text-white
                           text-sm font-semibold rounded-xl transition flex-shrink-0">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.mapel.index') }}"
                   class="px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white
                          text-sm font-semibold rounded-xl transition flex-shrink-0">
                    Reset
                </a>
            @endif
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

    {{-- KONTEN --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

        {{-- DESKTOP: TABEL --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                        <th class="px-5 py-3.5 text-left font-semibold w-28">Kode</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Nama mapel</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-20">KKM</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-32">Kategori</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($mapel as $m)
                        <tr class="hover:bg-indigo-50/30 transition {{ $loop->even ? 'bg-gray-50/50' : '' }}">
                            <td class="px-5 py-4">
                                <code class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-xs">
                                    {{ $m->kode }}
                                </code>
                            </td>
                            <td class="px-5 py-4 font-semibold text-gray-900">{{ $m->nama_mapel }}</td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs
                                             font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                    {{ $m->kkm }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                    {{ $m->kategori == 'wajib'
                                        ? 'bg-blue-50 text-blue-700 border border-blue-200'
                                        : 'bg-purple-50 text-purple-700 border border-purple-200' }}">
                                    {{ $m->kategori == 'wajib' ? 'Muatan wajib' : 'Peminatan' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.mapel.edit', $m) }}"
                                       class="p-1.5 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg transition">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.mapel.destroy', $m) }}"
                                          method="POST" class="inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="p-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition">
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
                                    <i data-lucide="book-open" class="w-7 h-7 text-gray-300"></i>
                                </div>
                                <p class="text-sm font-medium">
                                    {{ request('search') ? 'Tidak ada hasil untuk "' . request('search') . '"' : 'Belum ada data mata pelajaran' }}
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE: CARD LIST --}}
        <div class="sm:hidden divide-y divide-gray-100">
            @forelse($mapel as $m)
            <div class="p-4 hover:bg-gray-50 transition">

                {{-- BARIS ATAS: nama + aksi --}}
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900">{{ $m->nama_mapel }}</p>
                        <div class="flex items-center gap-2 mt-1 flex-wrap">
                            <code class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">
                                {{ $m->kode }}
                            </code>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                         bg-indigo-50 text-indigo-700 border border-indigo-200">
                                KKM {{ $m->kkm }}
                            </span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                {{ $m->kategori == 'wajib'
                                    ? 'bg-blue-50 text-blue-700 border border-blue-200'
                                    : 'bg-purple-50 text-purple-700 border border-purple-200' }}">
                                {{ $m->kategori == 'wajib' ? 'Wajib' : 'Peminatan' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex gap-2 flex-shrink-0">
                        <a href="{{ route('admin.mapel.edit', $m) }}"
                           class="p-1.5 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg transition">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('admin.mapel.destroy', $m) }}"
                              method="POST" class="inline delete-form">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="p-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
                <div class="text-center py-16 text-gray-400">
                    <div class="bg-gray-50 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="book-open" class="w-7 h-7 text-gray-300"></i>
                    </div>
                    <p class="text-sm font-medium">
                        {{ request('search') ? 'Tidak ada hasil untuk "' . request('search') . '"' : 'Belum ada data mata pelajaran' }}
                    </p>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if($mapel->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $mapel->appends(request()->query())->links() }}
        </div>
        @endif

    </div>
</div>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success', title: 'Berhasil!',
    text: "{{ session('success') }}",
    timer: 2000, showConfirmButton: false,
    customClass: { popup: 'rounded-2xl' }
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error', title: 'Gagal!',
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