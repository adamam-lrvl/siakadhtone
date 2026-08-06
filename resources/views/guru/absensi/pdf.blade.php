<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekap Absensi Siswa</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 20px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #1e293b;
        }

        table {
            border-collapse: collapse;
        }

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

        .judul-sekolah h3 {
            margin: 2px 0;
            font-size: 13px;
            color: #1E3A8A;
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
        }

        .info-label {
            color: #1E3A8A;
            font-weight: bold;
            width: 90px;
        }

        /* ================= TABLE ================= */

        .data {
            width: 100%;
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

        .center {
            text-align: center;
        }

        .badge-hadir,
        .badge-izin,
        .badge-sakit,
        .badge-alpa {
            font-weight: bold;
            color: #1e293b;
        }

        .badge-persen {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            background: #E2E8F0;
            color: #1E3A8A;
            font-weight: bold;
        }

        /* ================= FOOTER ================= */

        .footer {
            width: 100%;
            margin-top: 35px;
        }

        .footer td {
            border: none;
            text-align: center;
            font-size: 10px;
        }

        .ttd {
            height: 60px;
        }
    </style>

</head>

<body>

<table class="kop">
    <tr>
        <td width="70">
            <img src="{{ public_path('loho-sekolah.png') }}" class="logo">
        </td>
        <td class="judul-sekolah">
            <h2>SMK HANG TUAH 1 JAKARTA</h2>
            <p>JL. TABAH RAYA KOMP. TNI-AL, Kelapa Gading Barat, Kec. Kelapa Gading, Kota Jakarta Utara, D.K.I. Jakarta.</p>
            <p>Website : smkhangtuah1.sch.id &nbsp;|&nbsp; e-Mail : smkhtone@yahoo.co.id &nbsp;|&nbsp; Telepon : (021) 4535140.</p>
    </tr>
</table>

<div class="garis1"></div>
<div class="garis2"></div>

<div class="title-box">
    Rekap Absensi Siswa
</div>

<table class="info-wrap">
    <tr>
        <td class="info-label">Mata Pelajaran</td>
        <td width="10">:</td>
        <td>{{ $jadwal->mapel->nama_mapel }}</td>
    </tr>
    <tr>
        <td class="info-label">Kelas</td>
        <td>:</td>
        <td>{{ $jadwal->kelas->nama_kelas }}</td>
    </tr>
    <tr>
        <td class="info-label">Tanggal Cetak</td>
        <td>:</td>
        <td>{{ now()->format('d-m-Y') }}</td>
    </tr>
</table>

<table class="data">
    <thead>
        <tr>
            <th width="4%">No</th>
            <th width="14%">NIS</th>
            <th width="26%">Nama Siswa</th>
            <th width="10%">Pert.</th>
            <th width="9%">H</th>
            <th width="9%">I</th>
            <th width="9%">S</th>
            <th width="9%">A</th>
            <th width="10%">%</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        <tr>
            <td class="center">{{ $loop->iteration }}</td>
            <td class="center">{{ $row['nis'] }}</td>
            <td>{{ $row['nama'] }}</td>
            <td class="center">{{ $row['pertemuan'] }}</td>
            <td class="center badge-hadir">{{ $row['hadir'] }}</td>
            <td class="center badge-izin">{{ $row['izin'] }}</td>
            <td class="center badge-sakit">{{ $row['sakit'] }}</td>
            <td class="center badge-alpa">{{ $row['alpa'] }}</td>
            <td class="center"><span class="badge-persen">{{ $row['persen'] }}%</span></td>
        </tr>
    @endforeach
    </tbody>
</table>

<table class="footer">
    <tr>
        <td colspan="2">Jakarta, {{ now()->format('d F Y') }}</td>
    </tr>
    <tr>
        <td width="50%">Kepala Sekolah</td>
        <td>Guru Mata Pelajaran</td>
    </tr>
    <tr>
        <td class="ttd"></td>
        <td class="ttd"></td>
    </tr>
    <tr>
        <td>
            <strong><u>Bahrudin S.PD</u></strong>
            <br>
            NIP. -
        </td>
        <td>
            <strong><u>{{ $jadwal->guru->nama }}</u></strong>
            <br>
            NIP. {{ $jadwal->guru->nip }}
        </td>
    </tr>
</table>

</body>

</html>