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

        // PAKAI 'pengumumans' — SAMA PERSIS KAYAK DI VIEW!
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
            'aktif'   => 'sometimes|boolean',
        ]);

        Pengumuman::create($request->all());

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.pengumuman.show', compact('pengumuman'));
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id); // INI YANG WAJIB ADA!!!
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([
            'judul'   => 'required|string|max:255',
            'isi'     => 'required',
            'tanggal' => 'required|date',
        ]);

        $pengumuman->update($request->all());

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function upload(Request $request)
    {
        $request->validate(['file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048']);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('pengumuman', $filename, 'public');

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