<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolonganDarahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $golonganDarah = [
            ['nama' => 'A', 'resus' => '+'],
            ['nama' => 'A', 'resus' => '-'],
            ['nama' => 'B', 'resus' => '+'],
            ['nama' => 'B', 'resus' => '-'],
            ['nama' => 'AB', 'resus' => '+'],
            ['nama' => 'AB', 'resus' => '-'],
            ['nama' => 'O', 'resus' => '+'],
            ['nama' => 'O', 'resus' => '-'],
            ['nama' => '-', 'resus' => '-'],
        ];

        DB::table('goldars')->insert($golonganDarah);
    }
}
