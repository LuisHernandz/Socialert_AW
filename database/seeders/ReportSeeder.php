<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reports')->insert([
            [
                'description' => 'Robo de camioneta Nissan',
                'calification' => NULL,
                'file' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'type_id' => 1, 
                'status_id' => 1, 
                'citizen_id' => 1, 
            ],
            [
                'description' => '',
                'calification' => 9,
                'file' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'type_id' => 2, 
                'status_id' => 2,
                'citizen_id' => 1,
            ],
            [
                'description' => 'Intento de asalto en combi',
                'calification' => 7,
                'file' => '',
                'created_at' => now(),
                'updated_at' => now(),
                'type_id' => 3,
                'status_id' => 3,
                'citizen_id' => 1,
            ],
        ]);
    }
}
