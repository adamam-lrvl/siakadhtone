<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
$search = $request->get('search');

        $siswas = Siswa::with(['user', 'kelas'])
            ->when($search, function ($query, $search) {
                $query->where('nis', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kelas', function ($q) use ($search) {
                        $q->where('nama_kelas', 'like', "%{$search}%");
                    });
            })
            ->orderBy('nama')
            ->paginate(15)
            ->appends(['search' => $search]); // biar search tetap ada saat pagination

        return view('admin.siswa.index', compact('siswas'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'            => 'required|unique:siswas,nis',
            'nama'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:6|confirmed',
            'kelas_id'       => 'required|exists:kelas,id',
            'jenis_kelamin'  => 'required|in:L,P',
            'tanggal_lahir'  => 'nullable|date',
            'telepon'        => 'nullable|string|max:15',
            'telepon_wali'   => 'nullable|string|max:15',
            'alamat'         => 'nullable|string',
        ]);

        
        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        
        Siswa::create([
            'user_id'       => $user->id,
            'nis'           => $request->nis,
            'nama'          => $request->nama,
            'kelas_id'      => $request->kelas_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'telepon'       => $request->telepon,
            'telepon_wali'  => $request->telepon_wali,
            'alamat'        => $request->alamat,
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis'            => 'required|unique:siswas,nis,' . $siswa->id,
            'nama'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $siswa->user_id,
            'kelas_id'       => 'required|exists:kelas,id',
            'jenis_kelamin'  => 'required|in:L,P',
            'tanggal_lahir'  => 'nullable|date',
            'telepon'        => 'nullable|string|max:15',
            'telepon_wali'   => 'nullable|string|max:15',
            'alamat'         => 'nullable|string',
        ]);

        
        $siswa->user->update([
            'name'  => $request->nama,
            'email' => $request->email,
        ]);

        
        $siswa->update([
            'nis'           => $request->nis,
            'nama'          => $request->nama,
            'kelas_id'      => $request->kelas_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'telepon'       => $request->telepon,
            'telepon_wali'  => $request->telepon_wali,
            'alamat'        => $request->alamat,
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->user->delete(); 
        $siswa->delete();       

        return back()->with('success', 'Siswa berhasil dihapus!');
    }
}