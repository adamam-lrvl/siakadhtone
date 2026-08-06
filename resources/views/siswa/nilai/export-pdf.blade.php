<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Rekap Nilai - {{ $siswa->nama }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 18mm;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #1e293b;
        }

        table { border-collapse: collapse; }

        /* ================= HEADER ================= */
        .kop {
            width: 100%;
        }
        .kop td {
            border: none;
            vertical-align: middle;
        }
        .logo {
            width: 65px;
        }
        .judul-sekolah {
            text-align: center;
        }
        .judul-sekolah h2 {
            margin: 0;
            font-size: 18px;
            color: #1E3A8A;
            letter-spacing: 0.5px;
        }
        .judul-sekolah p {
            margin: 1px;
            font-size: 9px;
            color: #475569;
        }

        .garis1 {
            border: 2px solid black;
            margin-top: 10px;
        }
        .garis2 {
            border: 1px solid black;
            margin-top: 2px;
            margin-bottom: 16px;
        }

        .title-box {
            text-align: center;
            color: #000;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ================= INFO ================= */
        .info-wrap {
            width: 100%;
            background: #F1F5F9;
            border: 1px solid #CBD5E1;
            border-radius: 6px;
            margin-bottom: 14px;
        }
        .info-wrap td {
            border: none;
            padding: 6px 10px;
            font-size: 10px;
            vertical-align: top;
        }
        .info-label {
            color: #1E3A8A;
            font-weight: bold;
            width: 110px;
        }
        .info-colon {
            width: 10px;
        }

        /* ================= TABLE ================= */
        .table-wrapper {
            padding: 0 12px;
        }
        .data {
            width: 96%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .data th {
            background: #1E3A8A;
            color: white;
            border: 1px solid #1E3A8A;
            padding: 5px 3px;
            text-align: center;
            font-size: 9px;
        }
        .data td {
            border: 1px solid #E5E7EB;
            padding: 4px 3px;
            font-size: 9px;
        }
        .data tbody tr:nth-child(even) {
            background: #F8FAFC;
        }
        .center { text-align: center; }
        .left   { text-align: left; padding-left: 6px; }

        /* warna nilai */
        .val-high { color: #16a34a; font-weight: bold; }
        .val-mid  { color: #d97706; font-weight: bold; }
        .val-low  { color: #dc2626; font-weight: bold; }

        /* badge predikat */
        .pred {
            display: inline-block;
            font-weight: bold;
            font-size: 9px;
            width: 18px;
            height: 18px;
            line-height: 18px;
            border-radius: 4px;
            text-align: center;
            color: #fff;
        }
        .pred-A { background: #16a34a; }
        .pred-B { background: #2563eb; }
        .pred-C { background: #d97706; }
        .pred-D { background: #ea580c; }
        .pred-E { background: #dc2626; }
        .pred-x { background: #94a3b8; }

        .smt-label {
            font-weight: bold;
            font-size: 11px;
            color: #1E3A8A;
            margin: 12px 0 6px;
        }

        /* ================= TTD ================= */
        .footer {
            width: 100%;
            margin-top: 40px;
        }
        .footer td {
            border: none;
            text-align: center;
            font-size: 10px;
            vertical-align: top;
        }
        .ttd {
            height: 60px;
        }

        /* ================= FOOTER CETAK ================= */
        .print-footer {
            margin-top: 25px;
            font-size: 8px;
            color: #64748b;
            border-top: 1px solid #CBD5E1;
            padding-top: 5px;
            width: 100%;
        }
        .print-footer td {
            border: none;
            font-size: 8px;
            color: #64748b;
        }
    </style>
</head>
<body>

@php
    $kepsekUser = \App\Models\User::where('role', 'kepsek')->first();
    $wali       = $siswa->kelas->waliKelas ?? null;
    $smt1       = $rekapNilai->where('semester', 1)->values();
    $smt2       = $rekapNilai->where('semester', 2)->values();

    $predikatClass = fn($p) => match($p) {
        'A'     => 'pred pred-A',
        'B'     => 'pred pred-B',
        'C'     => 'pred pred-C',
        'D'     => 'pred pred-D',
        'E'     => 'pred pred-E',
        default => 'pred pred-x',
    };

    $valClass = fn($v) => (float)$v >= 75 ? 'val-high' : ((float)$v >= 60 ? 'val-mid' : 'val-low');
@endphp

{{-- ================= HEADER ================= --}}
<table class="kop">
    <tr>
        <td width="70">
            <img src="{{ public_path('loho-sekolah.png') }}" class="logo" alt="Logo">
        </td>
        <td class="judul-sekolah">
            <h2>SMK HANG TUAH 1 JAKARTA</h2>
            <p>JL. TABAH RAYA KOMP. TNI-AL, Kelapa Gading Barat, Kec. Kelapa Gading, Kota Jakarta Utara, D.K.I. Jakarta.</p>
            <p>Website : smkhangtuah1.sch.id &nbsp;|&nbsp; e-Mail : smkhtone@yahoo.co.id &nbsp;|&nbsp; Telepon : (021) 4535140.</p>
        </td>
    </tr>
</table>

<div class="garis1"></div>
<div class="garis2"></div>

<div class="title-box">Rekap Nilai Siswa</div>

{{-- ================= INFO SISWA ================= --}}
<div class = "table-wrapper" >
<table class="info-wrap">
    <tr>
        <td class="info-label">NIS</td>
        <td class="info-colon">:</td>
        <td>{{ $siswa->nis ?? '-' }}</td>
        <td class="info-label">Kelas</td>
        <td class="info-colon">:</td>
        <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
    </tr>
    <tr>
        <td class="info-label">Nama Siswa</td>
        <td class="info-colon">:</td>
        <td>{{ strtoupper($siswa->nama) }}</td>
        <td class="info-label">Tahun Pelajaran</td>
        <td class="info-colon">:</td>
        <td>{{ date('Y') }}/{{ date('Y') + 1 }}</td>
    </tr>
    <tr>
        <td class="info-label">Jenis Kelamin</td>
        <td class="info-colon">:</td>
        <td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
        <td class="info-label">Tanggal Cetak</td>
        <td class="info-colon">:</td>
        <td>{{ now()->translatedFormat('d F Y H:i') }} WIB</td>
    </tr>
</table>
</div>

{{-- ================= TABEL PER SEMESTER ================= --}}
@foreach([1 => $smt1, 2 => $smt2] as $smt => $data)
@if($data->count() > 0)


    <div class="table-wrapper">
            <p class="smt-label">Semester {{ $smt }} ({{ $smt == 1 ? 'Ganjil' : 'Genap' }})</p>
        <table class="data">
            <thead>
                <tr>
                    <th style="width:5%">No</th>
                    <th style="width:40%; text-align:left; padding-left:6px;">Mata Pelajaran</th>
                    <th style="width:11%">Tugas</th>
                    <th style="width:11%">UTS</th>
                    <th style="width:11%">UAS</th>
                    <th style="width:12%">Rata-rata</th>
                    <th style="width:10%">Predikat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data->values() as $i => $r)
                @php $rata = $r->rata_rata ?? '0'; @endphp
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td class="left">{{ $r->mapel->nama_mapel ?? '-' }}</td>
                    <td class="center {{ $r->tugas !== '-' ? $valClass($r->tugas) : '' }}">{{ $r->tugas }}</td>
                    <td class="center {{ $r->uts !== '-' ? $valClass($r->uts) : '' }}">{{ $r->uts }}</td>
                    <td class="center {{ $r->uas !== '-' ? $valClass($r->uas) : '' }}">{{ $r->uas }}</td>
                    <td class="center {{ $valClass($rata) }}">{{ $rata }}</td>
                    <td class="center">
                        <span class="{{ $predikatClass($r->predikat) }}">{{ $r->predikat }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="center" style="padding:12px; color:#94a3b8;">
                        Belum ada nilai semester {{ $smt }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endif
@endforeach

{{-- ================= TANDA TANGAN ================= --}}
<table class="footer">
    <tr>
        <td colspan="3" style="padding-bottom: 8px;">
            Jakarta, {{ now()->translatedFormat('d F Y') }}
        </td>
    </tr>
    <tr>
        <td width="33%">Mengetahui,<br>Kepala Sekolah</td>
        <td width="34%">Wali Kelas</td>
        <td width="33%">Siswa</td>
    </tr>
    <tr>
        <td class="ttd"></td>
        <td class="ttd"></td>
        <td class="ttd"></td>
    </tr>
    <tr>
        <td>
            <strong><u>{{ $kepsekUser->name ?? 'Bahrudin' }}</u></strong> <br>
            NIP. - 
        </td>
        <td>
            <strong><u>{{ $wali->nama ?? '................................' }}</u></strong><br>
            NIP. {{ $wali->nip ?? '................................' }}
        </td>
        <td>
            <strong><u>{{ strtoupper($siswa->nama) }}</u></strong><br>
            NIS. {{ $siswa->nis ?? '-' }}
        </td>
    </tr>
</table>

{{-- ================= FOOTER CETAK ================= --}}
<table class="print-footer">
    <tr>
        <td style="text-align:left;">
            Dicetak oleh: {{ strtoupper($siswa->nama) }}, pada {{ now()->translatedFormat('d M Y H:i') }} WIB
        </td>
        <td style="text-align:right;">
            Sistem SIAKAD SMK Hang Tuah 1 Jakarta
        </td>
    </tr>
</table>

</body>
</html>