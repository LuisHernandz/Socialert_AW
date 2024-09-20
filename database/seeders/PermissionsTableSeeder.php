<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'consultar usuarios web', 'guard_name' => 'sanctum'],
            ['name' => 'crear usuarios web', 'guard_name' => 'sanctum'],
            ['name' => 'editar usuarios web', 'guard_name' => 'sanctum'],
            ['name' => 'eliminar usuarios web', 'guard_name' => 'sanctum'],

            ['name' => 'consultar ciudadanos', 'guard_name' => 'sanctum'],
            ['name' => 'eliminar ciudadanos', 'guard_name' => 'sanctum'],

            ['name' => 'consultar reportes', 'guard_name' => 'sanctum'],
            ['name' => 'editar reportes', 'guard_name' => 'sanctum'],
            ['name' => 'eliminar reportes', 'guard_name' => 'sanctum'],

            ['name' => 'crear roles', 'guard_name' => 'sanctum'],
            ['name' => 'editar roles', 'guard_name' => 'sanctum'],
            ['name' => 'eliminar roles', 'guard_name' => 'sanctum'],

            ['name' => 'backup', 'guard_name' => 'sanctum'],
        ];

        // Insertar los permisos en la base de datos
        DB::table('permissions')->insert($permissions);
    }
}
