{{-- resources/views/admin/mapel/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Data Mata Pelajaran')

@section('content')
<div class="space-y-6">

    <!-- HEADER — INDIGO PURPLE GANG -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-2xl p-5 md:p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-indigo-900 flex items-center gap-3">
                    <i data-lucide="book-open" class="w-8 h-8 text-indigo-600"></i>
                    Data Mata Pelajaran
                </h2>
                <p class="text-sm text-indigo-700 mt-1">Kelola mata pelajaran dan KKM</p>
            </div>
            <a href="{{ route('admin.mapel.create') }}"
               class="inline-flex items-center justify-center px-6 py-3.5 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 text-white font-bold rounded-xl shadow-lg transition hover:-translate-y-1">
                <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                Tambah Mapel
            </a>
        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full table-fixed divide-y divide-gray-200 text-sm">
                <thead class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                    <tr>
                        <th class="w-24 px-4 py-4 text-left font-bold uppercase tracking-wider">Kode</th>
                        <th class="px-4 py-4 text-left font-bold uppercase tracking-wider">Nama Mapel</th>
                        <th class="w-20 px-4 py-4 text-center font-bold uppercase tracking-wider hidden sm:table-cell">KKM</th>
                        <th class="px-4 py-4 text-left font-bold uppercase tracking-wider hidden md:table-cell">Kategori</th>
                        <th class="w-32 px-4 py-4 text-center font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($mapel as $m)
                        <tr class="hover:bg-indigo-50 transition-all duration-200">
                            <td class="px-4 py-5 font-mono text-xs font-bold text-gray-900">
                                <code class="bg-gray-100 px-2 py-1 rounded">{{ $m->kode }}</code>
                            </td>
                            <td class="px-4 py-5 font-semibold text-gray-900">
                                {{ $m->nama_mapel }}
                            </td>
                            <td class="px-4 py-5 text-center hidden sm:table-cell">
                                <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                                    {{ $m->kkm }}
                                </span>
                            </td>
                            <td class="px-4 py-5 hidden md:table-cell">
                                <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-bold 
                                    {{ $m->kategori == 'wajib' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ $m->kategori == 'wajib' ? 'Muatan Wajib' : 'Peminatan' }}
                                </span>
                            </td>
                            <td class="px-4 py-5 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('admin.mapel.edit', $m) }}"
                                       class="text-indigo-600 hover:text-indigo-800">
                                        <i data-lucide="edit" class="w-5 h-5"></i>
                                    </a>

                                    <form action="{{ route('admin.mapel.destroy', $m) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-20">
                                <i data-lucide="book-open" class="w-20 h-20 mx-auto text-gray-300 mb-4"></i>
                                <p class="text-xl font-bold text-gray-600">Belum Ada Data Mata Pelajaran</p>
                                <p class="text-gray-500 mt-2">Klik tombol "Tambah Mapel" untuk memulai</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border-t border-gray-200 px-6 py-4">
            {{ $mapel->links() }}
        </div>
    </div>
</div>

{{-- SWEET ALERT --}}
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
