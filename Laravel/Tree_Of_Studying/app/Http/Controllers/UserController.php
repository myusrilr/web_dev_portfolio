<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getMuridData()
    {
        $users = User::where('role', 'murid')->inRandomOrder()->limit(10)->get();

        return response()->json($users);
    }
}

