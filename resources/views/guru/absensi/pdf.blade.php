<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi Siswa</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .info {
            margin-bottom: 10px;
        }

        .info table {
            width: 100%;
            border-collapse: collapse;
        }

        .info td {
            padding: 3px 5px;
            vertical-align: top;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data th {
            background-color: #1e40af; 
            color: #ffffff;
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            font-weight: bold;
        }

        table.data td {
            border: 1px solid #000;
            padding: 5px;
        }

        table.data td.center {
            text-align: center;
        }

        table.data td.left {
            text-align: left;
        }

        /* zebra row kayak Excel */
        table.data tbody tr:nth-child(even) {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body>

    <div class="title">
        REKAP ABSENSI SISWA
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="120"><strong>Mata Pelajaran</strong></td>
                <td width="10">:</td>
                <td>{{ $jadwal->mapel->nama_mapel }}</td>
            </tr>
            <tr>
                <td><strong>Kelas</strong></td>
                <td>:</td>
                <td>{{ $jadwal->kelas->nama_kelas }}</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">NIS</th>
                <th width="25%">Nama Siswa</th>
                <th width="10%">Pertemuan</th>
                <th width="8%">Hadir</th>
                <th width="8%">Izin</th>
                <th width="8%">Sakit</th>
                <th width="8%">Alpa</th>
                <th width="10%">Belum</th>
                <th width="8%">Hadir (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td class="center">{{ $row['no'] }}</td>
                    <td class="center">{{ $row['nis'] }}</td>
                    <td class="left">{{ $row['nama'] }}</td>
                    <td class="center">{{ $row['pertemuan'] }}</td>
                    <td class="center">{{ $row['hadir'] }}</td>
                    <td class="center">{{ $row['izin'] }}</td>
                    <td class="center">{{ $row['sakit'] }}</td>
                    <td class="center">{{ $row['alpa'] }}</td>
                    <td class="center">{{ $row['belum'] }}</td>
                    <td class="center">{{ $row['persen'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
