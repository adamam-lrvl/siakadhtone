<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;

        $jadwals = Jadwal::whereHas('kelas.siswas', function ($q) use ($siswa) {
            $q->where('id', $siswa->id);
        })
        ->with(['mapel', 'guru'])
        ->orderBy('hari')
        ->orderBy('jam_mulai')
        ->get()
        ->groupBy('hari');

        $hariUrut = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        return view('siswa.jadwal.index', compact('jadwals', 'hariUrut'));
    }
}