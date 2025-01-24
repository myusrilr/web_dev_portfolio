<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    // Nonaktifkan foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    // Hapus semua data di tabel users dan reset ID
    User::truncate();

    // Aktifkan kembali foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    // Tambahkan data pengguna baru
    \App\Models\User::create([
        'name' => 'satrio',
        'email' => 'satrio@example.com',
        'password' => bcrypt('admin'),
        'role' => 'guru',
    ]);

    \App\Models\User::create([
        'name' => 'vino',
        'email' => 'vino@example.com',
        'password' => bcrypt('user'),
        'role' => 'murid',
    ]);

    \App\Models\User::create([
        'name' => 'hamaz',
        'email' => 'hamaz@example.com',
        'password' => bcrypt('user'),
        'role' => 'murid',
    ]);

    \App\Models\User::create([
        'name' => 'alif',
        'email' => 'alif@example.com',
        'password' => bcrypt('user'),
        'role' => 'murid',
    ]);

    \App\Models\User::create([
        'name' => 'yasin',
        'email' => 'yasin@example.com',
        'password' => bcrypt('user'),
        'role' => 'murid',
    ]);

    \App\Models\User::create([
        'name' => 'rafli',
        'email' => 'rafli@example.com',
        'password' => bcrypt('user'),
        'role' => 'orang_tua',
    ]);

    \App\Models\User::create([
        'name' => 'umri',
        'email' => 'umri@example.com',
        'password' => bcrypt('user'),
        'role' => 'orang_tua',
    ]);

    \App\Models\User::create([
        'name' => 'taqy',
        'email' => 'taqy@example.com',
        'password' => bcrypt('user'),
        'role' => 'orang_tua',
    ]);

    \App\Models\User::create([
        'name' => 'yusril',
        'email' => 'yusril@example.com',
        'password' => bcrypt('user'),
        'role' => 'orang_tua',
    ]);
}

}
