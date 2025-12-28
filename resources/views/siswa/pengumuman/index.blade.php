{{-- resources/views/siswa/pengumuman/index.blade.php --}}
@extends('siswa.layouts.app')
@section('title', 'Pengumuman')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <!-- HEADER INDIGO-PURPLE GRADIENT (SAMA PERSIS YANG LAIN) -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-8 text-white shadow-2xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">
                    Pengumuman Sekolah
                </h1>
                <p class="text-indigo-100 text-lg">
                    Informasi terbaru untuk {{ Auth::user()->siswa->nama }}
                </p>
            </div>
            <div class="mt-6 md:mt-0 text-right">
                <p class="text-sm opacity-90">Total Pengumuman</p>
                <p class="text-2xl font-bold">{{ $pengumuman->total() }}</p>
            </div>
        </div>
    </div>

    <!-- CARD MODE DI HP — INDIGO-PURPLE GANG -->
    <div class="space-y-6 lg:hidden">
        @forelse($pengumuman as $p)
            <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 p-6 hover:shadow-2xl transition">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="font-extrabold text-indigo-900 text-xl">{{ $p->judul }}</h3>
                        <p class="text-sm text-purple-600 mt-1">
                            {{ $p->created_at->translatedFormat('d F Y • H:i') }}
                        </p>
                    </div>
                    <i data-lucide="megaphone" class="w-8 h-8 text-purple-600 ml-4"></i>
                </div>
                <p class="text-gray-700 leading-relaxed line-clamp-4">
                    {{ $p->isi }}
                </p>
                <div class="mt-4 text-right">
                    <span class="text-xs text-gray-500">Diposting oleh: {{ $p->user->name ?? 'Admin' }}</span>
                </div>
            </div>
        @empty
            <div class="text-center py-20 text-gray-500">
                <i data-lucide="volume-x" class="w-24 h-24 mx-auto mb-6 text-gray-300"></i>
                <p class="text-xl font-medium">Belum ada pengumuman</p>
                <p class="mt-2">Tunggu info terbaru dari sekolah ya 😊</p>
            </div>
        @endforelse
    </div>

    <!-- TABLE MODE DI DESKTOP (lg+) — INDIGO-PURPLE GANG -->
    <div class="hidden lg:block bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Judul Pengumuman</th>
                        <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Diposting Oleh</th>
                        <th class="px-6 py-4 text-left font-bold uppercase tracking-wider">Isi Singkat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-100">
                    @forelse($pengumuman as $p)
                        <tr class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition">
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center gap-2 text-indigo-700">
                                    <i data-lucide="calendar" class="w-5 h-5 text-purple-600"></i>
                                    {{ $p->created_at->translatedFormat('d F Y') }}
                                    <span class="block text-xs text-gray-600">{{ $p->created_at->format('H:i') }}</span>
                                </span>
                            </td>
                            <td class="px-6 py-5 font-bold text-purple-800">
                                {{ $p->judul }}
                            </td>
                            <td class="px-6 py-5 text-indigo-700">
                                {{ $p->user->name ?? 'Admin' }}
                            </td>
                            <td class="px-6 py-5 text-gray-700 max-w-lg">
                                {{ Str::limit(strip_tags($p->isi), 150) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-16 text-gray-500">
                                Belum ada pengumuman
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border-t px-6 py-4">
            {{ $pengumuman->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection