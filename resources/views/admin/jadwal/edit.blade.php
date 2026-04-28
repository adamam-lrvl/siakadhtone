@extends('admin.layouts.admin')

@section('title', 'Edit Jadwal - ' . $jadwal->mapel->nama_mapel)

@section('content')
<div class="max-w-3xl mx-auto">

    <!-- CARD UTAMA -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

        <!-- HEADER -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-5 text-white">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                    <i data-lucide="edit-3" class="w-7 h-7"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Edit Jadwal Pelajaran</h2>
                    <p class="text-indigo-100 text-sm opacity-90">
                        Perbarui jadwal {{ $jadwal->mapel->nama_mapel }}
                    </p>
                </div>
            </div>
        </div>

        <!-- BODY -->
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

            <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- KELAS -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Kelas
                        </label>
                        <select name="kelas_id" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                   @error('kelas_id') border-red-500 @enderror">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" 
                                    {{ $jadwal->kelas_id == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- MAPEL -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Mata Pelajaran
                        </label>
                        <select name="mapel_id" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                   @error('mapel_id') border-red-500 @enderror">
                            <option value="">-- Pilih Mapel --</option>
                            @foreach($mapels as $m)
                                <option value="{{ $m->id }}" 
                                    {{ $jadwal->mapel_id == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                        @error('mapel_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- GURU -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Guru Pengajar
                        </label>
                        <select name="guru_id" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                   @error('guru_id') border-red-500 @enderror">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($gurus as $g)
                                <option value="{{ $g->id }}" 
                                    {{ $jadwal->guru_id == $g->id ? 'selected' : '' }}>
                                    {{ $g->nama }} ({{ $g->nip }})
                                </option>
                            @endforeach
                        </select>
                        @error('guru_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- HARI -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Hari
                        </label>
                        <select name="hari" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                   @error('hari') border-red-500 @enderror">
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                                <option value="{{ $h }}" 
                                    {{ $jadwal->hari == $h ? 'selected' : '' }}>
                                    {{ $h }}
                                </option>
                            @endforeach
                        </select>
                        @error('hari') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- JAM MULAI -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Jam Mulai
                        </label>
                        <input type="time" name="jam_mulai" 
                            value="{{ $jadwal->jam_mulai }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                   @error('jam_mulai') border-red-500 @enderror">
                        @error('jam_mulai') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- JAM SELESAI -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Jam Selesai
                        </label>
                        <input type="time" name="jam_selesai" 
                            value="{{ $jadwal->jam_selesai }}" required
                            class="w-full px-4 py-2.5 text-sm border rounded-xl 
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                   @error('jam_selesai') border-red-500 @enderror">
                        @error('jam_selesai') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>

                <!-- BUTTON AREA -->
                <div class="mt-8 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 
                               text-white font-semibold rounded-xl shadow-lg 
                               hover:shadow-xl transform hover:-translate-y-0.5 transition">
                        <i data-lucide="save" class="w-5 h-5 inline mr-2"></i>
                        Update Jadwal
                    </button>

                    <a href="{{ route('admin.jadwal.index') }}"
                        class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl 
                               hover:bg-gray-200 transition text-center">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
