{{-- resources/views/admin/siswa/create.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Tambah Siswa')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-center gap-3">
            <div class="bg-white/15 rounded-xl p-2.5">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold">Tambah siswa baru</h1>
                <p class="text-blue-100 text-sm mt-0.5">Isi data siswa dengan lengkap termasuk akun login</p>
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-5 md:p-6">

        @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="flex items-center gap-2">
                            <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.siswa.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- NIS --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        NIS <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nis" value="{{ old('nis') }}" required
                           placeholder="2023001"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  transition @error('nis') border-red-400 bg-red-50 @enderror">
                    @error('nis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- NAMA --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Nama lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                           placeholder="Andi Pratama"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  transition @error('nama') border-red-400 bg-red-50 @enderror">
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Email login <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="siswa@sekolah.com"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  transition @error('email') border-red-400 bg-red-50 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- JENIS KELAMIN --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Jenis kelamin <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis_kelamin" required
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                   transition @error('jenis_kelamin') border-red-400 bg-red-50 @enderror">
                        <option value="">-- Pilih jenis kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" required minlength="6"
                           placeholder="Min. 6 karakter"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  transition @error('password') border-red-400 bg-red-50 @enderror">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- KONFIRMASI PASSWORD --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Konfirmasi password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" required
                           placeholder="Ulangi password"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                {{-- KELAS --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Kelas <span class="text-red-500">*</span>
                    </label>
                    <select name="kelas_id" required
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                   transition @error('kelas_id') border-red-400 bg-red-50 @enderror">
                        <option value="">-- Pilih kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- TANGGAL LAHIR --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Tanggal lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                {{-- TELEPON SISWA --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Telepon siswa</label>
                    <input type="text" name="telepon" value="{{ old('telepon') }}"
                           placeholder="08123456789"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                {{-- TELEPON WALI --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Telepon wali murid</label>
                    <input type="text" name="telepon_wali" value="{{ old('telepon_wali') }}"
                           placeholder="08198765432"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                {{-- ALAMAT --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Alamat</label>
                    <textarea name="alamat" rows="3"
                              placeholder="Jl. Contoh No. 123, Jakarta"
                              class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                     focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                     transition resize-none">{{ old('alamat') }}</textarea>
                </div>

            </div>

            {{-- TOMBOL --}}
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 mt-6">
                <a href="{{ route('admin.siswa.index') }}"
                   class="px-5 py-2.5 border border-gray-200 rounded-xl text-gray-700 font-semibold
                          text-sm hover:bg-gray-50 hover:border-gray-300 transition
                          flex items-center justify-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600
                               hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl
                               font-semibold text-sm shadow-sm hover:shadow-md transition
                               flex items-center justify-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan siswa
                </button>
            </div>

        </form>
    </div>
</div>
@endsection