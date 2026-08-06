{{-- resources/views/admin/siswa/create.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Tambah Siswa')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:border dark:border-white/[0.09]
                dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="relative p-6 flex items-center gap-3">
            <div class="bg-white/15 backdrop-blur-sm border border-white/20 rounded-xl p-2.5">
                <i data-lucide="user-plus" class="w-5 h-5 text-white"></i>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-white tracking-tight">Tambah siswa baru</h1>
                <p class="text-blue-200 dark:text-white/40 text-sm mt-0.5">Isi data siswa dengan lengkap termasuk akun login</p>
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] p-5 md:p-6">

        @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-xl text-red-700 dark:text-red-300 text-sm">
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

                @php
                $inputClass = "w-full px-4 py-2.5 text-sm rounded-xl transition
                               bg-white dark:bg-white/[0.06] text-gray-900 dark:text-white/90
                               border border-gray-200 dark:border-white/[0.10]
                               placeholder-gray-400 dark:placeholder-white/25
                               focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-indigo-400/50";
                $labelClass = "block text-xs font-semibold text-gray-600 dark:text-white/40 mb-1.5";
                @endphp

                <div>
                    <label class="{{ $labelClass }}">NIS <span class="text-red-500">*</span></label>
                    <input type="text" name="nis" value="{{ old('nis') }}" required placeholder="2023001"
                           class="{{ $inputClass }} @error('nis') border-red-400 dark:border-red-500/50 @enderror">
                    @error('nis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Nama lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Andi Pratama"
                           class="{{ $inputClass }} @error('nama') border-red-400 dark:border-red-500/50 @enderror">
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Email login <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="siswa@sekolah.com"
                           class="{{ $inputClass }} @error('email') border-red-400 dark:border-red-500/50 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Jenis kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" required
                            class="{{ $inputClass }} @error('jenis_kelamin') border-red-400 dark:border-red-500/50 @enderror">
                        <option value="">-- Pilih jenis kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required minlength="6" placeholder="Min. 6 karakter"
                           class="{{ $inputClass }} @error('password') border-red-400 dark:border-red-500/50 @enderror">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Konfirmasi password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password"
                           class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="{{ $labelClass }}">Kelas <span class="text-red-500">*</span></label>
                    <select name="kelas_id" required
                            class="{{ $inputClass }} @error('kelas_id') border-red-400 dark:border-red-500/50 @enderror">
                        <option value="">-- Pilih kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Tanggal lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                           class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="{{ $labelClass }}">Telepon siswa</label>
                    <input type="text" name="telepon" value="{{ old('telepon') }}" placeholder="08123456789"
                           class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="{{ $labelClass }}">Telepon wali murid</label>
                    <input type="text" name="telepon_wali" value="{{ old('telepon_wali') }}" placeholder="08198765432"
                           class="{{ $inputClass }}">
                </div>

                <div class="md:col-span-2">
                    <label class="{{ $labelClass }}">Alamat</label>
                    <textarea name="alamat" rows="3" placeholder="Jl. Contoh No. 123, Jakarta"
                              class="{{ $inputClass }} resize-none">{{ old('alamat') }}</textarea>
                </div>

            </div>

            {{-- TOMBOL --}}
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 mt-6 pt-5 border-t border-gray-100 dark:border-white/[0.07]">
                <a href="{{ route('admin.siswa.index') }}"
                   class="px-5 py-2.5 border-2 border-gray-200 dark:border-white/[0.10] rounded-xl
                          text-gray-600 dark:text-white/50 font-semibold text-sm
                          hover:bg-gray-50 dark:hover:bg-white/[0.07] transition
                          flex items-center justify-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-xl
                               font-bold text-sm transition flex items-center justify-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan siswa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection