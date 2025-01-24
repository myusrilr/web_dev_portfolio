<?php

namespace App\Http\Controllers;

use App\Models\BijiIde;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MuridController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Ambil pengguna yang login
        return view('murid.dashboard', compact('user')); // Kirimkan $user ke view
    }

    public function create()
    {
        // Tampilkan halaman form untuk menambahkan Biji Ide baru
        return view('murid.create-biji');
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nama' => 'required',
            'ide' => 'required',
            'cita_cita' => 'required',
            'deskripsi' => 'required',
        ]);

        // Simpan data ke database
        BijiIde::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'ide' => $request->ide,
            'cita_cita' => $request->cita_cita,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('murid.create-biji')->with('success', 'Biji Ide berhasil ditambahkan.');
    }
}
