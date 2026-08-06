<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi - {{ $siswa->nama }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 18mm;   /* <-- ini yang bikin ada space kiri-kanan */
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
        .data {
            width: 100%;
            border-collapse: collapse;
        }
        .table-wrapper{
            padding: 0 12px;
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

        .badge-persen {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            background: #E2E8F0;
            color: #1E3A8A;
            font-weight: bold;
        }
        .badge-persen.ok {
            background: #DCFCE7;
            color: #16A34A;
        }
        .badge-persen.fail {
            background: #FEE2E2;
            color: #DC2626;
        }

        .total-row {
            margin-top: 8px;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            color: #1E3A8A;
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
            width: 96%;
            margin-left: auto;
            margin-right: auto;
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
    $kepsek = \App\Models\User::where('role', 'kepsek')->first();
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

<div class="title-box">Rekap Absensi Siswa</div>

{{-- ================= INFO SISWA ================= --}}
<div class = "table-wrapper">
<table class="info-wrap">
    <tr>
        <td class="info-label">NIS</td>
        <td class="info-colon">:</td>
        <td>{{ $siswa->nis }}</td>
        <td class="info-label">Kelas</td>
        <td class="info-colon">:</td>
        <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
    </tr>
    <tr>
        <td class="info-label">Nama Siswa</td>
        <td class="info-colon">:</td>
        <td>{{ $siswa->nama }}</td>
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

{{-- ================= TABEL ================= --}}
<div class="table-wrapper">
<table class="data">
    <thead>
        <tr>
            <th style="width:4%">No</th>
            <th style="width:10%">NIS</th>
            <th style="width:22%">Mata Pelajaran</th>
            <th style="width:10%">Pertemuan</th>
            <th style="width:8%">H</th>
            <th style="width:8%">I</th>
            <th style="width:8%">S</th>
            <th style="width:8%">A</th>
            <th style="width:12%">Belum Presensi</th>
            <th style="width:10%">Hadir (%)</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; $totalHadir = 0; $totalPertemuan2 = 0; @endphp
        @forelse($absensis as $jadwal_id => $records)
            @php
                $jadwal = $records->first()->jadwal;
                $hadir  = $records->where('status', 'H')->count();
                $izin   = $records->where('status', 'I')->count();
                $sakit  = $records->where('status', 'S')->count();
                $alpa   = $records->where('status', 'A')->count();
                $total  = $hadir + $izin + $sakit + $alpa;
                $belum  = $totalPertemuan - $total;
                $persen = $totalPertemuan > 0 ? round($hadir / $totalPertemuan * 100) : 0;
                $totalHadir += $hadir;
                $totalPertemuan2 += $total;
            @endphp
            <tr>
                <td class="center">{{ $no++ }}</td>
                <td class="center">{{ $siswa->nis }}</td>
                <td class="left">{{ $jadwal->mapel->nama_mapel ?? '-' }}</td>
                <td class="center">{{ $total }}/{{ $totalPertemuan }}</td>
                <td class="center">{{ $hadir }}</td>
                <td class="center">{{ $izin ?: '-' }}</td>
                <td class="center">{{ $sakit ?: '-' }}</td>
                <td class="center">{{ $alpa ?: '-' }}</td>
                <td class="center">{{ $belum < 0 ? 0 : $belum }}</td>
                <td class="center">
                    <span class="badge-persen {{ $persen >= 75 ? 'ok' : 'fail' }}">
                        {{ $persen }}%
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" class="center" style="padding:12px;">Belum ada data absensi</td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>

{{-- TOTAL --}}
@if($no > 1)
<div class="total-row">
    Total : {{ $totalPertemuan2 }} / {{ $totalPertemuan * ($no - 1) }},
    {{ $totalPertemuan2 }} Pertemuan sudah selesai
</div>
@endif

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
            <strong><u>{{ $kepsek->name ?? 'Bahrudin S.Pd'  }}</u></strong> <br>
            NIP. -
        </td>
        <td>
            <strong><u>{{ $siswa->kelas->waliKelas->nama ?? '................................' }}</u></strong><br>
            NIP. {{ $siswa->kelas->waliKelas->nip ?? '................................' }}
        </td>
        <td>
            <strong><u>{{ $siswa->nama }}</u></strong><br>
            NIS. {{ $siswa->nis }}
        </td>
    </tr>
</table>

{{-- ================= FOOTER CETAK ================= --}}
<table class="print-footer">
    <tr>
        <td style="text-align:left;">
            Dicetak oleh: {{ $siswa->nama }}, pada {{ now()->translatedFormat('d M Y H:i') }} WIB
            | siakadhtone.test/siswa/absensi
        </td>
        <td style="text-align:right;">
            Sistem SIAKAD SMK Hang Tuah 1 Jakarta
        </td>
    </tr>
</table>

</body>
</html>