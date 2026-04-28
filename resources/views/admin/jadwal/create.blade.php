@extends('admin.layouts.admin')

@section('title', 'Tambah Jadwal')

@section('content')
<div class="max-w-3xl mx-auto">

    <!-- CARD UTAMA -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

        <!-- HEADER -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-5 text-white">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                    <i data-lucide="calendar-plus" class="w-7 h-7"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Tambah Jadwal Pelajaran</h2>
                    <p class="text-indigo-100 text-sm opacity-90">Isi jadwal pelajaran dengan lengkap</p>
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

            <form action="{{ route('admin.jadwal.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- KELAS -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Kelas <span class="text-red-500">*</span>
                        </label>
                        <select name="kelas_id"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 
                                   focus:ring-indigo-500 focus:border-indigo-500 @error('kelas_id') border-red-500 @enderror">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- MAPEL -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Mata Pelajaran <span class="text-red-500">*</span>
                        </label>
                        <select name="mapel_id"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 
                                   focus:ring-indigo-500 focus:border-indigo-500 @error('mapel_id') border-red-500 @enderror">
                            <option value="">-- Pilih Mapel --</option>
                            @foreach($mapels as $m)
                                <option value="{{ $m->id }}" {{ old('mapel_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- GURU -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Guru Pengajar <span class="text-red-500">*</span>
                        </label>
                        <select name="guru_id"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 
                                   focus:ring-indigo-500 focus:border-indigo-500 @error('guru_id') border-red-500 @enderror">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($gurus as $g)
                                <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                    {{ $g->nama }} ({{ $g->nip }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- HARI -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Hari <span class="text-red-500">*</span>
                        </label>
                        <select name="hari"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 
                                   focus:ring-indigo-500 focus:border-indigo-500 @error('hari') border-red-500 @enderror">
                            <option value="">-- Pilih Hari --</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                                <option value="{{ $h }}" {{ old('hari') == $h ? 'selected' : '' }}>
                                    {{ $h }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- JAM MULAI -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Jam Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 
                                   focus:ring-indigo-500 focus:border-indigo-500 @error('jam_mulai') border-red-500 @enderror">
                    </div>

                    <!-- JAM SELESAI -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Jam Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 
                                   focus:ring-indigo-500 focus:border-indigo-500 @error('jam_selesai') border-red-500 @enderror">
                    </div>

                </div>

                <!-- BUTTON -->
                <div class="mt-8 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-semibold 
                               rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition flex items-center gap-2">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        Simpan Jadwal
                    </button>

                    <a href="{{ route('admin.jadwal.index') }}"
                        class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition text-center">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
