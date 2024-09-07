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
            ['name' => 'Robo'],
            ['name' => 'Asalto'],
            ['name' => 'Vandalismo'],
            ['name' => 'Violencia doméstica'],
            ['name' => 'Accidente vehicular'],
        ]);
    }
}
