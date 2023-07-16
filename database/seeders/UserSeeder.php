<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Riziq Ramadhan',
                'email' => 'mriziq54@gmail.com',
                'password' => bcrypt('123456')
            ],
            [
                'name' => 'Shierra Intan Anggari',
                'email' => 'secha@gmail.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'Arung',
                'email' => 'arung@gmail.com',
                'password' => bcrypt('123456')
            ]
        ];
        User::insert($users);
    }
}