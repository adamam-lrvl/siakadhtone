{{-- resources/views/kepala-sekolah/activity-log/show.blade.php --}}
@extends('kepala-sekolah.layouts.app')
@section('title', 'Detail Activity Log')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <h1 class="text-2xl font-bold flex items-center gap-2">
            <i data-lucide="activity" class="w-6 h-6 flex-shrink-0"></i>
            Detail activity log
        </h1>
        <p class="text-blue-100 text-sm mt-1">
            {{ $activity->created_at->translatedFormat('l, d F Y H:i:s') }}
        </p>
    </div>

    {{-- INFO UTAMA --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Informasi aktivitas</p>
        </div>
        <div class="divide-y divide-gray-100">
            <div class="flex justify-between items-center px-5 py-3.5">
                <span class="text-xs text-gray-400">Deskripsi</span>
                <span class="text-sm font-semibold text-gray-900 text-right max-w-[60%]">
                    {{ $activity->description }}
                </span>
            </div>
            <div class="flex justify-between items-center px-5 py-3.5">
                <span class="text-xs text-gray-400">Dilakukan oleh</span>
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-900">
                        {{ $activity->causer->name ?? 'System' }}
                    </p>
                    @if($activity->causer)
                        <p class="text-xs text-gray-400">{{ $activity->causer->email }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs
                                     font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                            {{ $activity->causer->role }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="flex justify-between items-center px-5 py-3.5">
                <span class="text-xs text-gray-400">Jenis data</span>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                             bg-purple-50 text-purple-700 border border-purple-200">
                    {{ $activity->subject_type ? class_basename($activity->subject_type) : '—' }}
                </span>
            </div>
            <div class="flex justify-between items-center px-5 py-3.5">
                <span class="text-xs text-gray-400">ID data</span>
                <span class="text-sm font-semibold text-gray-900">
                    {{ $activity->subject_id ?? '—' }}
                </span>
            </div>
            <div class="flex justify-between items-center px-5 py-3.5">
                <span class="text-xs text-gray-400">Waktu</span>
                <span class="text-sm font-semibold text-gray-900">
                    {{ $activity->created_at->translatedFormat('d F Y, H:i:s') }}
                </span>
            </div>
        </div>
    </div>

    {{-- PROPERTIES (sebelum & sesudah) --}}
    @if($activity->properties && $activity->properties->isNotEmpty())
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Detail perubahan</p>
        </div>

        {{-- OLD VALUES --}}
        @if($activity->properties->get('old'))
        <div class="px-5 py-4 border-b border-gray-100">
            <p class="text-xs font-semibold text-red-600 mb-3 flex items-center gap-1.5">
                <i data-lucide="minus-circle" class="w-3.5 h-3.5"></i>
                Sebelum diubah
            </p>
            <div class="space-y-2">
                @foreach($activity->properties->get('old') as $key => $value)
                <div class="flex items-start gap-3 text-xs">
                    <span class="font-semibold text-gray-500 w-32 flex-shrink-0">{{ $key }}</span>
                    <span class="text-red-600 bg-red-50 px-2 py-0.5 rounded font-mono">
                        {{ is_array($value) ? json_encode($value) : ($value ?? 'null') }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- NEW VALUES --}}
        @if($activity->properties->get('attributes'))
        <div class="px-5 py-4">
            <p class="text-xs font-semibold text-emerald-600 mb-3 flex items-center gap-1.5">
                <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i>
                Sesudah diubah
            </p>
            <div class="space-y-2">
                @foreach($activity->properties->get('attributes') as $key => $value)
                <div class="flex items-start gap-3 text-xs">
                    <span class="font-semibold text-gray-500 w-32 flex-shrink-0">{{ $key }}</span>
                    <span class="text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded font-mono">
                        {{ is_array($value) ? json_encode($value) : ($value ?? 'null') }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
    @endif

    {{-- TOMBOL --}}
    <div class="flex flex-col-reverse sm:flex-row sm:justify-between gap-3">
        <a href="{{ route('kepsek.activity-log.index') }}"
           class="px-5 py-2.5 border border-gray-200 rounded-xl text-gray-700 font-semibold
                  text-sm hover:bg-gray-50 transition flex items-center justify-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
        <form action="{{ route('kepsek.activity-log.destroy', $activity->id) }}"
              method="POST" class="delete-log-form">
            @csrf @method('DELETE')
            <button type="submit"
                    class="w-full sm:w-auto px-5 py-2.5 bg-red-50 border border-red-200
                           text-red-700 font-semibold text-sm rounded-xl hover:bg-red-100
                           transition flex items-center justify-center gap-2">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
                Hapus log ini
            </button>
        </form>
    </div>

</div>

<script>
document.querySelectorAll('.delete-log-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus log ini?',
            text: 'Data log tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl' }
        }).then(result => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endsection