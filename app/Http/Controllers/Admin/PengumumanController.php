<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $pengumumans = Pengumuman::when($search, function($query) use ($search) {
                            $query->where('judul', 'like', '%'.$search.'%');
                        })
                        ->latest()
                        ->paginate(10);

        return view('admin.pengumuman.index', compact('pengumumans'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'   => 'required|string|max:255',
            'isi'     => 'required',
            'tanggal' => 'required|date',
        ]);

        Pengumuman::create([
            'judul'   => $request->judul,
            'isi'     => $request->isi,
            'tanggal' => $request->tanggal,
            'aktif'   => false,       // ← default false dulu
            'status'  => 'pending',   // ← selalu pending saat dibuat admin
        ]);

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dikirim & menunggu persetujuan kepala sekolah!');
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.pengumuman.show', compact('pengumuman'));
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        // Kalau sudah approved, tidak bisa diedit
        if ($pengumuman->status === 'approved') {
            return redirect()
                ->route('admin.pengumuman.index')
                ->with('error', 'Pengumuman yang sudah disetujui tidak dapat diedit!');
        }

        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        // Kalau sudah approved, tidak bisa diupdate
        if ($pengumuman->status === 'approved') {
            return redirect()
                ->route('admin.pengumuman.index')
                ->with('error', 'Pengumuman yang sudah disetujui tidak dapat diubah!');
        }

        $request->validate([
            'judul'   => 'required|string|max:255',
            'isi'     => 'required',
            'tanggal' => 'required|date',
        ]);

        $pengumuman->update([
            'judul'   => $request->judul,
            'isi'     => $request->isi,
            'tanggal' => $request->tanggal,
            'status'  => 'pending', // ← reset ke pending kalau diedit ulang
        ]);

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman diperbarui & dikirim ulang untuk persetujuan!');
    }

    public function upload(Request $request)
    {
        $request->validate(['file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048']);

        $file     = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path     = $file->storeAs('pengumuman', $filename, 'public');

        return response()->json([
            'location' => asset('storage/pengumuman/' . $filename)
        ]);
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();
        return back()->with('success', 'Pengumuman berhasil dihapus!');
    }
}