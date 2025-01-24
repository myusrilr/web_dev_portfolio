<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tik extends Model
{
    use HasFactory;

    protected $table = 'tik'; // Nama tabel
    protected $fillable = ['title']; // Kolom yang bisa diisi
}

