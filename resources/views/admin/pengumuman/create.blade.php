{{-- resources/views/admin/pengumuman/create.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Tambah Pengumuman')

@section('content')
<div class="max-w-4xl mx-auto">

    <!-- CARD UTAMA -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

        <!-- HEADER GRADIENT -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-5 text-white">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3">
                    <i data-lucide="megaphone" class="w-7 h-7"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Tambah Pengumuman Baru</h2>
                    <p class="text-indigo-100 text-sm opacity-90">Buat pengumuman untuk seluruh siswa</p>
                </div>
            </div>
        </div>

        <!-- BODY -->
        <div class="p-5 md:p-7">

            <!-- ERROR ALERT -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="flex items-center gap-2">
                                <i data-lucide="alert-circle" class="w-4 h-4"></i> {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.pengumuman.store') }}" method="POST">
                @csrf

                <div class="space-y-6">

                    <!-- JUDUL -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Judul Pengumuman <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul') }}" required
                               class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('judul') border-red-500 @enderror"
                               placeholder="Contoh: Libur Nasional Idul Fitri 1446 H">
                        @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- ISI (TINYMCE) -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Isi Pengumuman <span class="text-red-500">*</span>
                        </label>
                        <textarea name="isi" id="isi-editor" rows="10"
                                  class="w-full text-sm border rounded-xl @error('isi') border-red-500 @enderror">{{ old('isi') }}</textarea>
                        @error('isi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- TANGGAL -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Tanggal <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', today()->format('Y-m-d')) }}" required
                                   class="w-full px-4 py-2.5 text-sm border rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('tanggal') border-red-500 @enderror">
                            @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- STATUS -->
                        <div class="flex items-center h-full">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="aktif" value="1"
                                       class="w-5 h-5 rounded text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                       {{ old('aktif', true) ? 'checked' : '' }}>
                                <span class="ml-3 text-sm font-medium text-gray-700">
                                    Aktif (tampil di dashboard siswa)
                                </span>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- TOMBOL -->
                <div class="mt-8 flex flex-col sm:flex-row-reverse gap-3">
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition flex items-center justify-center">
                        <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                        Simpan Pengumuman
                    </button>
                    <a href="{{ route('admin.pengumuman.index') }}"
                       class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        selector: '#isi-pengumuman',
        height: 650,
        menubar: true,
        license_key: 'gpl', 
        
        plugins: 'image link lists table code media fullscreen preview wordcount emoticons autolink',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | forecolor backcolor emoticons | fullscreen preview code',
        
        images_upload_url: '{{ route("admin.pengumuman.upload") }}',
        automatic_uploads: true,
        images_reuse_filename: true,
        paste_data_images: true,
        
        branding: false,
        promotion: false
    });
</script>
@endpush
@endsection