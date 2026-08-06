{{-- resources/views/kepala-sekolah/activity-log/index.blade.php --}}
@extends('kepala-sekolah.layouts.app')
@section('title', 'Activity Log')

@section('content')
<div class="max-w-6xl mx-auto py-6 space-y-6">

    {{-- HERO --}}
    <div class="relative rounded-2xl overflow-hidden
                bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700
                dark:bg-none dark:bg-white/[0.06] dark:backdrop-blur-3xl
                dark:border dark:border-white/[0.09]
                dark:shadow-[0_0_40px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.10)]">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.12),transparent_60%)] dark:opacity-20 pointer-events-none"></div>
        <div class="relative p-6">
            <div class="flex items-start justify-between gap-4 mb-4">
                <div class="min-w-0">
                    <h1 class="text-2xl font-extrabold text-white flex items-center gap-2 tracking-tight">
                        <i data-lucide="activity" class="w-6 h-6 flex-shrink-0"></i>
                        Activity log
                    </h1>
                    <p class="text-blue-200 dark:text-white/40 text-sm mt-1">Rekam jejak aktivitas admin & guru di sistem</p>
                </div>
                <div class="bg-white/15 dark:bg-white/[0.07] border border-white/20 dark:border-white/[0.09]
                            backdrop-blur-sm rounded-xl px-4 py-2 text-center flex-shrink-0">
                    <p class="text-xl font-bold text-white dark:text-white/90">{{ $activities->total() }}</p>
                    <p class="text-xs text-blue-100 dark:text-white/40">Total log</p>
                </div>
            </div>

            {{-- FILTER --}}
            <form action="{{ route('kepsek.activity-log.index') }}" method="GET"
                  class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                <select name="causer"
                        class="px-3 py-2.5 bg-white dark:bg-white/[0.08] border border-gray-200 dark:border-white/[0.12]
                               rounded-xl text-sm text-gray-700 dark:text-white/80
                               focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">Semua pengguna</option>
                    @foreach($causers as $c)
                        <option value="{{ $c->id }}" {{ request('causer') == $c->id ? 'selected' : '' }}>
                            {{ $c->name }} ({{ $c->role }})
                        </option>
                    @endforeach
                </select>
                <select name="subject"
                        class="px-3 py-2.5 bg-white dark:bg-white/[0.08] border border-gray-200 dark:border-white/[0.12]
                               rounded-xl text-sm text-gray-700 dark:text-white/80
                               focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="">Semua data</option>
                    @foreach($subjectTypes as $type)
                        <option value="{{ $type }}" {{ request('subject') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                           class="flex-1 px-3 py-2.5 bg-white dark:bg-white/[0.08] border border-gray-200 dark:border-white/[0.12]
                                  rounded-xl text-sm text-gray-700 dark:text-white/80
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <button type="submit"
                            class="px-4 py-2.5 bg-white/15 hover:bg-white/25 border border-white/20
                                   text-white text-sm font-semibold rounded-xl transition flex-shrink-0">Filter</button>
                    @if(request()->hasAny(['causer','subject','tanggal']))
                        <a href="{{ route('kepsek.activity-log.index') }}"
                           class="px-4 py-2.5 bg-white/10 hover:bg-white/20 border border-white/15
                                  text-white text-sm font-semibold rounded-xl transition flex-shrink-0">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="bg-white dark:bg-white/[0.05] dark:backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/[0.07] overflow-hidden">

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
                <tbody class="divide-y divide-gray-100 dark:divide-white/[0.05]">
                    @forelse($activities as $activity)
                        @php
                            $desc = $activity->description ?? '';
                            $ev = $activity->event ?? '';
                            if (str_contains($desc,'tambah')||str_contains($desc,'baru')||str_contains($ev,'created'))
                                $ec = ['bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/25','plus-circle'];
                            elseif (str_contains($desc,'perbarui')||str_contains($desc,'edit')||str_contains($ev,'updated'))
                                $ec = ['bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-500/25','edit-3'];
                            elseif (str_contains($desc,'hapus')||str_contains($ev,'deleted'))
                                $ec = ['bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 border-red-200 dark:border-red-500/25','trash-2'];
                            elseif (str_contains($desc,'setujui'))
                                $ec = ['bg-teal-50 dark:bg-teal-500/10 text-teal-700 dark:text-teal-400 border-teal-200 dark:border-teal-500/25','check-circle'];
                            elseif (str_contains($desc,'tolak'))
                                $ec = ['bg-orange-50 dark:bg-orange-500/10 text-orange-700 dark:text-orange-400 border-orange-200 dark:border-orange-500/25','x-circle'];
                            elseif (str_contains($desc,'absensi'))
                                $ec = ['bg-purple-50 dark:bg-purple-500/10 text-purple-700 dark:text-purple-400 border-purple-200 dark:border-purple-500/25','check-square'];
                            elseif (str_contains($desc,'nilai'))
                                $ec = ['bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 border-indigo-200 dark:border-indigo-500/25','trending-up'];
                            else
                                $ec = ['bg-gray-50 dark:bg-white/[0.05] text-gray-600 dark:text-white/50 border-gray-200 dark:border-white/[0.08]','activity'];
                        @endphp
                        <tr class="hover:bg-gray-50/70 dark:hover:bg-white/[0.04] transition {{ $loop->even ? 'bg-gray-50/30 dark:bg-white/[0.02]' : '' }}">
                            <td class="px-5 py-4">
                                <p class="text-xs font-medium text-gray-700 dark:text-white/70">{{ $activity->created_at->translatedFormat('d M Y') }}</p>
                                <p class="text-xs text-gray-400 dark:text-white/30">{{ $activity->created_at->format('H:i:s') }}</p>
                            </td>
                            <td class="px-5 py-4">
                                @if($activity->causer)
                                    <p class="text-xs font-semibold text-gray-900 dark:text-white/90">{{ $activity->causer->name }}</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                 bg-gray-100 dark:bg-white/[0.07] text-gray-600 dark:text-white/50 mt-0.5">
                                        {{ $activity->causer->role }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-white/30 italic">System</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $ec[0] }}">
                                        <i data-lucide="{{ $ec[1] }}" class="w-3 h-3"></i>
                                    </span>
                                    <p class="text-sm text-gray-800 dark:text-white/80">{{ $activity->description }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if($activity->subject_type)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                                 bg-indigo-50 dark:bg-indigo-500/15 text-indigo-700 dark:text-indigo-300
                                                 border border-indigo-200 dark:border-indigo-400/25">
                                        {{ class_basename($activity->subject_type) }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-white/25">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('kepsek.activity-log.show', $activity->id) }}"
                                       class="p-1.5 bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-100 dark:hover:bg-blue-500/20
                                              text-blue-600 dark:text-blue-400 rounded-lg transition">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('kepsek.activity-log.destroy', $activity->id) }}"
                                          method="POST" class="inline delete-log-form">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="p-1.5 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20
                                                       text-red-600 dark:text-red-400 rounded-lg transition">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-16">
                                <div class="bg-gray-50 dark:bg-white/[0.04] rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-3">
                                    <i data-lucide="activity" class="w-7 h-7 text-gray-300 dark:text-white/20"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-400 dark:text-white/30">Belum ada aktivitas</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE --}}
        <div class="md:hidden divide-y divide-gray-100 dark:divide-white/[0.05]">
            @forelse($activities as $activity)
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-white/[0.04] transition">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-800 dark:text-white/80">{{ $activity->description }}</p>
                        <div class="flex items-center gap-2 mt-1 flex-wrap text-xs text-gray-400 dark:text-white/30">
                            <span>{{ $activity->causer->name ?? 'System' }}</span>
                            <span>•</span>
                            <span>{{ $activity->created_at->translatedFormat('d M Y H:i') }}</span>
                        </div>
                    </div>
                    <div class="flex gap-2 flex-shrink-0">
                        <a href="{{ route('kepsek.activity-log.show', $activity->id) }}"
                           class="p-1.5 bg-blue-50 dark:bg-blue-500/10 hover:bg-blue-100 dark:hover:bg-blue-500/20
                                  text-blue-600 dark:text-blue-400 rounded-lg transition">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('kepsek.activity-log.destroy', $activity->id) }}"
                              method="POST" class="inline delete-log-form">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="p-1.5 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20
                                           text-red-600 dark:text-red-400 rounded-lg transition">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
                <div class="text-center py-16">
                    <p class="text-sm font-medium text-gray-400 dark:text-white/30">Belum ada aktivitas</p>
                </div>
            @endforelse
        </div>

        @if($activities->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 dark:border-white/[0.05] bg-gray-50/50 dark:bg-white/[0.02]">
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
            title: 'Hapus log ini?', text: 'Data log tidak bisa dikembalikan!', icon: 'warning',
            showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl' }
        }).then(r => { if (r.isConfirmed) form.submit(); });
    });
});
</script>
@endsection