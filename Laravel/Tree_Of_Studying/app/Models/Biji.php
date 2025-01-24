<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biji extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'bijis';

    // Field yang bisa diisi (mass assignable)
    protected $fillable = ['nama', 'ide', 'cita_cita', 'deskripsi'];
}