{{-- resources/views/admin/guru/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Data Guru')

@section('content')
<div class="space-y-6">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-2xl p-5 md:p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-indigo-900 flex items-center gap-3">
                    <i data-lucide="users" class="w-8 h-8 text-indigo-600"></i>
                    Data Guru
                </h2>
                <p class="text-sm text-indigo-700 mt-1">Kelola semua data pengajar</p>
            </div>
            <a href="{{ route('admin.guru.create') }}"
               class="inline-flex items-center justify-center px-6 py-3.5 bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-bold rounded-xl shadow-lg hover:-translate-y-1 transition">
                <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                Tambah Guru
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

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                    <tr>
                        <th class="px-4 py-4 text-left font-bold">NIP</th>
                        <th class="px-4 py-4 text-left font-bold">Nama Guru</th>
                        <th class="px-4 py-4 text-left font-bold hidden md:table-cell">Email</th>
                        <th class="px-4 py-4 text-left font-bold">Mapel Mengajar</th>
                        <th class="px-4 py-4 text-left font-bold hidden sm:table-cell">Telepon</th>
                        <th class="px-4 py-4 text-center font-bold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse($gurus as $guru)
                    <tr class="hover:bg-indigo-50 transition">
                        <td class="px-4 py-5 font-mono text-xs font-bold">
                            <code class="bg-gray-100 px-2 py-1 rounded">
                                {{ $guru->nip ?? '-' }}
                            </code>
                        </td>

                        <td class="px-4 py-5 font-semibold">
                            {{ $guru->nama }}
                            <p class="text-xs text-gray-500 md:hidden mt-1">
                                {{ $guru->email }}
                            </p>
                        </td>

                        <td class="px-4 py-5 hidden md:table-cell">
                            {{ $guru->email ?? '-' }}
                        </td>

                        <!-- MAPEL MENGAJAR — BANYAK MAPEL (MANY-TO-MANY) -->
                        <td class="px-4 py-5">
                            <div class="flex flex-wrap gap-2">
                                @if($guru->mapels->count() > 0)
                                    @foreach($guru->mapels as $mapel)
                                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                                            {{ $mapel->nama_mapel }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-gray-500 text-xs italic">Belum mengajar mapel</span>
                                @endif
                            </div>
                            <!-- Di HP tampilkan mapel kalau hidden -->
                            <div class="md:hidden mt-3 flex flex-wrap gap-2">
                                @if($guru->mapels->count() > 0)
                                    @foreach($guru->mapels as $mapel)
                                        <span class="px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-800">
                                            {{ $mapel->kode ?? $mapel->nama_mapel }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </td>

                        <td class="px-4 py-5 hidden sm:table-cell">
                            {{ $guru->telepon ?? '-' }}
                        </td>

                        <td class="px-4 py-5 text-center">
                            <div class="flex justify-center gap-4">
                                <a href="{{ route('admin.guru.edit', $guru) }}"
                                   class="p-2 rounded-full hover:bg-indigo-100 text-indigo-600 transition">
                                    <i data-lucide="edit" class="w-5 h-5"></i>
                                </a>

                                <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" class="inline delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="p-2 rounded-full hover:bg-red-100 text-red-600 transition">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-16 text-gray-500">
                            <i data-lucide="users" class="w-20 h-20 mx-auto text-gray-300 mb-4"></i>
                            <p class="text-lg font-medium">Belum ada data guru</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border-t px-6 py-4">
            {{ $gurus->links() }}
        </div>
    </div>
</div>

<!-- SWEETALERT DELETE CONFIRMATION -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    lucide.createIcons();

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Yakin hapus guru ini?',
                text: "Data guru tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-2xl' }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection