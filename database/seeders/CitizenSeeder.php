<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitizenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('citizens')->insert([
            [
                'phone' => '1234567890',
                'gender' => 'M',
                'curp' => 'ABC123456789XYZ0',
                'user_id' => 2,
            ],
            [
                'phone' => '0987654321',
                'gender' => 'F',
                'curp' => 'XYZ987654321ABC1',
                'user_id' => 3,
            ],
            [
                'phone' => '1122334455',
                'gender' => 'M',
                'curp' => 'DEF123456789XYZ2',
                'user_id' => 4,
            ],
            [
                'phone' => '2233445566',
                'gender' => 'F',
                'curp' => 'GHI123456789XYZ3',
                'user_id' => 5,
            ],
            [
                'phone' => '3344556677',
                'gender' => 'N',
                'curp' => 'JKL123456789XYZ4',
                'user_id' => 6,
            ],
            [
                'phone' => '4455667788',
                'gender' => 'M',
                'curp' => 'MNO123456789XYZ5',
                'user_id' => 7,
            ],
        ]);
        
    }
}
