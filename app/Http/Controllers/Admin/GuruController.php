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
        $gurus = Guru::with('user', 'mapel')->paginate(15);
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
            'mapel_id' => 'nullable|exists:mapels,id',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        Guru::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'mapel_id' => $request->mapel_id,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan!');
    }

    public function edit(Guru $guru)
    {
        $mapels = Mapel::all();
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
            'mapel_id' => 'nullable|exists:mapels,id',
        ]);

        $guru->user->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);

        $guru->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'mapel_id' => $request->mapel_id,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil diperbarui!');
    }

    public function destroy(Guru $guru)
    {
        $guru->user->delete();
        $guru->delete();
        return back()->with('success', 'Guru berhasil dihapus!');
    }
}