<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    protected function redirectTo()
    {
        $user = Auth::user();
        if ($user->isAdmin())         return '/admin/dashboard';
        if ($user->isGuru())          return '/guru/dashboard';
        if ($user->isKepalaSekolah()) return '/kepala-sekolah/dashboard'; 
        return '/siswa/dashboard';
    }
}