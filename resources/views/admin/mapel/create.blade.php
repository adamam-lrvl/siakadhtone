@extends('admin.layouts.admin')
@section('title', 'Tambah Mapel')

@section('content')
<div class="max-w-2xl mx-auto">

    <!-- CARD UTAMA PREMIUM -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

        <!-- HEADER GRADIENT -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-5 text-white">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                    <i data-lucide="book-plus" class="w-7 h-7"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Tambah Mata Pelajaran</h2>
                    <p class="text-indigo-100 text-sm opacity-90">Isi data mapel dengan lengkap</p>
                </div>
            </div>
        </div>

        <!-- BODY FORM -->
        <div class="p-5 md:p-7">

            <!-- ERROR ALERT -->
            @if($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="flex items-center gap-2">
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.mapel.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-5">

                    <!-- KODE MAPEL -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Kode Mapel <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kode" value="{{ old('kode') }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                   @error('kode') border-red-500 @enderror"
                            placeholder="Contoh: MAT">
                        @error('kode') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- NAMA MAPEL -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Nama Mapel <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_mapel" value="{{ old('nama_mapel') }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                   @error('nama_mapel') border-red-500 @enderror"
                            placeholder="Contoh: Matematika">
                        @error('nama_mapel') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                </div>

                <!-- BUTTON -->
                <div class="mt-8 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 
                               text-white font-semibold rounded-xl shadow-lg hover:shadow-xl 
                               transform hover:-translate-y-0.5 transition">
                        <i data-lucide="save" class="w-5 h-5 inline mr-2"></i>
                        Simpan Mapel
                    </button>

                    <a href="{{ route('admin.mapel.index') }}"
                        class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl 
                               hover:bg-gray-200 transition text-center">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
