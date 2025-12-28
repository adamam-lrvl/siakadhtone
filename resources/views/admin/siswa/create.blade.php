{{-- resources/views/admin/siswa/create.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Tambah Siswa')

@section('content')
<div class="max-w-2xl mx-auto">

    <!-- CARD UTAMA -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

        <!-- HEADER INDIGO GRADIENT PREMIUM -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-5 text-white">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                    <i data-lucide="user-plus" class="w-7 h-7"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Tambah Siswa Baru</h2>
                    <p class="text-indigo-100 text-sm opacity-90">Isi data siswa dengan lengkap termasuk akun login</p>
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

            <form action="{{ route('admin.siswa.store') }}" method="POST">
                @csrf

                <!-- GRID 1 KOLOM HP, 2 KOLOM TABLET+ -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- NIS -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">NIS <span class="text-red-500">*</span></label>
                        <input type="text" name="nis" value="{{ old('nis') }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nis') border-red-500 @enderror"
                            placeholder="2023001">
                        @error('nis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- NAMA -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nama') border-red-500 @enderror"
                            placeholder="Andi Pratama">
                        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- EMAIL LOGIN — BARU -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email Login <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror"
                            placeholder="siswa@sekolah.com">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- PASSWORD — BARU -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required minlength="6"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror"
                            placeholder="Min. 6 karakter">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- KONFIRMASI PASSWORD — BARU -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- JENIS KELAMIN -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="jenis_kelamin" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('jenis_kelamin') border-red-500 @enderror">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- TANGGAL LAHIR -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- TELEPON SISWA -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Telepon Siswa</label>
                        <input type="text" name="telepon" value="{{ old('telepon') }}"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="08123456789">
                    </div>

                    <!-- TELEPON WALI MURID -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Telepon Wali Murid</label>
                        <input type="text" name="telepon_wali" value="{{ old('telepon_wali') }}"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="08198765432">
                    </div>

                    <!-- KELAS -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Kelas <span class="text-red-500">*</span></label>
                        <select name="kelas_id" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kelas_id') border-red-500 @enderror">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- ALAMAT — FULL WIDTH -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Alamat</label>
                        <textarea name="alamat" rows="3"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Jl. Contoh No. 123">{{ old('alamat') }}</textarea>
                    </div>

                </div>

                <!-- TOMBOL -->
                <div class="mt-8 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition">
                        <i data-lucide="save" class="w-5 h-5 inline mr-2"></i>
                        Simpan Siswa
                    </button>
                    <a href="{{ route('admin.siswa.index') }}"
                        class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection