{{-- resources/views/admin/soal/show.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Detail Paket Soal - ' . $soal->judul)

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">

        <!-- HEADER GRADIENT INDIGO-PURPLE -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-8 py-7 text-white">
            <div class="flex items-center gap-5">
                <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4">
                    <i data-lucide="file-text" class="w-10 h-10"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold">{{ $soal->judul }}</h1>
                    <p class="text-indigo-100 text-base opacity-90 mt-1">Detail lengkap paket soal CBT</p>
                </div>
            </div>
        </div>

        <div class="p-8">

            <!-- INFORMASI PAKET -->
            <div class="mb-10 p-7 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl border border-indigo-200">
                <h3 class="text-xl font-bold text-indigo-900 mb-6 flex items-center gap-3">
                    <i data-lucide="info" class="w-6 h-6"></i>
                    Informasi Paket
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-indigo-100">
                        <p class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">Mata Pelajaran</p>
                        <p class="text-lg font-bold text-gray-800 mt-1">{{ $soal->mapel->nama_mapel }}</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-indigo-100">
                        <p class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">Kelas</p>
                        <p class="text-lg font-bold text-gray-800 mt-1">{{ $soal->kelas->nama_kelas }}</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-indigo-100">
                        <p class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">Durasi Ujian</p>
                        <p class="text-lg font-bold text-gray-800 mt-1">{{ $soal->durasi }} menit</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-indigo-100">
                        <p class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">Jumlah Soal</p>
                        <p class="text-lg font-bold text-gray-800 mt-1">{{ $soal->soal->count() }} soal</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-indigo-100">
                        <p class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">Status</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold
                                {{ $soal->aktif 
                                    ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white' 
                                    : 'bg-gradient-to-r from-gray-400 to-gray-600 text-white' }}">
                                <i data-lucide="{{ $soal->aktif ? 'check-circle' : 'x-circle' }}" class="w-4 h-4 mr-1.5"></i>
                                {{ $soal->aktif ? 'AKTIF' : 'NONAKTIF' }}
                            </span>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-indigo-100">
                        <p class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">Dibuat Pada</p>
                        <p class="text-lg font-bold text-gray-800 mt-1">
                            {{ $soal->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- DAFTAR SOAL -->
            <div class="mb-10">
                <h3 class="text-xl font-bold text-indigo-900 mb-6 flex items-center gap-3">
                    <i data-lucide="list-ordered" class="w-7 h-7"></i>
                    Daftar Soal ({{ $soal->soal->count() }})
                </h3>

                <div class="space-y-6">
                    @foreach($soal->soal as $index => $item)
                        @php
                            $pilihan = $item->pilihan ? json_decode($item->pilihan, true) : [];
                        @endphp

                        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-md hover:shadow-xl transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <span class="text-2xl font-bold text-indigo-700">
                                    {{ $index + 1 }}
                                </span>
                                <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider
                                    {{ $item->tipe === 'pg' ? 'bg-indigo-100 text-indigo-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ $item->tipe === 'pg' ? 'Pilihan Ganda' : 'Essay' }}
                                </span>
                            </div>

                            <div class="prose prose-sm max-w-none mb-5">
                                <p class="text-gray-800 font-medium leading-relaxed">
                                    {!! nl2br(e($item->pertanyaan)) !!}
                                </p>
                            </div>

                            @if($item->tipe === 'pg')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                                    @foreach($pilihan as $key => $value)
                                        @php $letter = strtoupper($key); @endphp
                                        <div class="flex items-center p-4 rounded-xl border
                                            {{ $item->jawaban === $letter ? 'border-green-400 bg-green-50' : 'border-gray-200 bg-gray-50' }}">
                                            <span class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg
                                                {{ $item->jawaban === $letter ? 'bg-green-600 text-white' : 'bg-gray-300 text-gray-700' }}">
                                                {{ $letter }}
                                            </span>
                                            <span class="ml-4 text-gray-800">{{ $value }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="flex items-center gap-2 text-green-600 font-bold">
                                    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                                    Jawaban Benar: <span class="text-xl">{{ strtoupper($item->jawaban) }}</span>
                                </div>
                            @else
                                <div class="p-5 bg-purple-50 border-2 border-dashed border-purple-300 rounded-xl">
                                    <p class="text-purple-700 font-semibold mb-2">Kunci Jawaban Essay:</p>
                                    <p class="text-gray-800 leading-relaxed">{!! nl2br(e($item->jawaban)) !!}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- TOMBOL AKSI -->
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('admin.soal.edit', $soal) }}"
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition">
                    <i data-lucide="edit-3" class="w-5 h-5 mr-2"></i>
                    Edit Paket
                </a>

                <a href="{{ route('admin.soal.index') }}"
                   class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl shadow transition">
                    <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                    Kembali ke Daftar
                </a>
            </div>

        </div>
    </div>
</div>

{{-- AUTO CREATE ICONS --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
</script>
@endsection