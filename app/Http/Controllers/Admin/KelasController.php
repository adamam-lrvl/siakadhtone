<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Guru;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['waliKelas'])
                  ->withCount('siswas')  
                  ->paginate(10);

    return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        $gurus = Guru::orderBy('nama', 'asc')->get();
        return view('admin.kelas.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kelas' => 'required|unique:kelas,kode_kelas',
            'nama_kelas' => 'required',
            'wali_kelas_id' => 'nullable|exists:gurus,id',
        ]);

        Kelas::create([
            'kode_kelas' => $request->kode_kelas,
            'nama_kelas' => $request->nama_kelas,
            'wali_kelas_id' => $request->wali_kelas_id,
        ]);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $gurus = Guru::orderBy('nama', 'asc')->get();
        return view('admin.kelas.edit', compact('kelas', 'gurus'));
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'kode_kelas' => 'required|unique:kelas,kode_kelas,' . $kelas->id,
            'nama_kelas' => 'required',
            'wali_kelas_id' => 'nullable|exists:gurus,id',
        ]);

        $kelas->update([
            'kode_kelas' => $request->kode_kelas,
            'nama_kelas' => $request->nama_kelas,
            'wali_kelas_id' => $request->wali_kelas_id,
        ]);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);

        
        if (method_exists($kelas, 'siswas')) {
            $kelas->siswas()->delete();
        }
        if (method_exists($kelas, 'jadwal')) {
            $kelas->jadwal()->delete();
        }

        $kelas->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }
}
