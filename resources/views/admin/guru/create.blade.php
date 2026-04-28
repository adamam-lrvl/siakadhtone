{{-- resources/views/admin/guru/create.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Tambah Guru Baru')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-center gap-3">
            <div class="bg-white/15 rounded-xl p-2.5">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold">Tambah guru baru</h1>
                <p class="text-blue-100 text-sm mt-0.5">Isi data dengan lengkap</p>
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

        <form action="{{ route('admin.guru.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- NIP --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        NIP <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nip" value="{{ old('nip') }}" required
                           placeholder="1234567890123456"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  transition @error('nip') border-red-400 bg-red-50 @enderror">
                    @error('nip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- NAMA --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Nama lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                           placeholder="Budi Santoso"
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
                           placeholder="guru@sekolah.test"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  transition @error('email') border-red-400 bg-red-50 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- TELEPON --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon') }}"
                           placeholder="081234567890"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
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

                {{-- MAPEL --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-2">
                        Mata pelajaran yang diajar <span class="text-red-500">*</span>
                    </label>
                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-4 max-h-52 overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach($mapels as $mapel)
                                <label class="flex items-center gap-3 cursor-pointer px-3 py-2.5
                                              rounded-xl hover:bg-indigo-50 transition">
                                    <input type="checkbox" name="mapel_id[]" value="{{ $mapel->id }}"
                                           class="w-4 h-4 text-blue-600 rounded border-gray-300
                                                  focus:ring-blue-500 flex-shrink-0">
                                    <span class="text-sm text-gray-700">
                                        <span class="font-medium">{{ $mapel->kode }}</span>
                                        — {{ $mapel->nama_mapel }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1">
                        <i data-lucide="info" class="w-3.5 h-3.5"></i>
                        Centang semua mapel yang diajar guru ini
                    </p>
                    @error('mapel_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
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
                <a href="{{ route('admin.guru.index') }}"
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
                    Simpan guru
                </button>
            </div>

        </form>
    </div>
</div>
@endsection