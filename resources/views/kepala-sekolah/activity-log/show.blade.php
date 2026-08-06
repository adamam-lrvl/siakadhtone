{{-- resources/views/kepala-sekolah/activity-log/show.blade.php --}}
@extends('kepala-sekolah.layouts.app')
@section('title', 'Detail Activity Log')

@section('content')
<div class="max-w-3xl mx-auto py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:border dark:border-white/[0.09]
                dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="relative p-6 flex items-center gap-3">
            <div class="bg-white/15 backdrop-blur-sm border border-white/20 rounded-xl p-2.5">
                <i data-lucide="activity" class="w-5 h-5 text-white"></i>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-white tracking-tight">Detail activity log</h1>
                <p class="text-blue-200 dark:text-white/40 text-sm mt-0.5">
                    {{ $activity->created_at->translatedFormat('l, d F Y H:i:s') }}
                </p>
            </div>
        </div>
    </div>

    {{-- INFO UTAMA --}}
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-white/[0.06] bg-gray-50 dark:bg-white/[0.03]">
            <p class="text-xs font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider">Informasi aktivitas</p>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-white/[0.05]">
            <div class="flex justify-between items-center px-5 py-3.5">
                <span class="text-xs text-gray-400 dark:text-white/30">Deskripsi</span>
                <span class="text-sm font-semibold text-gray-900 dark:text-white/90 text-right max-w-[60%]">{{ $activity->description }}</span>
            </div>
            <div class="flex justify-between items-center px-5 py-3.5">
                <span class="text-xs text-gray-400 dark:text-white/30">Dilakukan oleh</span>
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white/90">{{ $activity->causer->name ?? 'System' }}</p>
                    @if($activity->causer)
                        <p class="text-xs text-gray-400 dark:text-white/35">{{ $activity->causer->email }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                     bg-indigo-50 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300
                                     border border-indigo-200 dark:border-indigo-400/25">
                            {{ $activity->causer->role }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="flex justify-between items-center px-5 py-3.5">
                <span class="text-xs text-gray-400 dark:text-white/30">Jenis data</span>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                             bg-purple-50 dark:bg-purple-500/15 text-purple-700 dark:text-purple-300
                             border border-purple-200 dark:border-purple-400/25">
                    {{ $activity->subject_type ? class_basename($activity->subject_type) : '—' }}
                </span>
            </div>
            <div class="flex justify-between items-center px-5 py-3.5">
                <span class="text-xs text-gray-400 dark:text-white/30">ID data</span>
                <span class="text-sm font-semibold text-gray-900 dark:text-white/90">{{ $activity->subject_id ?? '—' }}</span>
            </div>
            <div class="flex justify-between items-center px-5 py-3.5">
                <span class="text-xs text-gray-400 dark:text-white/30">Waktu</span>
                <span class="text-sm font-semibold text-gray-900 dark:text-white/90">{{ $activity->created_at->translatedFormat('d F Y, H:i:s') }}</span>
            </div>
        </div>
    </div>

    {{-- PROPERTIES --}}
    @if($activity->properties && $activity->properties->isNotEmpty())
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-white/[0.06] bg-gray-50 dark:bg-white/[0.03]">
            <p class="text-xs font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider">Detail perubahan</p>
        </div>

        @if($activity->properties->get('old'))
        <div class="px-5 py-4 border-b border-gray-100 dark:border-white/[0.05]">
            <p class="text-xs font-semibold text-red-600 dark:text-red-400 mb-3 flex items-center gap-1.5">
                <i data-lucide="minus-circle" class="w-3.5 h-3.5"></i> Sebelum diubah
            </p>
            <div class="space-y-2">
                @foreach($activity->properties->get('old') as $key => $value)
                <div class="flex items-start gap-3 text-xs">
                    <span class="font-semibold text-gray-500 dark:text-white/40 w-32 flex-shrink-0">{{ $key }}</span>
                    <span class="text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-500/10 px-2 py-0.5 rounded font-mono">
                        {{ is_array($value) ? json_encode($value) : ($value ?? 'null') }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($activity->properties->get('attributes'))
        <div class="px-5 py-4">
            <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 mb-3 flex items-center gap-1.5">
                <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i> Sesudah diubah
            </p>
            <div class="space-y-2">
                @foreach($activity->properties->get('attributes') as $key => $value)
                <div class="flex items-start gap-3 text-xs">
                    <span class="font-semibold text-gray-500 dark:text-white/40 w-32 flex-shrink-0">{{ $key }}</span>
                    <span class="text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-0.5 rounded font-mono">
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
           class="px-5 py-2.5 border-2 border-gray-200 dark:border-white/[0.10] rounded-xl
                  text-gray-600 dark:text-white/50 font-semibold text-sm
                  hover:bg-gray-50 dark:hover:bg-white/[0.07] transition
                  flex items-center justify-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
        <form action="{{ route('kepsek.activity-log.destroy', $activity->id) }}" method="POST" class="delete-log-form">
            @csrf @method('DELETE')
            <button type="submit"
                    class="w-full sm:w-auto px-5 py-2.5 bg-red-50 dark:bg-red-500/10
                           border border-red-200 dark:border-red-500/25
                           text-red-700 dark:text-red-400 font-semibold text-sm rounded-xl
                           hover:bg-red-100 dark:hover:bg-red-500/20 transition
                           flex items-center justify-center gap-2">
                <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus log ini
            </button>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('.delete-log-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus log ini?', text: 'Data log tidak bisa dikembalikan!', icon: 'warning',
            showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl' }
        }).then(r => { if (r.isConfirmed) form.submit(); });
    });
});
</script>
@endsection