{{-- resources/views/admin/guru/edit.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Edit Guru - ' . $guru->nama)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="relative rounded-2xl overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)]"></div>
        <div class="relative p-6 flex items-center gap-3">
            <div class="bg-white/15 backdrop-blur-sm border border-white/20 rounded-xl p-2.5">
                <i data-lucide="edit-3" class="w-5 h-5 text-white"></i>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-white tracking-tight">Edit guru</h1>
                <p class="text-blue-200 text-sm mt-0.5">Perbarui data {{ $guru->nama }}</p>
            </div>
        </div>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-5 md:p-6">

        @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800
                        rounded-xl text-red-700 dark:text-red-300 text-sm">
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

        <form action="{{ route('admin.guru.update', $guru) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- NIP --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                        NIP <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}" required
                           placeholder="1234567890123456"
                           class="w-full px-4 py-2.5 text-sm rounded-xl transition
                                  bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                  border border-gray-200 dark:border-gray-700
                                  focus:outline-none focus:ring-2 focus:ring-blue-500
                                  @error('nip') border-red-400 bg-red-50 dark:bg-red-950 @enderror">
                    @error('nip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- NAMA --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                        Nama lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama', $guru->nama) }}" required
                           placeholder="Budi Santoso"
                           class="w-full px-4 py-2.5 text-sm rounded-xl transition
                                  bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                  border border-gray-200 dark:border-gray-700
                                  focus:outline-none focus:ring-2 focus:ring-blue-500
                                  @error('nama') border-red-400 bg-red-50 dark:bg-red-950 @enderror">
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                        Email login <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $guru->email) }}" required
                           placeholder="guru@sekolah.test"
                           class="w-full px-4 py-2.5 text-sm rounded-xl transition
                                  bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                  border border-gray-200 dark:border-gray-700
                                  focus:outline-none focus:ring-2 focus:ring-blue-500
                                  @error('email') border-red-400 bg-red-50 dark:bg-red-950 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- TELEPON --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $guru->telepon) }}"
                           placeholder="081234567890"
                           class="w-full px-4 py-2.5 text-sm rounded-xl transition
                                  bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                  border border-gray-200 dark:border-gray-700
                                  focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                        Password baru
                        <span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span>
                    </label>
                    <input type="password" name="password" minlength="6"
                           placeholder="Min. 6 karakter"
                           class="w-full px-4 py-2.5 text-sm rounded-xl transition
                                  bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                  border border-gray-200 dark:border-gray-700
                                  focus:outline-none focus:ring-2 focus:ring-blue-500
                                  @error('password') border-red-400 bg-red-50 dark:bg-red-950 @enderror">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- KONFIRMASI PASSWORD --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                        Konfirmasi password baru
                    </label>
                    <input type="password" name="password_confirmation"
                           placeholder="Ulangi password baru"
                           class="w-full px-4 py-2.5 text-sm rounded-xl transition
                                  bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                  border border-gray-200 dark:border-gray-700
                                  focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- MAPEL --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-2">
                        Mata pelajaran yang diajar <span class="text-red-500">*</span>
                    </label>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700
                                p-4 max-h-52 overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach($mapels as $mapel)
                                <label class="flex items-center gap-3 cursor-pointer px-3 py-2.5
                                              rounded-xl transition
                                              hover:bg-indigo-50 dark:hover:bg-indigo-950/50
                                              {{ $guru->mapels->contains($mapel->id) ? 'bg-indigo-50 dark:bg-indigo-950/40' : '' }}">
                                    <input type="checkbox" name="mapel_id[]" value="{{ $mapel->id }}"
                                           {{ $guru->mapels->contains($mapel->id) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 rounded border-gray-300 dark:border-gray-600
                                                  focus:ring-blue-500 flex-shrink-0">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        <span class="font-medium">{{ $mapel->kode }}</span>
                                        — {{ $mapel->nama_mapel }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1">
                        <i data-lucide="info" class="w-3.5 h-3.5"></i>
                        Centang mapel yang diajar, uncheck untuk hapus
                    </p>
                    @error('mapel_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- ALAMAT --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">Alamat</label>
                    <textarea name="alamat" rows="3"
                              placeholder="Jl. Contoh No. 123, Jakarta"
                              class="w-full px-4 py-2.5 text-sm rounded-xl transition resize-none
                                     bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                     border border-gray-200 dark:border-gray-700
                                     focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat', $guru->alamat) }}</textarea>
                </div>

            </div>

            {{-- TOMBOL --}}
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 mt-6 pt-5
                        border-t border-gray-100 dark:border-gray-800">
                <a href="{{ route('admin.guru.index') }}"
                   class="px-5 py-2.5 border-2 border-gray-200 dark:border-gray-700 rounded-xl
                          text-gray-600 dark:text-gray-400 font-semibold text-sm
                          hover:bg-gray-50 dark:hover:bg-gray-800 transition
                          flex items-center justify-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-xl
                               font-bold text-sm transition flex items-center justify-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Update guru
                </button>
            </div>
        </form>
    </div>
</div>
@endsection