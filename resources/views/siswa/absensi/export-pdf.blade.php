<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi - {{ $siswa->nama }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 30px;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #1e40af;
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
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }

        table.data td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        table.data td.left {
            text-align: left;
        }

        /* Zebra row */
        table.data tbody tr:nth-child(even) {
            background-color: #f0f4ff;
        }

        .hadir-ok {
            color: #16a34a;
            font-weight: bold;
        }

        .hadir-fail {
            color: #dc2626;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="title">REKAP ABSENSI SISWA</div>

    <div class="info">
        <table>
            <tr>
                <td width="120"><strong>Nama Siswa</strong></td>
                <td width="10">:</td>
                <td>{{ $siswa->nama }}</td>
            </tr>
            <tr>
                <td><strong>NIS</strong></td>
                <td>:</td>
                <td>{{ $siswa->nis }}</td>
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
                <th style="width: 4%;">No</th>
                <th style="width: 10%;">NIS</th>
                <th style="width: 25%;">Mata Pelajaran</th>
                <th style="width: 10%;">Pertemuan</th>
                <th style="width: 8%;">Hadir</th>
                <th style="width: 8%;">Izin</th>
                <th style="width: 8%;">Sakit</th>
                <th style="width: 8%;">Alpa</th>
                <th style="width: 11%;">Belum Presensi</th>
                <th style="width: 8%;">Hadir (%)</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp

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
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td class="left">{{ $jadwal->mapel->nama_mapel ?? '-' }}</td>
                    <td>{{ $total }}/{{ $totalPertemuan }}</td>
                    <td>{{ $hadir }}</td>
                    <td>{{ $izin }}</td>
                    <td>{{ $sakit }}</td>
                    <td>{{ $alpa }}</td>
                    <td>{{ $belum < 0 ? 0 : $belum }}</td>
                    <td class="{{ $persen >= 75 ? 'hadir-ok' : 'hadir-fail' }}">
                        {{ $persen }}%
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">Belum ada data absensi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak dari Sistem SIAKAD SMK Hang Tuah 1 Jakarta
    </div>

</body>
</html>