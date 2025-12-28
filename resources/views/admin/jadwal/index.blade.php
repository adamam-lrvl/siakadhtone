{{-- resources/views/admin/jadwal/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Data Jadwal Pelajaran')

@section('content')
<div class="space-y-6">

    <!-- HEADER INDIGO-PURPLE -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-2xl p-5 md:p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-indigo-900 flex items-center gap-3">
                    <i data-lucide="calendar-clock" class="w-8 h-8 text-purple-600"></i>
                    Data Jadwal Pelajaran
                </h2>
                <p class="text-sm text-indigo-700 mt-1">Kelola jadwal harian per kelas</p>
            </div>

            <a href="{{ route('admin.jadwal.create') }}"
               class="inline-flex items-center justify-center gap-3 px-6 py-3.5 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Tambah Jadwal
            </a>
        </div>
    </div>

    <!-- SUCCESS / ERROR MESSAGE -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl flex items-center shadow-sm">
            <i data-lucide="check-circle" class="w-6 h-6 mr-3"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl flex items-center shadow-sm">
            <i data-lucide="alert-circle" class="w-6 h-6 mr-3"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- CARD UTAMA -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">

        <!-- DESKTOP TABLE — GROUPING HARI & JAM -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                    <tr>
                        <th class="px-5 py-4 text-left font-bold uppercase tracking-wider">Kelas</th>
                        <th class="px-5 py-4 text-left font-bold uppercase tracking-wider">Mapel</th>
                        <th class="px-5 py-4 text-left font-bold uppercase tracking-wider">Guru</th>
                        <th class="px-5 py-4 text-left font-bold uppercase tracking-wider">Hari & Jam</th>
                        <th class="px-5 py-4 text-center font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($jadwal as $grouped)
                    <tr class="hover:bg-indigo-50 transition">
                        <td class="px-5 py-4">
                            <span class="bg-purple-100 text-purple-800 px-3 py-1.5 rounded-full text-xs font-bold">
                                {{ $grouped['kelas']->nama_kelas }}
                            </span>
                        </td>

                        <td class="px-5 py-4 font-semibold text-gray-900">
                            {{ $grouped['mapel']->nama_mapel }}
                        </td>

                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <i data-lucide="user" class="w-5 h-5 text-indigo-700"></i>
                                </div>
                                <span class="font-medium text-gray-900">{{ $grouped['guru']->nama }}</span>
                            </div>
                        </td>

                        <td class="px-5 py-4">
                            <div class="space-y-2">
                                @foreach($grouped['hari_jam'] as $hj)
                                    <div class="flex items-center gap-3">
                                        <span class="px-3 py-1.5 bg-indigo-100 text-indigo-800 rounded-full text-xs font-bold">
                                            {{ $hj['hari'] }}
                                        </span>
                                        <span class="text-sm font-medium text-gray-700">{{ $hj['jam'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </td>

                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-4">
                                <!-- EDIT -->
                                <a href="{{ route('admin.jadwal.edit', $grouped['id']) }}" class="text-indigo-600 hover:text-indigo-800 transition">
                                    <i data-lucide="edit" class="w-5 h-5"></i>
                                </a>

                                <!-- DELETE DENGAN SWEETALERT -->
                                <form action="{{ route('admin.jadwal.destroy', $grouped['id']) }}" method="POST" class="inline delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-16 text-gray-500">
                            <i data-lucide="calendar-x" class="w-20 h-20 mx-auto text-gray-300 mb-4"></i>
                            <p class="text-lg font-medium">Belum ada jadwal pelajaran</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARD VIEW -->
        <div class="md:hidden p-5 space-y-5">
            @forelse ($jadwal as $grouped)
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 shadow-md hover:shadow-xl transition p-6">
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1.5 bg-purple-100 text-purple-800 rounded-full text-xs font-bold">
                        {{ $grouped['kelas']->nama_kelas }}
                    </span>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    {{ $grouped['mapel']->nama_mapel }}
                </h3>

                <div class="flex items-center text-gray-700 text-sm mb-4">
                    <i data-lucide="user" class="w-5 h-5 mr-2 text-indigo-600"></i>
                    <span class="font-medium">{{ $grouped['guru']->nama }}</span>
                </div>

                <div class="space-y-2 mb-6">
                    @foreach($grouped['hari_jam'] as $hj)
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1.5 bg-indigo-100 text-indigo-800 rounded-full text-xs font-bold">
                                {{ $hj['hari'] }}
                            </span>
                            <span class="text-indigo-700 font-semibold">{{ $hj['jam'] }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.jadwal.edit', $grouped['id']) }}" class="p-3.5 bg-indigo-100 text-indigo-700 rounded-2xl hover:bg-indigo-200 transition">
                        <i data-lucide="edit" class="w-6 h-6"></i>
                    </a>
                    <form action="{{ route('admin.jadwal.destroy', $grouped['id']) }}" method="POST" class="inline delete-form">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-3.5 bg-red-100 text-red-700 rounded-2xl hover:bg-red-200 transition">
                            <i data-lucide="trash-2" class="w-6 h-6"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-20 text-gray-500">
                <i data-lucide="calendar-x" class="w-24 h-24 mx-auto mb-6 text-gray-300"></i>
                <p class="text-xl font-medium">Belum ada jadwal pelajaran</p>
            </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        <div class="px-6 py-5 bg-gradient-to-r from-indigo-50 to-purple-50 border-t border-gray-200">
            {{ $jadwal->links() }}
        </div>
    </div>
</div>

<!-- SWEETALERT DELETE CONFIRMATION -->
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

@endsection