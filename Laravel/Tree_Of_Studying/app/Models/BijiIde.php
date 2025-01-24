<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BijiIde extends Model
{
    use HasFactory;

    protected $table = 'biji_ide'; // Nama tabel di database

    protected $fillable = [
        'user_id',
        'nama',
        'ide',
        'cita_cita',
        'deskripsi',
    ];
}
