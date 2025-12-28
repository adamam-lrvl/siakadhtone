<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index()
    {
        // EAGER LOAD MAPELS (MANY-TO-MANY)
        $gurus = Guru::with(['user', 'mapels'])->paginate(15);
        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        $mapels = Mapel::all();
        return view('admin.guru.create', compact('mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:gurus,nip',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'mapel_id' => 'required|array', // BANYAK MAPEL
            'mapel_id.*' => 'exists:mapels,id',
        ]);

        // BUAT USER GURU
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        // BUAT DATA GURU
        $guru = Guru::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        // ATTACH BANYAK MAPEL KE GURU (MANY-TO-MANY)
        $guru->mapels()->attach($request->mapel_id);

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan!');
    }

    public function edit(Guru $guru)
    {
        $mapels = Mapel::all();
        // LOAD MAPEL YANG SUDAH DIAJAR
        $guru->load('mapels');
        return view('admin.guru.edit', compact('guru', 'mapels'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nip' => 'required|unique:gurus,nip,' . $guru->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $guru->user_id,
            'telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'mapel_id' => 'required|array',
            'mapel_id.*' => 'exists:mapels,id',
        ]);

        // UPDATE USER
        $guru->user->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);

        // UPDATE GURU
        $guru->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        // SYNC MAPEL (UPDATE BANYAK MAPEL)
        $guru->mapels()->sync($request->mapel_id);

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil diperbarui!');
    }

    public function destroy(Guru $guru)
    {
        // HAPUS RELASI MAPEL DULU (BIAR GAK ERROR)
        $guru->mapels()->detach();

        // HAPUS USER & GURU
        $guru->user->delete();
        $guru->delete();

        return back()->with('success', 'Guru berhasil dihapus!');
    }
}