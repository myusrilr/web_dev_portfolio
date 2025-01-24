<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BijiIde;
use App\Models\Task;
use App\Models\User; // Mengimpor model User untuk mengakses data dari tabel users
use App\Models\Project; // Impor model Project
use Illuminate\Support\Facades\Auth;
use App\Models\Biji;

class GuruController extends Controller
{
    public function landing_brain()
    {
        // Logika untuk data atau tampilan di landing page
        return view('guru.landing-brain');
    }

    public function landing_island()
    {
        // Logika untuk data atau tampilan di landing page
        return view('guru.landing-island');
    }
    
    public function index()
    {
        // Ambil role user yang sedang login
        $userRole = Auth::user()->role;

        // Kirim data role ke view
        return view('guru.dashboard', ['userRole' => $userRole]);
    }

    public function bijiIde()
    {
        // Ambil role user yang sedang login
        $userRole = Auth::user()->role;

        // Ambil semua data Biji Ide
        $biji = BijiIde::all();

        // Kirim data $biji dan $userRole ke view
        return view('guru.biji-ide', ['biji' => $biji, 'userRole' => $userRole]);
    }

    public function editBiji($id)
{
    $biji = Biji::findOrFail($id); // Model Biji digunakan sebagai contoh
    return view('guru.edit-biji', compact('biji'));
}

    public function createTask()
{
// Ambil semua data murid dari tabel users yang memiliki role 'murid'
$students = User::where('role', 'murid')->get();
    $projects = Project::all(); // Ambil semua data proyek jika ada

    return view('guru.create-task', compact('students', 'projects'));
}

public function storeTask(Request $request)
{
    // Validasi input
    $request->validate([
        'assignee' => 'required',
        'status' => 'required',
        'project' => 'required',
        'due_date' => 'required|date',
        'priority' => 'required',
        'description' => 'nullable|string',
    ]);

    // Logika untuk menyimpan tugas ke database
    Task::create([
        'assignee' => $request->assignee,
        'status' => $request->status,
        'project' => $request->project,
        'due_date' => $request->due_date,
        'priority' => $request->priority,
        'description' => $request->description,
    ]);

    return redirect()->route('guru.biji-ide')->with('success', 'Tugas berhasil ditambahkan');
}
}
