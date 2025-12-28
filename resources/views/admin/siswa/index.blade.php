{{-- resources/views/admin/siswa/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Data Siswa')

@section('content')
<div class="space-y-6">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-2xl p-5 md:p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-indigo-900 flex items-center gap-3">
                    <i data-lucide="user-check" class="w-8 h-8 text-purple-600"></i>
                    Data Siswa
                </h2>
                <p class="text-sm text-indigo-700 mt-1">Total: {{ $siswas->total() }} siswa</p>
            </div>
            <a href="{{ route('admin.siswa.create') }}"
               class="inline-flex items-center justify-center px-6 py-3.5 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 text-white font-bold rounded-xl shadow-lg transition hover:-translate-y-1 w-full sm:w-auto">
                <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                Tambah Siswa
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

    <!-- SEARCH BAR — LEBIH RESPONSIVE -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4">
        <form action="{{ route('admin.siswa.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <i data-lucide="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIS, Nama, Email, atau Kelas..."
                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex gap-3">
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-bold rounded-xl shadow hover:shadow-lg transition w-full sm:w-auto">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.siswa.index') }}"
                       class="px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-300 transition text-center w-full sm:w-auto">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- CARD LIST DI HP, TABLE DI DESKTOP -->
    <div class="space-y-4 lg:hidden">
        <!-- CARD MODE UNTUK HP -->
        @forelse($siswas as $siswa)
            <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-5 hover:shadow-lg transition">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="font-bold text-indigo-900 text-lg">{{ $siswa->nama }}</p>
                        <p class="text-sm text-gray-600">NIS: <code class="bg-gray-100 px-2 py-1 rounded">{{ $siswa->nis ?? '-' }}</code></p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.siswa.edit', $siswa) }}" class="text-indigo-600 hover:text-indigo-800">
                            <i data-lucide="edit" class="w-5 h-5"></i>
                        </a>
                        <!-- TAMBAH CLASS delete-form BIAR SWEETALERT JALAN -->
                        <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" class="inline delete-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-medium truncate">{{ $siswa->user->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Kelas</p>
                        <p class="font-medium">{{ $siswa->kelas->nama_kelas ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Jenis Kelamin</p>
                        <p class="font-medium">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : ($siswa->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Telepon</p>
                        <p class="font-medium">{{ $siswa->telepon ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Telepon Wali</p>
                        <p class="font-medium">{{ $siswa->telepon_wali ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Lahir</p>
                        <p class="font-medium">{{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d/m/Y') : '-' }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <i data-lucide="users" class="w-20 h-20 mx-auto text-gray-300 mb-4"></i>
                <p class="text-xl font-bold text-gray-600">Belum Ada Data Siswa</p>
            </div>
        @endforelse
    </div>

    <!-- TABLE MODE UNTUK DESKTOP (lg+) -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                    <tr>
                        <th class="px-4 py-4 text-left">No</th>
                        <th class="px-4 py-4 text-left">NIS</th>
                        <th class="px-4 py-4 text-left">Nama</th>
                        <th class="px-4 py-4 text-left">Jenis Kelamin</th>
                        <th class="px-4 py-4 text-left">Tanggal Lahir</th>
                        <th class="px-4 py-4 text-left">Kelas</th>
                        <th class="px-4 py-4 text-left">Telepon</th>
                        <th class="px-4 py-4 text-left">Telepon Wali</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($siswas as $index => $siswa)
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="px-4 py-5 text-center">{{ $siswas->firstItem() + $index }}</td>
                            <td class="px-4 py-5"><code class="bg-gray-100 px-3 py-1 rounded">{{ $siswa->nis ?? '-' }}</code></td>
                            <td class="px-4 py-5 font-semibold">{{ $siswa->nama }}</td>
                            <td class="px-4 py-5">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $siswa->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td class="px-4 py-5">{{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                            <td class="px-4 py-5"><span class="px-3 py-1 rounded-full bg-purple-100 text-purple-800 text-xs font-bold">{{ $siswa->kelas->nama_kelas ?? '-' }}</span></td>
                            <td class="px-4 py-5">{{ $siswa->telepon ?? '-' }}</td>
                            <td class="px-4 py-5">{{ $siswa->telepon_wali ?? '-' }}</td>
                            <td class="px-4 py-5 text-center">
                                <div class="flex justify-center gap-4">
                                    <a href="{{ route('admin.siswa.edit', $siswa) }}" class="text-indigo-600 hover:text-indigo-800">
                                        <i data-lucide="edit" class="w-5 h-5"></i>
                                    </a>
                                    <!-- TAMBAH CLASS delete-form BIAR SWEETALERT JALAN -->
                                    <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" class="inline delete-form">
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
                            <td colspan="9" class="text-center py-16 text-gray-500">
                                Belum ada data siswa
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border-t px-6 py-4">
            {{ $siswas->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- SCRIPT SWEETALERT LU SUDAH ADA & JALAN KALAU ADA CLASS delete-form -->
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