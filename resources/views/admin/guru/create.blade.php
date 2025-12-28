{{-- resources/views/admin/guru/create.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Tambah Guru Baru')

@section('content')
<div class="max-w-3xl mx-auto">

    <!-- CARD UTAMA PREMIUM -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

        <!-- HEADER INDIGO-PURPLE GRADIENT -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-5 text-white">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                    <i data-lucide="user-plus" class="w-7 h-7"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Tambah Guru Baru</h2>
                    <p class="text-indigo-100 text-sm opacity-90">Isi data dengan lengkap</p>
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

            <form action="{{ route('admin.guru.store') }}" method="POST">
                @csrf

                <!-- GRID RESPONSIVE -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- NIP -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">NIP <span class="text-red-500">*</span></label>
                        <input type="text" name="nip" value="{{ old('nip') }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nip') border-red-500 @enderror"
                            placeholder="1234567890123456">
                        @error('nip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- NAMA -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nama') border-red-500 @enderror"
                            placeholder="Budi Santoso">
                        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email Login <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror"
                            placeholder="guru@sekolah.test">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required minlength="6"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- KONFIRMASI PASSWORD -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- TELEPON -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Telepon</label>
                        <input type="text" name="telepon" value="{{ old('telepon') }}"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="081234567890">
                    </div>

                    <!-- MAPEL MENGAJAR — MULTI SELECT (MANY-TO-MANY) -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 mb-3">
                            Mata Pelajaran yang Diajar <span class="text-red-500">*</span>
                        </label>
                        <div class="bg-gray-50 rounded-xl border border-gray-200 p-5 max-h-64 overflow-y-auto">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($mapels as $mapel)
                                    <label class="flex items-center space-x-3 cursor-pointer hover:bg-indigo-50 rounded-lg p-3 transition">
                                        <input type="checkbox" name="mapel_id[]" value="{{ $mapel->id }}"
                                            class="w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 border-gray-300">
                                        <span class="font-medium text-gray-800">
                                            {{ $mapel->kode }} - {{ $mapel->nama_mapel }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
                            Centang semua mapel yang diajar guru ini
                        </p>
                        @error('mapel_id') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- ALAMAT — FULL WIDTH -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Alamat</label>
                        <textarea name="alamat" rows="4"
                            class="w-full px-4 py-3 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Jl. Contoh No. 123, Jakarta">{{ old('alamat') }}</textarea>
                    </div>

                </div>

                <!-- BUTTON -->
                <div class="mt-8 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition">
                        <i data-lucide="save" class="w-5 h-5 inline mr-2"></i>
                        Simpan Guru
                    </button>
                    <a href="{{ route('admin.guru.index') }}"
                        class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection