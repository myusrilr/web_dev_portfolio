<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tik;

class TikSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['title' => 'Pengenalan Pengembangan Web'], 
            ['title' => 'HTML'],
            ['title' => 'CSS'],
            ['title' => 'JavaScript'],
            ['title' => 'PHP'],
        ];

        foreach ($data as $item) {
            Tik::create($item);
        }
    }
}
