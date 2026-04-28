<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Nilai - {{ $mapel->nama_mapel }}</title>
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
            margin-top: 15px;
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
                <td width="140"><strong>Mata Pelajaran</strong></td>
                <td width="10">:</td>
                <td>{{ $mapel->nama_mapel }}</td>
            </tr>
            <tr>
                <td><strong>Kelas</strong></td>
                <td>:</td>
                <td>{{ $kelas->nama_kelas }}</td>
            </tr>
            <tr>
                <td><strong>Semester</strong></td>
                <td>:</td>
                <td>{{ $semester }}</td>
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
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Tugas 1</th>
                <th>Tugas 2</th>
                <th>Tugas 3</th>
                <th>Tugas 4</th>
                <th>Tugas 5</th>
                <th>Tugas 6</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Rata-rata</th>
                <th>Predikat</th>
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
                <td style="font-weight: bold;">{{ $r['predikat'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="13" class="text-center py-8">Belum ada data nilai</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak dari Sistem SIAKAD SMK Hang Tuah 1 Jakarta
    </div>

</body>
</html>