<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSiswa extends Model
{
    protected $table = "siswa";
    protected $primaryKey = "id";
    protected $allowedFields = ['nama', 'email'];

    function cari($katakunci)
    {
        //budi gmail
        $builder = $this->table("siswa");
        $arr_katakunci = explode(" ", $katakunci);
        for ($x = 0; $x < count($arr_katakunci); $x++) {
            $builder->orLike('nama', $arr_katakunci[$x]);
            $builder->orLike('email', $arr_katakunci[$x]);
        }
        return $builder;
    }
}
