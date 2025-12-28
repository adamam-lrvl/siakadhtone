{{-- resources/views/admin/soal/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Data Paket Soal CBT')

@section('content')
<div class="space-y-6">

    <!-- HEADER — INDIGO PURPLE GANG STYLE -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-2xl p-5 md:p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-indigo-900 flex items-center gap-3">
                    <i data-lucide="file-question" class="w-8 h-8 text-indigo-600"></i>
                    Paket Soal CBT
                </h2>
                <p class="text-sm text-indigo-700 mt-1">Kelola paket soal ujian online</p>
            </div>
            <a href="{{ route('admin.soal.create') }}"
               class="inline-flex items-center justify-center px-6 py-3.5 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 text-white font-bold rounded-xl shadow-lg transition hover:-translate-y-1">
                <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                Buat Paket
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

    <!-- TABLE CARD -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                    <tr>
                        <th class="px-4 py-4 text-left font-bold uppercase tracking-wider">Paket Soal</th>
                        <th class="px-4 py-4 text-left font-bold uppercase tracking-wider hidden sm:table-cell">Mapel</th>
                        <th class="px-4 py-4 text-left font-bold uppercase tracking-wider hidden md:table-cell">Kelas</th>
                        <th class="px-4 py-4 text-center font-bold uppercase tracking-wider hidden lg:table-cell">Soal</th>
                        <th class="px-4 py-4 text-center font-bold uppercase tracking-wider hidden lg:table-cell">Durasi</th>
                        <th class="px-4 py-4 text-center font-bold uppercase tracking-wider hidden xl:table-cell">Status</th>
                        <th class="px-4 py-4 text-center font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($paketSoal as $p)
                        <tr class="hover:bg-indigo-50 transition-all duration-200">
                            <!-- KOLOM UTAMA: Judul + Info Mobile -->
                            <td class="px-4 py-5">
                                <div class="font-semibold text-gray-900">
                                    {{ $p->judul }}
                                </div>
                                <div class="mt-2 space-y-2 text-xs text-gray-600 sm:hidden">
                                    <div class="flex flex-wrap gap-2">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $p->mapel->nama_mapel }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $p->kelas->nama_kelas }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-4 text-xs">
                                        <span><i data-lucide="copy" class="inline w-4 h-4 mr-1"></i> {{ $p->soal_count }} soal</span>
                                        <span><i data-lucide="clock" class="inline w-4 h-4 mr-1"></i> {{ $p->durasi }} menit</span>
                                    </div>
                                    <div>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold 
                                            {{ $p->aktif ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $p->aktif ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- MAPEL (Desktop) -->
                            <td class="px-4 py-5 hidden sm:table-cell">
                                <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                    {{ $p->mapel->nama_mapel }}
                                </span>
                            </td>

                            <!-- KELAS (Desktop) -->
                            <td class="px-4 py-5 hidden md:table-cell">
                                <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                                    {{ $p->kelas->nama_kelas }}
                                </span>
                            </td>

                            <!-- JUMLAH SOAL -->
                            <td class="px-4 py-5 text-center hidden lg:table-cell">
                                <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                                    {{ $p->soal_count }}
                                </span>
                            </td>

                            <!-- DURASI -->
                            <td class="px-4 py-5 text-center hidden lg:table-cell">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                    {{ $p->durasi }} menit
                                </span>
                            </td>

                            <!-- STATUS -->
                            <td class="px-4 py-5 text-center hidden xl:table-cell">
                                <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-bold 
                                    {{ $p->aktif ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $p->aktif ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>

                            <!-- AKSI — SELALU TAMPIL -->
                            <td class="px-4 py-5 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('admin.soal.show', $p) }}"
                                       class="text-blue-600 hover:text-blue-800 transition" title="Lihat Detail">
                                        <i data-lucide="eye" class="w-5 h-5"></i>
                                    </a>
                                    <a href="{{ route('admin.soal.edit', $p) }}"
                                       class="text-indigo-600 hover:text-indigo-800 transition" title="Edit">
                                        <i data-lucide="edit" class="w-5 h-5"></i>
                                    </a>
                                    <form action="{{ route('admin.soal.destroy', $p->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Yakin hapus paket &quot;{{ addslashes($p->judul) }}&quot;?')"
                                                class="text-red-600 hover:text-red-800 transition" title="Hapus">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-20">
                                <i data-lucide="file-question" class="w-20 h-20 mx-auto text-gray-300 mb-4"></i>
                                <p class="text-xl font-bold text-gray-600">Belum Ada Paket Soal</p>
                                <p class="text-gray-500 mt-2">Klik "Buat Paket" untuk memulai</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border-t border-gray-200 px-6 py-4">
            {{ $paketSoal->links() }}
        </div>
    </div>
</div>
@endsection