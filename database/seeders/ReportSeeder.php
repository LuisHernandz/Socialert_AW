<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Citizen;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si el ciudadano con id = 1 existe
        $citizen = Citizen::find(1);

        // Si existe el ciudadano, usar su ID, de lo contrario usar NULL
        $citizenId = $citizen ? $citizen->id : null;

        DB::table('reports')->insert([
            [
                'description' => 'Robo de camioneta Nissan',
                'calification' => NULL,
                'file' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'type_id' => 1, 
                'status_id' => 1, 
<<<<<<< HEAD
                'citizen_id' => $citizenId, // Usa el ID del ciudadano si existe
=======
                'citizen_id' => 2, 
>>>>>>> origin
            ],
            [
                'description' => '',
                'calification' => 9,
                'file' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'type_id' => 2, 
                'status_id' => 2,
<<<<<<< HEAD
                'citizen_id' => $citizenId, // Usa el ID del ciudadano si existe
=======
                'citizen_id' => 3,
>>>>>>> origin
            ],
            [
                'description' => 'Intento de asalto en combi',
                'calification' => 7,
                'file' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'type_id' => 3,
                'status_id' => 3,
<<<<<<< HEAD
                'citizen_id' => $citizenId, // Usa el ID del ciudadano si existe
=======
                'citizen_id' => 4,
>>>>>>> origin
            ],
        ]);
    }
}
