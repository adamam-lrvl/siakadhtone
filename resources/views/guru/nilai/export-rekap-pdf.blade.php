<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Nilai - {{ $mapel->nama_mapel }}</title>
    <style>
        /* === Orientasi Vertikal (Portrait) === */
        @page {
            size: A4 portrait;
            margin: 12mm 10mm;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 20px 30px;
        }

        /* HEADER INSTITUSI */
        .header-institusi {
            display: table;
            width: 100%;
        }
        .header-logo {
            display: table-cell;
            width: 90px;
            vertical-align: middle;
            text-align: center;
        }
        .header-logo img {
            width: 75px;
            height: 75px;
            object-fit: contain;
        }
        .header-info {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding: 0 10px;
        }
        .header-info .nama-sekolah {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header-info .alamat {
            font-size: 10px;
            margin-top: 3px;
            line-height: 1.5;
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

        /* JUDUL DOKUMEN */
        .judul-dokumen {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            margin: 0 0 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #000;
        }

        /* INFO MAPEL */
        .info-mapel {
            width: 100%;
            background: #F1F5F9;
            border: 1px solid #CBD5E1;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .info-mapel table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-mapel td {
            padding: 6px 8px;
            font-size: 11px;
            vertical-align: top;
        }
        .info-mapel .label {
            font-weight: bold;
            width: 130px;
            color: #1E3A8A;
        }
        .info-mapel .colon {
            width: 10px;
        }

        /* TABEL DATA */
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        table.data th {
            background-color: #1E3A8A;
            color: #ffffff;
            border: 1px solid #1E3A8A;
            padding: 6px 4px;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
        }
        table.data td {
            border: 1px solid #E5E7EB;
            padding: 5px 4px;
            text-align: center;
            font-size: 10px;
        }
        table.data td.left {
            text-align: left;
            padding-left: 6px;
        }
        table.data tbody tr:nth-child(even) {
            background-color: #F8FAFC;
        }

        /* PREDIKAT */
        .predikat {
            color: #1E3A8A;
            font-weight: bold;
        }

        /* TANDA TANGAN */
        .ttd-section {
            margin-top: 40px;
            width: 100%;
        }
        .ttd-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .ttd-section td {
            text-align: center;
            vertical-align: top;
            padding: 0 10px;
            font-size: 11px;
            width: 33.3%;
        }
        .ttd-section .jabatan {
            font-weight: bold;
            margin-bottom: 60px;
        }
        .ttd-section .nama-ttd {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 4px;
            display: inline-block;
            min-width: 140px;
        }
        .ttd-section .nip-ttd {
            font-size: 10px;
            margin-top: 2px;
        }

        /* FOOTER */
        .footer {
            margin-top: 20px;
            font-size: 9px;
            color: #555;
            border-top: 1px solid #ccc;
            padding-top: 5px;
            display: table;
            width: 100%;
        }
        .footer-left  { display: table-cell; text-align: left; }
        .footer-right { display: table-cell; text-align: right; }
    </style>
</head>
<body>

    {{-- HEADER INSTITUSI --}}
    <div class="header-institusi">
        <div class="header-logo">
            <img src="{{ public_path('logo-sekolah.png') }}" alt="Logo SMK Hang Tuah 1 Jakarta">
        </div>
        <div class="header-info">
            <div class="nama-sekolah">SMK Hang Tuah 1 Jakarta</div>
            <div class="alamat">
                JL. TABAH RAYA KOMP. TNI-AL, Kelapa Gading Barat, Kec. Kelapa Gading, Kota Jakarta Utara, D.K.I. Jakarta.<br>
                Website : smkhangtuah1.sch.id &nbsp;|&nbsp;
                e-Mail : smkhtone@yahoo.co.id &nbsp;|&nbsp;
                Telepon : (021) 4535140
            </div>
        </div>
    </div>

    <div class="garis1"></div>
    <div class="garis2"></div>

    {{-- JUDUL --}}
    <div class="judul-dokumen">Rekap Nilai Siswa</div>

    {{-- INFO MAPEL --}}
    <div class="info-mapel">
        <table>
            <tr>
                <td class="label">Mata Pelajaran</td>
                <td class="colon">:</td>
                <td>{{ $mapel->nama_mapel }}</td>
                <td class="label">Semester</td>
                <td class="colon">:</td>
                <td>{{ $semester }}</td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td class="colon">:</td>
                <td>{{ $kelas->nama_kelas }}</td>
                <td class="label">Tanggal Cetak</td>
                <td class="colon">:</td>
                <td>{{ now()->translatedFormat('d F Y H:i') }} WIB</td>
            </tr>
        </table>
    </div>

    {{-- TABEL NILAI --}}
    <table class="data">
        <thead>
            <tr>
                <th style="width:4%">No</th>
                <th style="width:22%">Nama Siswa</th>
                <th style="width:9%">NIS</th>
                <th style="width:6%">Tugas 1</th>
                <th style="width:6%">Tugas 2</th>
                <th style="width:6%">Tugas 3</th>
                <th style="width:6%">Tugas 4</th>
                <th style="width:6%">Tugas 5</th>
                <th style="width:6%">Tugas 6</th>
                <th style="width:6%">UTS</th>
                <th style="width:6%">UAS</th>
                <th style="width:9%">Rata-rata</th>
                <th style="width:8%">Predikat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekapSiswa as $index => $r)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="left">{{ $r['siswa']->nama }}</td>
                <td>{{ $r['siswa']->nis }}</td>
                <td>{{ $r['nilai']['tugas_1'] ?? '-' }}</td>
                <td>{{ $r['nilai']['tugas_2'] ?? '-' }}</td>
                <td>{{ $r['nilai']['tugas_3'] ?? '-' }}</td>
                <td>{{ $r['nilai']['tugas_4'] ?? '-' }}</td>
                <td>{{ $r['nilai']['tugas_5'] ?? '-' }}</td>
                <td>{{ $r['nilai']['tugas_6'] ?? '-' }}</td>
                <td>{{ $r['nilai']['uts'] ?? '-' }}</td>
                <td>{{ $r['nilai']['uas'] ?? '-' }}</td>
                <td><strong>{{ $r['rata_rata'] }}</strong></td>
                <td class="predikat">{{ $r['predikat'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="13" style="text-align:center; padding:12px;">
                    Belum ada data nilai
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="ttd-section">
        <table>
            <tr>
                <td>
                    <div class="jabatan">Mengetahui,<br>Kepala Sekolah</div>
                    <div class="nama-ttd">Bahrudin S.PD</div>
                    <div class="nip-ttd">NIP. -</div>
                </td>
                <td>
                    <div class="jabatan">Wali Kelas,</div>
                    <div class="nama-ttd">
                        {{ $kelas->waliKelas->nama ?? '................................' }}
                    </div>
                    <div class="nip-ttd">
                        NIP. {{ $kelas->waliKelas->nip ?? '................................' }}
                    </div>
                </td>
                <td>
                    <div class="jabatan">
                        Jakarta, {{ now()->translatedFormat('d F Y') }}<br>
                        Guru Mata Pelajaran,
                    </div>
                    <div class="nama-ttd">
                    {{ $guru->nama ?? '................................' }}
                    </div>
                    <div class="nip-ttd">
                    NIP. {{ $guru->nip ?? '................................' }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <div class="footer-left">
            Dicetak oleh: {{ auth()->user()->name ?? '-' }},
            pada {{ now()->translatedFormat('d M Y H:i') }} WIB
            | siakadhtone.test/nilai/rekap
        </div>
        <div class="footer-right">
            Sistem SIAKAD SMK Hang Tuah 1 Jakarta
        </div>
    </div>

</body>
</html>