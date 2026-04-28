{{-- resources/views/kepala-sekolah/activity-log/index.blade.php --}}
@extends('kepala-sekolah.layouts.app')
@section('title', 'Activity Log')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="activity" class="w-6 h-6 flex-shrink-0"></i>
                    <span>Activity log</span>
                </h1>
                <p class="text-blue-100 text-sm mt-1">
                    Rekam jejak aktivitas admin & guru di sistem
                </p>
            </div>
            <div class="bg-white/15 rounded-xl px-4 py-2 text-center flex-shrink-0">
                <p class="text-xl font-bold">{{ $activities->total() }}</p>
                <p class="text-xs text-blue-100">Total log</p>
            </div>
        </div>

        {{-- FILTER --}}
        <form action="{{ route('kepsek.activity-log.index') }}" method="GET"
              class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
            {{-- Filter user --}}
            <select name="causer"
                    class="px-3 py-2.5 bg-white border border-gray-200 rounded-xl text-sm
                           text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                <option value="">Semua pengguna</option>
                @foreach($causers as $c)
                    <option value="{{ $c->id }}" {{ request('causer') == $c->id ? 'selected' : '' }}>
                        {{ $c->name }} ({{ $c->role }})
                    </option>
                @endforeach
            </select>

            {{-- Filter subject --}}
            <select name="subject"
                    class="px-3 py-2.5 bg-white border border-gray-200 rounded-xl text-sm
                           text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                <option value="">Semua data</option>
                @foreach($subjectTypes as $type)
                    <option value="{{ $type }}" {{ request('subject') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>

            {{-- Filter tanggal --}}
            <div class="flex gap-2">
                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                       class="flex-1 px-3 py-2.5 bg-white border border-gray-200 rounded-xl text-sm
                              text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                <button type="submit"
                        class="px-4 py-2.5 bg-white/15 hover:bg-white/25 text-white
                               text-sm font-semibold rounded-xl transition flex-shrink-0">
                    Filter
                </button>
                @if(request()->hasAny(['causer', 'subject', 'tanggal']))
                    <a href="{{ route('kepsek.activity-log.index') }}"
                       class="px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white
                              text-sm font-semibold rounded-xl transition flex-shrink-0">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- TABEL --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

        {{-- DESKTOP --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                        <th class="px-5 py-3.5 text-left font-semibold w-32">Waktu</th>
                        <th class="px-5 py-3.5 text-left font-semibold w-36">Pengguna</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Aktivitas</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-28">Data</th>
                        <th class="px-5 py-3.5 text-center font-semibold w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($activities as $activity)
                        @php
                            $eventColor = match(true) {
                                str_contains($activity->description, 'tambah') || str_contains($activity->description, 'baru') || str_contains($activity->event ?? '', 'created') => ['bg-emerald-50 text-emerald-700 border-emerald-200', 'plus-circle'],
                                str_contains($activity->description, 'perbarui') || str_contains($activity->description, 'edit') || str_contains($activity->event ?? '', 'updated') => ['bg-blue-50 text-blue-700 border-blue-200', 'edit-3'],
                                str_contains($activity->description, 'hapus') || str_contains($activity->event ?? '', 'deleted') => ['bg-red-50 text-red-700 border-red-200', 'trash-2'],
                                str_contains($activity->description, 'setujui') => ['bg-teal-50 text-teal-700 border-teal-200', 'check-circle'],
                                str_contains($activity->description, 'tolak') => ['bg-orange-50 text-orange-700 border-orange-200', 'x-circle'],
                                str_contains($activity->description, 'absensi') => ['bg-purple-50 text-purple-700 border-purple-200', 'check-square'],
                                str_contains($activity->description, 'nilai') => ['bg-indigo-50 text-indigo-700 border-indigo-200', 'trending-up'],
                                default => ['bg-gray-50 text-gray-600 border-gray-200', 'activity'],
                            };
                        @endphp
                        <tr class="hover:bg-gray-50/70 transition {{ $loop->even ? 'bg-gray-50/30' : '' }}">
                            <td class="px-5 py-4">
                                <p class="text-xs font-medium text-gray-700">
                                    {{ $activity->created_at->translatedFormat('d M Y') }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $activity->created_at->format('H:i:s') }}
                                </p>
                            </td>
                            <td class="px-5 py-4">
                                @if($activity->causer)
                                    <p class="text-xs font-semibold text-gray-900">
                                        {{ $activity->causer->name }}
                                    </p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs
                                                 font-medium bg-gray-100 text-gray-600 mt-0.5">
                                        {{ $activity->causer->role }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 italic">System</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full
                                                 text-xs font-semibold border {{ $eventColor[0] }}">
                                        <i data-lucide="{{ $eventColor[1] }}" class="w-3 h-3"></i>
                                    </span>
                                    <p class="text-sm text-gray-800">{{ $activity->description }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if($activity->subject_type)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs
                                                 font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        {{ class_basename($activity->subject_type) }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('kepsek.activity-log.show', $activity->id) }}"
                                       class="p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('kepsek.activity-log.destroy', $activity->id) }}"
                                          method="POST" class="inline delete-log-form">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="p-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-16 text-gray-400">
                                <div class="bg-gray-50 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                                    <i data-lucide="activity" class="w-7 h-7 text-gray-300"></i>
                                </div>
                                <p class="text-sm font-medium">Belum ada aktivitas</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE --}}
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($activities as $activity)
            <div class="p-4 hover:bg-gray-50 transition">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-800">{{ $activity->description }}</p>
                        <div class="flex items-center gap-2 mt-1 flex-wrap">
                            <span class="text-xs text-gray-400">
                                {{ $activity->causer->name ?? 'System' }}
                            </span>
                            <span class="text-gray-300">•</span>
                            <span class="text-xs text-gray-400">
                                {{ $activity->created_at->translatedFormat('d M Y H:i') }}
                            </span>
                        </div>
                    </div>
                    <div class="flex gap-2 flex-shrink-0">
                        <a href="{{ route('kepsek.activity-log.show', $activity->id) }}"
                           class="p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('kepsek.activity-log.destroy', $activity->id) }}"
                              method="POST" class="inline delete-log-form">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="p-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
                <div class="text-center py-16 text-gray-400">
                    <p class="text-sm font-medium">Belum ada aktivitas</p>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if($activities->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $activities->appends(request()->query())->links() }}
        </div>
        @endif

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