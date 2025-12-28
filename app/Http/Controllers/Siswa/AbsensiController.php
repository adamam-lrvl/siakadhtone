<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;

        
        $absensis = Absensi::where('siswa_id', $siswa->id)
            ->with('jadwal.mapel', 'jadwal.guru')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->paginate(20);

        return view('siswa.absensi.index', compact('absensis'));
    }
}