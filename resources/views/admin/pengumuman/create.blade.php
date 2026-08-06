{{-- resources/views/admin/pengumuman/create.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Tambah Pengumuman')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:border dark:border-white/[0.09]
                dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="relative p-6 flex items-center gap-3">
            <div class="bg-white/15 backdrop-blur-sm border border-white/20 rounded-xl p-2.5">
                <i data-lucide="megaphone" class="w-5 h-5 text-white"></i>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-white tracking-tight">Tambah pengumuman baru</h1>
                <p class="text-blue-200 dark:text-white/40 text-sm mt-0.5">Buat pengumuman untuk seluruh siswa</p>
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] p-5 md:p-6">

        @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-xl text-red-700 dark:text-red-300 text-sm">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="flex items-center gap-2"><i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
        $ic = "w-full px-4 py-2.5 text-sm rounded-xl transition bg-white dark:bg-white/[0.06] text-gray-900 dark:text-white/90 border border-gray-200 dark:border-white/[0.10] placeholder-gray-400 dark:placeholder-white/25 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-indigo-400/50";
        $lc = "block text-xs font-semibold text-gray-600 dark:text-white/40 mb-1.5";
        @endphp

        <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-5">

                <div>
                    <label class="{{ $lc }}">Judul pengumuman <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required
                           placeholder="Contoh: Libur Nasional Idul Fitri 1446 H"
                           class="{{ $ic }} @error('judul') border-red-400 @enderror">
                    @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- UPLOAD GAMBAR --}}
                <div>
                    <label class="{{ $lc }}">Gambar thumbnail <span class="text-gray-400 dark:text-white/25 font-normal">(opsional, maks. 2MB)</span></label>
                    <div class="border-2 border-dashed border-gray-200 dark:border-white/[0.10] rounded-xl p-5 text-center
                                hover:border-blue-400 dark:hover:border-indigo-400/50 transition cursor-pointer
                                bg-transparent dark:bg-white/[0.03]"
                         id="drop-area" onclick="document.getElementById('gambar-input').click()">
                        <div id="preview-wrap" class="hidden mb-3">
                            <img id="gambar-preview" src="#" alt="Preview" class="max-h-48 mx-auto rounded-xl object-cover">
                        </div>
                        <div id="upload-placeholder">
                            <div class="w-10 h-10 bg-blue-50 dark:bg-blue-500/15 rounded-xl flex items-center justify-center mx-auto mb-2">
                                <i data-lucide="image-plus" class="w-5 h-5 text-blue-500 dark:text-blue-400"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-700 dark:text-white/60">Klik untuk upload gambar</p>
                            <p class="text-xs text-gray-400 dark:text-white/30 mt-1">PNG, JPG, WEBP — maks. 2MB</p>
                        </div>
                        <input type="file" name="gambar" id="gambar-input" accept="image/png,image/jpeg,image/webp" class="hidden">
                    </div>
                    <button type="button" id="hapus-gambar"
                            class="hidden mt-2 text-xs text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium flex items-center gap-1">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus gambar
                    </button>
                    @error('gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- ISI TINYMCE --}}
                <div>
                    <label class="{{ $lc }}">Isi pengumuman <span class="text-red-500">*</span></label>
                    <textarea name="isi" id="isi-editor" rows="10"
                              class="w-full text-sm border border-gray-200 dark:border-white/[0.10] rounded-xl @error('isi') border-red-400 @enderror">{{ old('isi') }}</textarea>
                    @error('isi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="{{ $lc }}">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', today()->format('Y-m-d')) }}" required
                               class="{{ $ic }} @error('tanggal') border-red-400 @enderror">
                        @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-center">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="aktif" value="1"
                                   class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-white/[0.20]"
                                   {{ old('aktif', true) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700 dark:text-white/70">
                                Aktif (tampil di dashboard siswa)
                            </span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 mt-6 pt-5 border-t border-gray-100 dark:border-white/[0.07]">
                <a href="{{ route('admin.pengumuman.index') }}"
                   class="px-5 py-2.5 border-2 border-gray-200 dark:border-white/[0.10] rounded-xl text-gray-600 dark:text-white/50 font-semibold text-sm hover:bg-gray-50 dark:hover:bg-white/[0.07] transition flex items-center justify-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-xl font-bold text-sm transition flex items-center justify-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan pengumuman
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<script>
    const isDark = document.documentElement.classList.contains('dark');
    tinymce.init({
        selector: '#isi-editor', height: 400, menubar: true, license_key: 'gpl',
        plugins: 'image link lists table code media fullscreen preview wordcount emoticons autolink',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | forecolor backcolor emoticons | fullscreen preview code',
        images_upload_url: '{{ route("admin.pengumuman.upload") }}',
        automatic_uploads: true, images_reuse_filename: true, paste_data_images: true,
        branding: false, promotion: false,
        skin: isDark ? 'oxide-dark' : 'oxide',
        content_css: isDark ? 'dark' : 'default',
    });

    const input = document.getElementById('gambar-input');
    const preview = document.getElementById('gambar-preview');
    const previewWrap = document.getElementById('preview-wrap');
    const placeholder = document.getElementById('upload-placeholder');
    const hapusBtn = document.getElementById('hapus-gambar');

    input.addEventListener('change', function() {
        const file = this.files[0]; if (!file) return;
        if (file.size > 2 * 1024 * 1024) { alert('Ukuran gambar maksimal 2MB.'); this.value = ''; return; }
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; previewWrap.classList.remove('hidden'); placeholder.classList.add('hidden'); hapusBtn.classList.remove('hidden'); };
        reader.readAsDataURL(file);
    });
    hapusBtn.addEventListener('click', function() {
        input.value = ''; preview.src = '#'; previewWrap.classList.add('hidden'); placeholder.classList.remove('hidden'); hapusBtn.classList.add('hidden');
    });
    const dropArea = document.getElementById('drop-area');
    dropArea.addEventListener('dragover', e => { e.preventDefault(); dropArea.classList.add('border-blue-400'); });
    dropArea.addEventListener('dragleave', () => dropArea.classList.remove('border-blue-400'));
    dropArea.addEventListener('drop', e => {
        e.preventDefault(); dropArea.classList.remove('border-blue-400');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) { const dt = new DataTransfer(); dt.items.add(file); input.files = dt.files; input.dispatchEvent(new Event('change')); }
    });
</script>
@endpush
@endsection