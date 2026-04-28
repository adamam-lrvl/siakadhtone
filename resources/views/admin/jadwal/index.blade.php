{{-- resources/views/admin/jadwal/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Data Jadwal Pelajaran')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER BIRU --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="calendar-clock" class="w-6 h-6 flex-shrink-0"></i>
                    <span>Data jadwal pelajaran</span>
                </h1>
                <p class="text-blue-100 text-sm mt-1">Kelola jadwal harian per kelas</p>
            </div>
            <a href="{{ route('admin.jadwal.create') }}"
               class="flex items-center gap-2 px-4 py-2 bg-white/15 hover:bg-white/25
                      text-white text-sm font-semibold rounded-xl transition flex-shrink-0">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span class="hidden sm:inline">Tambah jadwal</span>
                <span class="sm:hidden">Tambah</span>
            </a>
        </div>

        {{-- SEARCH --}}
        <form action="{{ route('admin.jadwal.index') }}" method="GET" class="mt-4 flex gap-2">
            <div class="flex-1 relative">
                <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari kelas, mapel, atau guru..."
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
                <a href="{{ route('admin.jadwal.index') }}"
                   class="px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white
                          text-sm font-semibold rounded-xl transition flex-shrink-0">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- SUCCESS / ERROR --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3
                    rounded-xl flex items-center gap-3 text-sm font-medium">
            <i data-lucide="check-circle" class="w-4 h-4 flex-shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3
                    rounded-xl flex items-center gap-3 text-sm font-medium">
            <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- KONTEN --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

        {{-- DESKTOP: TABEL --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                        <th class="px-5 py-3.5 text-left font-semibold w-28">Kelas</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Mapel</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Guru</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Hari & jam</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($jadwal as $grouped)
                        <tr class="hover:bg-indigo-50/30 transition {{ $loop->even ? 'bg-gray-50/50' : '' }}">
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs
                                             font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                    {{ $grouped['kelas']->nama_kelas }}
                                </span>
                            </td>
                            <td class="px-5 py-4 font-semibold text-gray-900">
                                {{ $grouped['mapel']->nama_mapel }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-indigo-50 rounded-full flex items-center
                                                justify-center flex-shrink-0">
                                        <i data-lucide="user" class="w-3.5 h-3.5 text-indigo-600"></i>
                                    </div>
                                    <span class="font-medium text-gray-700">{{ $grouped['guru']->nama }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex flex-col gap-1.5">
                                    @foreach($grouped['hari_jam'] as $hj)
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs
                                                         font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                                {{ $hj['hari'] }}
                                            </span>
                                            <span class="text-xs text-gray-500">{{ $hj['jam'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.jadwal.edit', $grouped['id']) }}"
                                       class="p-1.5 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg transition">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.jadwal.destroy', $grouped['id']) }}"
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
                                    <i data-lucide="calendar-x" class="w-7 h-7 text-gray-300"></i>
                                </div>
                                <p class="text-sm font-medium">
                                    {{ request('search') ? 'Tidak ada hasil untuk "' . request('search') . '"' : 'Belum ada jadwal pelajaran' }}
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE: CARD LIST --}}
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($jadwal as $grouped)
            <div class="p-4 hover:bg-gray-50 transition">

                {{-- BARIS ATAS: kelas + aksi --}}
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs
                                         font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                {{ $grouped['kelas']->nama_kelas }}
                            </span>
                        </div>
                        <p class="font-semibold text-gray-900 mt-1.5">{{ $grouped['mapel']->nama_mapel }}</p>
                        <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                            <i data-lucide="user" class="w-3 h-3"></i>
                            {{ $grouped['guru']->nama }}
                        </p>
                    </div>
                    <div class="flex gap-2 flex-shrink-0">
                        <a href="{{ route('admin.jadwal.edit', $grouped['id']) }}"
                           class="p-1.5 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg transition">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('admin.jadwal.destroy', $grouped['id']) }}"
                              method="POST" class="inline delete-form">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="p-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- HARI & JAM --}}
                <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-100 mt-2">
                    @foreach($grouped['hari_jam'] as $hj)
                        <div class="flex items-center gap-1.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs
                                         font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $hj['hari'] }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $hj['jam'] }}</span>
                        </div>
                    @endforeach
                </div>

            </div>
            @empty
                <div class="text-center py-16 text-gray-400">
                    <div class="bg-gray-50 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="calendar-x" class="w-7 h-7 text-gray-300"></i>
                    </div>
                    <p class="text-sm font-medium">
                        {{ request('search') ? 'Tidak ada hasil untuk "' . request('search') . '"' : 'Belum ada jadwal pelajaran' }}
                    </p>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if($jadwal->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $jadwal->appends(request()->query())->links() }}
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