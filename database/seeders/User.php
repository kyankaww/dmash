<?php

namespace Database\Seeders;

use App\Models\User as ModelsUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class User extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsUser::create([
            'username' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'nik' => '00000000',
            'fullname' => 'Kyanka Wisnu Wardhana',
            'email' => 'admin@gmail.com',
            'no_hp' => '081234567890',
            'role' => 'admin',
        ]);
    }
}
