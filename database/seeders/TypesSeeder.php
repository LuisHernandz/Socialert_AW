<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            ['name' => 'Alerta'],
            ['name' => 'Emergencia médica'],
            ['name' => 'Enfrentamiento'],
            ['name' => 'Extorsión'],
            ['name' => 'Fraude'],
            ['name' => 'Homicidio'],
            ['name' => 'Incidente de tránsito'],
            ['name' => 'Maltrato animal'],
            ['name' => 'Robo'],
            ['name' => 'Secuestro'],
            ['name' => 'Violencia contra la mujer'],
            ['name' => 'Violencia doméstica'],
        ]);
    }
}
