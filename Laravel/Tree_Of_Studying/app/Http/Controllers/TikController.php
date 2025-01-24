<?php

namespace App\Http\Controllers;

use App\Models\Tik;
use Illuminate\Http\Request;

class TikController extends Controller
{
    public function getTitles()
    {
        // Ambil kolom 'title' dari tabel 'tik'
        $titles = Tik::pluck('title');
        return response()->json($titles);
    }
}

