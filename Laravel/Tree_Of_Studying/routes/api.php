<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Tambahkan ini untuk mengimpor UserController

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Default route bawaan Laravel
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Tambahkan route API baru di bawah ini
Route::get('/users/murid', [UserController::class, 'getMuridData']);
