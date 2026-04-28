<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $pending  = Pengumuman::pending()->latest()->get();
        $approved = Pengumuman::where('status', 'approved')->latest()->get();
        $rejected = Pengumuman::where('status', 'rejected')->latest()->get();

        return view('kepala-sekolah.pengumuman.index', compact(
            'pending', 'approved', 'rejected'
        ));
    }

    public function show(Pengumuman $pengumuman)
    {
        return view('kepala-sekolah.pengumuman.show', compact('pengumuman'));
    }

    public function approve(Pengumuman $pengumuman)
    {
        $pengumuman->update([
            'status'      => 'approved',
            'aktif'       => true,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($pengumuman)
            ->log('Menyetujui pengumuman: ' . $pengumuman->judul);

        return back()->with('success', 'Pengumuman berhasil disetujui & dipublikasikan!');
    }

    public function reject(Request $request, Pengumuman $pengumuman)
    {
        $pengumuman->update([
            'status'      => 'rejected',
            'aktif'       => false,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($pengumuman)
            ->log('Menolak pengumuman: ' . $pengumuman->judul);

        return back()->with('success', 'Pengumuman berhasil ditolak.');
    }
}