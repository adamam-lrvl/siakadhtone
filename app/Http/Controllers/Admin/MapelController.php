<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;

class MapelController extends Controller
{
    public function index(Request $request)
    {
        $mapel = Mapel::when($request->search, function ($q) use ($request) {
        $q->where('nama_mapel', 'like', '%' . $request->search . '%')
        ->orWhere('kode', 'like', '%' . $request->search . '%');
        })
        ->paginate(10);

    return view('admin.mapel.index', compact('mapel'));
    }

    public function create()
    {
        return view('admin.mapel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:mapels,kode',
            'nama_mapel' => 'required',
        ]);

        Mapel::create([
            'kode' => $request->kode,
            'nama_mapel' => $request->nama_mapel,
        ]);

        return redirect()->route('admin.mapel.index')->with('success', 'Mapel berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $mapel = Mapel::findOrFail($id);
        return view('admin.mapel.edit', compact('mapel')); 
    }

    public function update(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);

        $request->validate([
            'kode' => 'required|unique:mapels,kode,' . $mapel->id,
            'nama_mapel' => 'required',
            'kkm' => 'required|numeric|min:0|max:100',
            'kategori' => 'required|in:wajib,peminatan',
        ]);

        $mapel->update($request->all());

        return redirect()->route('admin.mapel.index')->with('success', 'Mapel berhasil diperbarui!');
    }

    public function destroy(Mapel $mapel)
    {
        $mapel->delete();
        return redirect()->route('admin.mapel.index')->with('success', 'Mapel berhasil dihapus!');
    }
}
