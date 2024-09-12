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
            [
                'name' => 'Juan',
                'lastname' => 'Ruíz',
                'email' => 'juanruiz@gmail.com',
                'password' => Hash::make('Admin123'),
                'status' => 'activo',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(), 
            ],
            [
                'name' => 'María',
                'lastname' => 'Pérez',
                'email' => 'mariaperez@gmail.com',
                'password' => Hash::make('User123'),
                'status' => 'activo',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Carlos',
                'lastname' => 'Gómez',
                'email' => 'carlosgomez@gmail.com',
                'password' => Hash::make('User123'),
                'status' => 'activo',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laura',
                'lastname' => 'Ramírez',
                'email' => 'lauraramirez@gmail.com',
                'password' => Hash::make('User123'),
                'status' => 'activo',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Miguel',
                'lastname' => 'Hernández',
                'email' => 'miguelhernandez@gmail.com',
                'password' => Hash::make('User123'),
                'status' => 'activo',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ana',
                'lastname' => 'López',
                'email' => 'analopez@gmail.com',
                'password' => Hash::make('User123'),
                'status' => 'activo',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'David',
                'lastname' => 'Fernández',
                'email' => 'davidfernandez@gmail.com',
                'password' => Hash::make('User123'),
                'status' => 'activo',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'name' => 'Sara',
            //     'lastname' => 'Torres',
            //     'email' => 'saratorres@gmail.com',
            //     'password' => Hash::make('User123'),
            //     'status' => 'activo',
            //     'remember_token' => null,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
        ]);
    }

}
