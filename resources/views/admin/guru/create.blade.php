{{-- resources/views/admin/guru/create.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Tambah Guru')

@section('content')
<div class="max-w-2xl mx-auto">

    <!-- CARD UTAMA — LEBIH RAMPING -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

        <!-- HEADER BIRU PREMIUM -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-5 text-white">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                    <i data-lucide="user-plus" class="w-7 h-7"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Tambah Guru Baru</h2>
                    <p class="text-blue-100 text-sm opacity-90">Isi data dengan lengkap</p>
                </div>
            </div>
        </div>

        <!-- BODY FORM -->
        <div class="p-5 md:p-7">

            <!-- ERROR ALERT — LEBIH KECIL & CANTIK -->
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

                <!-- GRID 1 KOLOM DI HP, 2 KOLOM DI TABLET+ -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- NIP -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">NIP <span class="text-red-500">*</span></label>
                        <input type="text" name="nip" value="{{ old('nip') }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nip') border-red-500 @enderror"
                            placeholder="123456789">
                        @error('nip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- NAMA -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama') border-red-500 @enderror"
                            placeholder="Budi Santoso">
                        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email Login <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                            placeholder="guru@sekolah.com">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required minlength="6"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                            placeholder="Min. 6 karakter">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- KONFIRMASI PASSWORD -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- TELEPON -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Telepon</label>
                        <input type="text" name="telepon" value="{{ old('telepon') }}"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="08123456789">
                    </div>

                    <!-- MAPEL -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Mata Pelajaran</label>
                        <select name="mapel_id"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Mapel --</option>
                            @foreach(\App\Models\Mapel::all() as $m)
                                <option value="{{ $m->id }}" {{ old('mapel_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- ALAMAT — FULL WIDTH -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Alamat</label>
                        <textarea name="alamat" rows="3"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Jl. Contoh No. 123">{{ old('alamat') }}</textarea>
                    </div>

                </div>

                <!-- TOMBOL — LEBIH RAPIH -->
                <div class="mt-8 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition">
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