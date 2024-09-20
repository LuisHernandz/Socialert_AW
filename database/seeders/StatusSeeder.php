<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status')->insert([
            ['name' => 'Pendiente'],
            ['name' => 'En Proceso'],
            ['name' => 'Atendida'],
            ['name' => 'No Atendida'],
            ['name' => 'Falsa'],
        ]);
    }
}
