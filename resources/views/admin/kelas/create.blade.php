{{-- resources/views/admin/kelas/create.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Tambah Kelas')

@section('content')
<div class="max-w-2xl mx-auto">

    <!-- CARD UTAMA — SAMA PERSIS KAYAK SISWA & GURU -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

        <!-- HEADER INDIGO → PURPLE PREMIUM -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-5 text-white">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                    <i data-lucide="plus-circle" class="w-7 h-7"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Tambah Kelas Baru</h2>
                    <p class="text-indigo-100 text-sm opacity-90">Isi data kelas dengan lengkap</p>
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

            <form action="{{ route('admin.kelas.store') }}" method="POST">
                @csrf

                <div class="space-y-5">

                    <!-- KODE KELAS -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Kode Kelas <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kode_kelas" value="{{ old('kode_kelas') }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kode_kelas') border-red-500 @enderror"
                            placeholder="Contoh: X-RPL-1">
                        @error('kode_kelas') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- NAMA KELAS -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Nama Kelas <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_kelas" value="{{ old('nama_kelas') }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nama_kelas') border-red-500 @enderror"
                            placeholder="Contoh: Kelas 10 RPL 1">
                        @error('nama_kelas') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- WALI KELAS -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Wali Kelas</label>
                        <select name="wali_kelas_id"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Pilih Wali Kelas --</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ old('wali_kelas_id') == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama }} ({{ $guru->nip }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- TOMBOL — SAMA PERSIS -->
                <div class="mt-8 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition">
                        <i data-lucide="save" class="w-5 h-5 inline mr-2"></i>
                        Simpan Kelas
                    </button>
                    <a href="{{ route('admin.kelas.index') }}"
                        class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection