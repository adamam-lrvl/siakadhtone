<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Nilai {{ $kelas->nama_kelas }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; color: #000; margin: 20px; }
        .title { text-align: center; font-size: 14px; font-weight: bold; margin-bottom: 5px; color: #1e40af; }
        .info { margin-bottom: 15px; }
        .info td { padding: 2px 6px; font-size: 10px; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th { background-color: #1e40af; color: #fff; border: 1px solid #000; padding: 5px; text-align: center; font-size: 9px; }
        table.data td { border: 1px solid #000; padding: 4px; text-align: center; font-size: 9px; }
        table.data td.left { text-align: left; }
        table.data tbody tr:nth-child(even) { background-color: #f0f4ff; }
        .predikat-A { color: #16a34a; font-weight: bold; }
        .predikat-B { color: #2563eb; font-weight: bold; }
        .predikat-C { color: #d97706; font-weight: bold; }
        .predikat-D { color: #ea580c; font-weight: bold; }
        .predikat-E { color: #dc2626; font-weight: bold; }
        .footer { margin-top: 20px; text-align: right; font-size: 9px; color: #555; }
    </style>
</head>
<body>
    <div class="title">LAPORAN NILAI SISWA</div>

    <table class="info">
        <tr><td><b>Kelas</b></td><td>: {{ $kelas->nama_kelas }}</td>
            <td><b>Wali Kelas</b></td><td>: {{ $kelas->waliKelas->nama ?? '-' }}</td></tr>
        <tr><td><b>Semester</b></td><td>: {{ $semester }} ({{ $semester == 1 ? 'Ganjil' : 'Genap' }})</td>
            <td><b>Tanggal Cetak</b></td><td>: {{ now()->translatedFormat('d F Y') }}</td></tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th rowspan="2" style="width:4%">No</th>
                <th rowspan="2" style="width:8%">NIS</th>
                <th rowspan="2" style="width:16%">Nama Siswa</th>
                @foreach($mapels as $mapel)
                    <th colspan="3">{{ $mapel->nama_mapel }}</th>
                @endforeach
            </tr>
            <tr>
                @foreach($mapels as $mapel)
                    <th style="width:5%">Tgs</th>
                    <th style="width:5%">UTS</th>
                    <th style="width:5%">UAS</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rekap as $index => $r)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $r->siswa->nis }}</td>
                <td class="left">{{ $r->siswa->nama }}</td>
                @foreach($mapels as $mapel)
                    @php $n = $r->nilaiPerMapel[$mapel->id] ?? null; @endphp
                    <td>{{ $n['tugas'] ?? '-' }}</td>
                    <td>{{ $n['uts'] ?? '-' }}</td>
                    <td class="predikat-{{ $n['predikat'] ?? '' }}">{{ $n['predikat'] ?? '-' }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">Dicetak dari Sistem SIAKAD SMK Hang Tuah 1 Jakarta</div>
</body>
</html>