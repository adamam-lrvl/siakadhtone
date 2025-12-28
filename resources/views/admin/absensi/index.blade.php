    @extends('admin.layouts.app')

    @section('title', 'Data Absensi')

    @section('content')
    <div class="container mx-auto px-4 py-6">

        <h1 class="text-2xl font-bold mb-6">Rekap Absensi</h1>

        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 bg-white p-4 shadow rounded-lg">
            <div>
                <label class="text-sm font-semibold">Kelas</label>
                <select name="kelas_id" class="w-full border rounded p-2">
                    <option value="">Semua</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-semibold">Guru</label>
                <select name="guru_id" class="w-full border rounded p-2">
                    <option value="">Semua</option>
                    @foreach($gurus as $g)
                        <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-semibold">Mapel</label>
                <select name="mapel_id" class="w-full border rounded p-2">
                    <option value="">Semua</option>
                    @foreach($mapels as $m)
                        <option value="{{ $m->id }}" {{ request('mapel_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm font-semibold">Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full border rounded p-2">
            </div>

            <div class="md:col-span-4 flex justify-end">
                <button class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Filter</button>
            </div>
        </form>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Siswa</th>
                        <th class="p-3">Kelas</th>
                        <th class="p-3">Mapel</th>
                        <th class="p-3">Guru</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($absensis as $a)
                        <tr class="border-b">
                            <td class="p-3">{{ $a->tanggal }}</td>
                            <td class="p-3">{{ $a->siswa->nama ?? '-' }}</td>
                            <td class="p-3">{{ $a->jadwal->kelas->nama_kelas ?? '-' }}</td>
                            <td class="p-3">{{ $a->jadwal->mapel->nama_mapel ?? '-' }}</td>
                            <td class="p-3">{{ $a->jadwal->guru->nama ?? '-' }}</td>
                            <td class="p-3">
                                @php
                                    $color = [
                                        'H' => 'text-green-600',
                                        'I' => 'text-yellow-600',
                                        'S' => 'text-blue-600',
                                        'A' => 'text-red-600'
                                    ];
                                @endphp
                                <span class="font-semibold {{ $color[$a->status] ?? '' }}">
                                    {{ $a->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-6 text-gray-500">
                                Tidak ada data absensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4 px-4 pb-4">
                {{ $absensis->links() }}
            </div>
        </div>

    </div>
    @endsection
