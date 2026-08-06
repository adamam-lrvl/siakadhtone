<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $pengumumans = Pengumuman::when($search, function ($query) use ($search) {
                            $query->where('judul', 'like', '%' . $search . '%');
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
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'judul'   => $request->judul,
            'isi'     => $request->isi,
            'tanggal' => $request->tanggal,
            'aktif'   => false,
            'status'  => 'pending',
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('pengumuman/thumbnail', 'public');
        }

        Pengumuman::create($data);

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

        if ($pengumuman->status === 'approved') {
            return redirect()
                ->route('admin.pengumuman.index')
                ->with('error', 'Pengumuman yang sudah disetujui tidak dapat diedit!');
        }

        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        if ($pengumuman->status === 'approved') {
            return redirect()
                ->route('admin.pengumuman.index')
                ->with('error', 'Pengumuman yang sudah disetujui tidak dapat diubah!');
        }

        $request->validate([
            'judul'   => 'required|string|max:255',
            'isi'     => 'required',
            'tanggal' => 'required|date',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'judul'   => $request->judul,
            'isi'     => $request->isi,
            'tanggal' => $request->tanggal,
            'status'  => 'pending',
        ];

        // Upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama kalau ada
            if ($pengumuman->gambar) {
                Storage::disk('public')->delete($pengumuman->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('pengumuman/thumbnail', 'public');
        }

        // Hapus gambar tanpa upload baru
        if ($request->hapus_gambar == '1' && !$request->hasFile('gambar')) {
            if ($pengumuman->gambar) {
                Storage::disk('public')->delete($pengumuman->gambar);
            }
            $data['gambar'] = null;
        }

        $pengumuman->update($data);

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman diperbarui & dikirim ulang untuk persetujuan!');
    }

    // Upload gambar dari TinyMCE editor
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048'
        ]);

        $file     = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path     = $file->storeAs('pengumuman', $filename, 'public');

        return response()->json([
            'location' => asset('storage/pengumuman/' . $filename)
        ]);
    }

    public function destroy(Pengumuman $pengumuman)
    {
        // Hapus file gambar dari storage kalau ada
        if ($pengumuman->gambar) {
            Storage::disk('public')->delete($pengumuman->gambar);
        }

        $pengumuman->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus!');
    }
}