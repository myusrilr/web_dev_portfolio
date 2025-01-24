<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrangTuaController extends Controller
{
    public function index()
    {
        // Ambil role user yang sedang login
        $userRole = Auth::user()->role; // Pastikan kolom 'role' ada di tabel user

        // Kirim data role ke view
        return view('orangtua.dashboard', ['userRole' => $userRole]);
    }
}