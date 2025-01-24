<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Coba extends BaseController
{

    private $model;
    private $modul;

    public function __construct()
    {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function index()
    {

    }

    
}
