<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Mapel;

class DashboardController extends Controller
{
    public function index()
    {
        $activities = Activity::with(['causer', 'subject'])
        ->latest()
        ->take(10)
        ->get();
        $totalGuru   = Guru::count();
        $totalSiswa  = Siswa::count();
        $totalKelas  = Kelas::count();
        $totalMapel  = Mapel::count();

        return view('admin.dashboard', compact(
            'totalGuru',
            'totalSiswa',
            'totalKelas',
            'totalMapel',
            'activities',
        ));
    }
}
