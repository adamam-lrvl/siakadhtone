<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Nilai Saya - {{ $siswa->nama }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            margin: 30px;
            color: #333;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #4f46e5;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
            border-collapse: collapse;
        }
        .info td {
            padding: 4px 6px;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data th {
            background-color: #4f46e5;
            color: #ffffff;
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }
        table.data td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
        }
        table.data td.left {
            text-align: left;
        }
        /* Zebra row */
        table.data tbody tr:nth-child(even) {
            background-color: #f3f4f6;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="title">
        REKAP NILAI SISWA
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="120"><strong>Nama Siswa</strong></td>
                <td width="10">:</td>
                <td>{{ $siswa->nama }}</td>
            </tr>
            <tr>
                <td><strong>Kelas</strong></td>
                <td>:</td>
                <td>{{ $siswa->kelas->nama_kelas ?? 'Belum Ditentukan' }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak</strong></td>
                <td>:</td>
                <td>{{ now()->translatedFormat('l, d F Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th>Mata Pelajaran</th>
                <th>Semester</th>
                <th>Tugas</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Rata-rata</th>
                <th>Predikat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekapNilai as $r)
            <tr>
                <td class="left">{{ $r->mapel->nama_mapel ?? '-' }}</td>
                <td>{{ $r->semester }}</td>
                <td>{{ $r->tugas }}</td>
                <td>{{ $r->uts }}</td>
                <td>{{ $r->uas }}</td>
                <td>{{ $r->rata_rata }}</td>
                <td style="font-weight: bold;">{{ $r->predikat }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-8">Belum ada data nilai</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak dari Sistem SIAKAD SMK Hang Tuah 1 Jakarta
    </div>

</body>
</html>