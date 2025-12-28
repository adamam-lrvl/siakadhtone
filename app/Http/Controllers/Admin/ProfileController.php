<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . Auth::id(),
            'no_hp'   => 'nullable|string|max:20',
            'alamat'  => 'nullable|string|max:500',
        ]);

        Auth::user()->update($request->only('name', 'email', 'no_hp', 'alamat'));

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}