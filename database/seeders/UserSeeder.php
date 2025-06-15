<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tb_user')->insert([
            [
                'nama_user' => 'Hendrik Setiawan',
                'username' => 'admin',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_user' => 'Hendro Setiawan',
                'username' => 'waiter',
                'password' => Hash::make('123'),
                'role' => 'waiter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_user' => 'Fitri Sari',
                'username' => 'kasir',
                'password' => Hash::make('123'),
                'role' => 'kasir',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_user' => 'Andi Wijaya',
                'username' => 'pelanggan',
                'password' => Hash::make('123'),
                'role' => 'pelanggan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
