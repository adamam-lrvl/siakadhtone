<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Siswa;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = $user->guru;

        if (!$guru) {
            abort(403, 'Data profil guru tidak ditemukan.');
        }

        // TOTAL KELAS YANG DIAJAR (distinct kelas_id)
        $totalKelas = Jadwal::where('guru_id', $guru->id)
                            ->distinct('kelas_id')
                            ->count('kelas_id');

        // TOTAL SISWA DI SEMUA KELAS YANG DIAJAR
        $kelasIds = Jadwal::where('guru_id', $guru->id)->pluck('kelas_id')->unique();
        $totalSiswa = Siswa::whereIn('kelas_id', $kelasIds)->count();

        // TOTAL MAPEL YANG DIAJAR
        $mapelDiajar = Jadwal::where('guru_id', $guru->id)
                             ->distinct('mapel_id')
                             ->count('mapel_id');

        // JADWAL HARI INI — FIX BUAT BAHASA INDONESIA
        $hariIndonesia = Carbon::today()->translatedFormat('l');
        $hariUpper     = strtoupper($hariIndonesia);

        $jadwalHariIni = Jadwal::where('guru_id', $guru->id)
            ->whereRaw('UPPER(hari) = ?', [$hariUpper])
            ->with(['kelas', 'mapel'])
            ->orderBy('jam_mulai')
            ->get();

        
        $jadwalMingguIni = Jadwal::where('guru_id', $user->guru->id)
            ->with(['mapel', 'kelas'])
            ->whereIn('hari', ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'])
            ->get();

        return view('guru.dashboard', compact(
            'guru',
            'totalKelas',
            'totalSiswa',
            'mapelDiajar',
            'jadwalHariIni',
            'jadwalMingguIni'
        ));
    }
}