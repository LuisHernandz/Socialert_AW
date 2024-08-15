<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleHasPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ID del rol al que se asignarán los permisos
        $roleId = 1;

        // Obtener todos los permisos
        $permissions = DB::table('permissions')->pluck('id')->toArray();

        // Crear un array para los registros de la tabla role_has_permissions
        $roleHasPermissions = [];

        foreach ($permissions as $permissionId) {
            $roleHasPermissions[] = [
                'permission_id' => $permissionId, // Ajustar según el nombre del campo en la migración
                'role_id' => $roleId,
            ];
        }

        // Insertar los permisos para el rol en la base de datos
        DB::table('role_has_permissions')->insert($roleHasPermissions);
    
    }
}
