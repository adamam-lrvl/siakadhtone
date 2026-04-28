<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Absensi;
use App\Models\Nilai;
use App\Models\Pengumuman;

class DashboardController extends Controller
{
    public function index()
    {
        // STAT CARDS
        $totalSiswa  = Siswa::count();
        $totalGuru   = Guru::count();
        $totalKelas  = Kelas::count();
        $pendingPengumuman = Pengumuman::pending()->count();

        // CHART 1: Siswa per jurusan
        // Extract jurusan dari nama_kelas (contoh: "X BDP 1" → "BDP")
        $siswasPerJurusan = Kelas::withCount('siswas')->get()
            ->groupBy(function ($kelas) {
                $nama = trim($kelas->nama_kelas);

                // Hapus prefix tingkat kelas di awal (X, XI, XII)
                $nama = preg_replace('/^(XII|XI|X)\s+/i', '', $nama);

                // Hapus angka di akhir
                $nama = preg_replace('/\s+\d+$/', '', $nama);

                return strtoupper(trim($nama)) ?: $kelas->nama_kelas;
            })
            ->map(fn($group) => $group->sum('siswas_count'));

        // CHART 2: Statistik absensi bulan ini
        $absensiStats = Absensi::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // CHART 3: Siswa per kelas
        $siswasPerKelas = Kelas::withCount('siswas')
            ->get()
            ->pluck('siswas_count', 'nama_kelas');

        return view('kepala-sekolah.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'pendingPengumuman',
            'siswasPerJurusan',
            'absensiStats',
            'siswasPerKelas'
        ));
    }
}