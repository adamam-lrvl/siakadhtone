{{-- resources/views/admin/siswa/edit.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Edit Siswa - ' . $siswa->nama)

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
                <i data-lucide="edit-3" class="w-5 h-5 text-white"></i>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-white tracking-tight">Edit siswa</h1>
                <p class="text-blue-200 dark:text-white/40 text-sm mt-0.5">Perbarui data {{ $siswa->nama }}</p>
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

        <form action="{{ route('admin.siswa.update', $siswa) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                @php
                $ic = "w-full px-4 py-2.5 text-sm rounded-xl transition bg-white dark:bg-white/[0.06] text-gray-900 dark:text-white/90 border border-gray-200 dark:border-white/[0.10] placeholder-gray-400 dark:placeholder-white/25 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-indigo-400/50";
                $lc = "block text-xs font-semibold text-gray-600 dark:text-white/40 mb-1.5";
                @endphp

                <div>
                    <label class="{{ $lc }}">NIS <span class="text-red-500">*</span></label>
                    <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" required placeholder="123456"
                           class="{{ $ic }} @error('nis') border-red-400 @enderror">
                    @error('nis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $lc }}">Nama lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}" required placeholder="Budi Santoso"
                           class="{{ $ic }} @error('nama') border-red-400 @enderror">
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $lc }}">Email login <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $siswa->user->email) }}" placeholder="siswa@sekolah.com"
                           class="{{ $ic }} @error('email') border-red-400 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $lc }}">Jenis kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" required class="{{ $ic }} @error('jenis_kelamin') border-red-400 @enderror">
                        <option value="">-- Pilih jenis kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $lc }}">Tanggal lahir</label>
                    <input type="date" name="tanggal_lahir"
                           value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '') }}"
                           class="{{ $ic }}">
                </div>

                <div>
                    <label class="{{ $lc }}">Kelas <span class="text-red-500">*</span></label>
                    <select name="kelas_id" required class="{{ $ic }} @error('kelas_id') border-red-400 @enderror">
                        <option value="">-- Pilih kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $lc }}">Telepon siswa</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $siswa->telepon) }}" placeholder="081234567890" class="{{ $ic }}">
                </div>

                <div>
                    <label class="{{ $lc }}">Telepon wali murid</label>
                    <input type="text" name="telepon_wali" value="{{ old('telepon_wali', $siswa->telepon_wali) }}" placeholder="081234567890" class="{{ $ic }}">
                </div>

                <div>
                    <label class="{{ $lc }}">Password baru <span class="text-gray-400 dark:text-white/25 font-normal">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" minlength="6" placeholder="Min. 6 karakter"
                           class="{{ $ic }} @error('password') border-red-400 @enderror">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $lc }}">Konfirmasi password baru</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="{{ $ic }}">
                </div>

                <div class="md:col-span-2">
                    <label class="{{ $lc }}">Alamat</label>
                    <textarea name="alamat" rows="3" placeholder="Jl. Contoh No. 123, Jakarta"
                              class="{{ $ic }} resize-none">{{ old('alamat', $siswa->alamat) }}</textarea>
                </div>

            </div>

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
                    Update siswa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection