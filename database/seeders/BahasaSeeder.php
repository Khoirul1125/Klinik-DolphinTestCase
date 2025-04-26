<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BahasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bahasa = [
            // Bahasa Indonesia
            ['bahasa' => 'Bahasa Indonesia'],
            ['bahasa' => 'Jawa'],
            ['bahasa' => 'Sunda'],
            ['bahasa' => 'Batak'],
            ['bahasa' => 'Minangkabau'],
            ['bahasa' => 'Bugis'],
            ['bahasa' => 'Bali'],
            ['bahasa' => 'Aceh'],
            ['bahasa' => 'Madura'],
            ['bahasa' => 'Sasak'],
            ['bahasa' => 'Dayak'],
            ['bahasa' => 'Toraja'],
            ['bahasa' => 'Papua'],

            // Bahasa Asing
            ['bahasa' => 'Inggris'],
            ['bahasa' => 'Mandarin'],
            ['bahasa' => 'Jepang'],
            ['bahasa' => 'Korea'],
            ['bahasa' => 'Arab'],
            ['bahasa' => 'Jerman'],
            ['bahasa' => 'Perancis'],
            ['bahasa' => 'Spanyol'],
            ['bahasa' => 'Rusia'],
            ['bahasa' => 'Italia'],
            ['bahasa' => 'Hindi'],
            ['bahasa' => 'Tamil'],
            ['bahasa' => 'Portugis'],
            ['bahasa' => 'Turki'],
            ['bahasa' => 'Thailand'],
            ['bahasa' => 'Vietnam'],
            ['bahasa' => 'Filipina (Tagalog)'],
            ['bahasa' => 'Belanda'],
            ['bahasa' => 'Swedia'],
            ['bahasa' => 'Denmark'],
        ];

        DB::table('bahasas')->insert($bahasa);
    }
}
