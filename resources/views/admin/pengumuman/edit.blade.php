{{-- resources/views/admin/pengumuman/edit.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Edit Pengumuman - ' . Str::limit($pengumuman->judul, 40))

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-center gap-3">
            <div class="bg-white/15 rounded-xl p-2.5">
                <i data-lucide="edit-3" class="w-5 h-5"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold">Edit pengumuman</h1>
                <p class="text-blue-100 text-sm mt-0.5">Perbarui informasi pengumuman</p>
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

        <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="space-y-5">

                {{-- JUDUL --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Judul pengumuman <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul', $pengumuman->judul) }}" required
                           placeholder="Judul pengumuman..."
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  transition @error('judul') border-red-400 bg-red-50 @enderror">
                    @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- GAMBAR THUMBNAIL --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Gambar thumbnail
                        <span class="text-gray-400 font-normal">(opsional, maks. 2MB)</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-5 text-center
                                hover:border-blue-400 transition cursor-pointer relative"
                         id="drop-area"
                         onclick="document.getElementById('gambar-input').click()">
                        <div id="preview-wrap" class="{{ $pengumuman->gambar ? '' : 'hidden' }} mb-3">
                            <img id="gambar-preview"
                                 src="{{ $pengumuman->gambar ? Storage::url($pengumuman->gambar) : '#' }}"
                                 alt="Preview"
                                 class="max-h-48 mx-auto rounded-xl object-cover">
                        </div>
                        <div id="upload-placeholder" class="{{ $pengumuman->gambar ? 'hidden' : '' }}">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-2">
                                <i data-lucide="image-plus" class="w-5 h-5 text-blue-500"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-700">Klik untuk upload gambar</p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP — maks. 2MB</p>
                        </div>
                        <input type="file" name="gambar" id="gambar-input"
                               accept="image/png,image/jpeg,image/webp"
                               class="hidden">
                    </div>
                    <button type="button" id="hapus-gambar"
                            class="{{ $pengumuman->gambar ? '' : 'hidden' }} mt-2 text-xs text-red-500 hover:text-red-700 font-medium flex items-center gap-1">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                        Hapus gambar
                    </button>
                    {{-- Flag untuk hapus gambar existing --}}
                    <input type="hidden" name="hapus_gambar" id="hapus-gambar-flag" value="0">
                    @error('gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- ISI (TINYMCE) --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        Isi pengumuman <span class="text-red-500">*</span>
                    </label>
                    <textarea name="isi" id="isi-editor" rows="10"
                              class="w-full text-sm border border-gray-200 rounded-xl
                                     @error('isi') border-red-400 @enderror">{{ old('isi', $pengumuman->isi) }}</textarea>
                    @error('isi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- TANGGAL & STATUS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                            Tanggal <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal"
                               value="{{ old('tanggal', $pengumuman->tanggal->format('Y-m-d')) }}" required
                               class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                      transition @error('tanggal') border-red-400 bg-red-50 @enderror">
                        @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-center">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="aktif" value="1"
                                   class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-gray-300"
                                   {{ old('aktif', $pengumuman->aktif) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700">
                                Aktif (tampil di dashboard siswa)
                            </span>
                        </label>
                    </div>
                </div>

            </div>

            {{-- TOMBOL --}}
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 mt-6">
                <a href="{{ route('admin.pengumuman.index') }}"
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
                    Update pengumuman
                </button>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        selector: '#isi-editor',
        height: 400,
        menubar: true,
        license_key: 'gpl',
        plugins: 'image link lists table code media fullscreen preview wordcount emoticons autolink',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | forecolor backcolor emoticons | fullscreen preview code',
        images_upload_url: '{{ route("admin.pengumuman.upload") }}',
        automatic_uploads: true,
        images_reuse_filename: true,
        paste_data_images: true,
        branding: false,
        promotion: false,
        skin: 'oxide',
        content_css: 'default',
    });

    const input       = document.getElementById('gambar-input');
    const preview     = document.getElementById('gambar-preview');
    const previewWrap = document.getElementById('preview-wrap');
    const placeholder = document.getElementById('upload-placeholder');
    const hapusBtn    = document.getElementById('hapus-gambar');
    const hapusFlag   = document.getElementById('hapus-gambar-flag');

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran gambar maksimal 2MB.');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            previewWrap.classList.remove('hidden');
            placeholder.classList.add('hidden');
            hapusBtn.classList.remove('hidden');
            hapusFlag.value = '0';
        };
        reader.readAsDataURL(file);
    });

    hapusBtn.addEventListener('click', function () {
        input.value = '';
        preview.src = '#';
        previewWrap.classList.add('hidden');
        placeholder.classList.remove('hidden');
        hapusBtn.classList.add('hidden');
        hapusFlag.value = '1';
    });

    const dropArea = document.getElementById('drop-area');
    dropArea.addEventListener('dragover', e => { e.preventDefault(); dropArea.classList.add('border-blue-400'); });
    dropArea.addEventListener('dragleave', () => dropArea.classList.remove('border-blue-400'));
    dropArea.addEventListener('drop', e => {
        e.preventDefault();
        dropArea.classList.remove('border-blue-400');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
            input.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush
@endsection