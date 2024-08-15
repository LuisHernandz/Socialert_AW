<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelHasRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleId = 1;
        $userId = 1;

        // Insertar el rol asignado al usuario
        DB::table('model_has_roles')->insert([
            'role_id' => $roleId,
            'model_type' => 'App\Models\User', // Asegúrate de que model_type coincida con el tipo de modelo
            'model_id' => $userId,
        ]);
    }
}
