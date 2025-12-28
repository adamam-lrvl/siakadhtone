{{-- resources/views/admin/kelas/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Data Kelas')

@section('content')
<div class="space-y-6">

    <!-- HEADER — SAMA PERSIS KAYAK SISWA (INDIGO TO PURPLE) -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-2xl p-5 md:p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-indigo-900 flex items-center gap-3">
                    <i data-lucide="school" class="w-8 h-8 text-indigo-600"></i>
                    Data Kelas
                </h2>
                <p class="text-sm text-indigo-700 mt-1">Kelola kelas dan wali kelas sekolah</p>
            </div>
            <a href="{{ route('admin.kelas.create') }}"
               class="inline-flex items-center justify-center px-6 py-3.5 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 text-white font-bold rounded-xl shadow-lg transition hover:-translate-y-1">
                <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                Tambah Kelas
            </a>
        </div>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl flex items-center shadow-sm">
            <i data-lucide="check-circle" class="w-6 h-6 mr-3"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- TABLE CARD — WARNA HEADER SAMA PERSIS SISWA -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="overflow-hidden">
            <div class="w-full">
                <table class="w-full table-fixed divide-y divide-gray-200 text-sm">
                    <thead class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                        <tr>
                            <th class="w-20 px-3 py-4 text-left font-bold uppercase tracking-wider">Kode</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wider">Nama Kelas</th>
                            <th class="px-4 py-4 text-left font-bold uppercase tracking-wider hidden md:table-cell">Wali Kelas</th>
                            <th class="w-24 px-3 py-4 text-center font-bold uppercase tracking-wider hidden sm:table-cell">Siswa</th>
                            <th class="w-28 px-3 py-4 text-center font-bold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($kelas as $k)
                            <tr class="hover:bg-indigo-50 transition-all duration-200">
                                <td class="px-3 py-5 font-bold text-gray-900 whitespace-nowrap">
                                    {{ $k->kode_kelas }}
                                </td>

                                <td class="px-4 py-5 font-bold text-gray-900">
                                    {{ $k->nama_kelas }}
                                    <div class="md:hidden text-xs text-gray-600 mt-1">
                                        @if($k->waliKelas)
                                            Wali: {{ $k->waliKelas->nama }}
                                        @else
                                            <span class="italic text-gray-400">Belum ada wali</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-4 py-5 hidden md:table-cell">
                                    @if($k->waliKelas)
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 bg-indigo-100 rounded-full flex items-center justify-center">
                                                <i data-lucide="user" class="w-5 h-5 text-indigo-600"></i>
                                            </div>
                                            <span class="font-semibold text-indigo-800">{{ $k->waliKelas->nama }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">Belum ada wali kelas</span>
                                    @endif
                                </td>

                                <td class="px-3 py-5 text-center hidden sm:table-cell">
                                    <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-bold {{ $k->siswas_count > 0 ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $k->siswas_count }}
                                    </span>
                                </td>

                                <td class="px-3 py-5 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('admin.kelas.edit', $k->id) }}"
                                           class="text-indigo-600 hover:text-indigo-800">
                                            <i data-lucide="edit" class="w-5 h-5"></i>
                                        </a>
                                        <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" class="inline delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit"class="text-red-600 hover:text-red-800">   
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-20">
                                    <i data-lucide="school" class="w-20 h-20 mx-auto text-gray-300 mb-4"></i>
                                    <p class="text-xl font-bold text-gray-600">Belum Ada Data Kelas</p>
                                    <p class="text-gray-500 mt-2">Klik tombol "Tambah Kelas" untuk memulai</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PAGINATION — SAMA KAYAK SISWA -->
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border-t border-gray-200 px-6 py-4">
            {{ $kelas->links() }}
        </div>
    </div>
</div>

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