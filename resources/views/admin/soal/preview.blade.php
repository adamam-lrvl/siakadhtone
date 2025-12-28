@extends('admin.layouts.admin')
@section('title', 'Preview Paket Soal - ' . $paket->judul)

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">{{ $paket->judul }}</h2>
    <p class="text-gray-600 mb-2"><strong>Mata Pelajaran:</strong> {{ $paket->mapel->nama_mapel }}</p>
    <p class="text-gray-600 mb-4"><strong>Kelas:</strong> {{ $paket->kelas->nama_kelas }}</p>

    <hr class="mb-4">

    <ol class="space-y-4">
        @foreach($paket->soal as $index => $soal)
            <li>
                <p class="font-medium text-gray-800">{{ $index + 1 }}. {{ $soal->pertanyaan }}</p>
                @if($soal->tipe === 'pg')
                    @php $pilihan = json_decode($soal->pilihan, true); @endphp
                    <ul class="mt-2 space-y-1">
                        @foreach($pilihan as $key => $value)
                            <li>{{ strtoupper($key) }}. {{ $value }}</li>
                        @endforeach
                    </ul>
                    <p class="mt-1 text-green-600 text-sm">Jawaban: {{ strtoupper($soal->jawaban) }}</p>
                @else
                    <p class="italic text-gray-500">Soal essay</p>
                @endif
            </li>
        @endforeach
    </ol>

    <div class="mt-6">
        <a href="{{ route('admin.soal.index') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Kembali</a>
    </div>
</div>
@endsection
