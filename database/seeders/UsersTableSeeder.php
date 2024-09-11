<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Juan',
            'lastname' => 'Ruíz',
            'email' => 'juanruiz@gmail.com',
            'password' => Hash::make('Admin123'), // Encriptar la contraseña
            'status' => 'activo',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(), 
        ]);
    }
}
