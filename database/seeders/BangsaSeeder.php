<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BangsaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bangsa = [
            ['nama_bangsa' => 'Indonesia'],
            ['nama_bangsa' => 'Malaysia'],
            ['nama_bangsa' => 'Filipina'],
            ['nama_bangsa' => 'Thailand'],
            ['nama_bangsa' => 'Vietnam'],
            ['nama_bangsa' => 'Singapura'],
            ['nama_bangsa' => 'Myanmar'],
            ['nama_bangsa' => 'Laos'],
            ['nama_bangsa' => 'Kamboja'],
            ['nama_bangsa' => 'Brunei'],
            ['nama_bangsa' => 'Tiongkok'],
            ['nama_bangsa' => 'Jepang'],
            ['nama_bangsa' => 'Korea Selatan'],
            ['nama_bangsa' => 'India'],
            ['nama_bangsa' => 'Pakistan'],
            ['nama_bangsa' => 'Arab Saudi'],
            ['nama_bangsa' => 'Amerika Serikat'],
            ['nama_bangsa' => 'Inggris'],
            ['nama_bangsa' => 'Jerman'],
            ['nama_bangsa' => 'Perancis'],
            ['nama_bangsa' => 'Italia'],
            ['nama_bangsa' => 'Spanyol'],
            ['nama_bangsa' => 'Belanda'],
            ['nama_bangsa' => 'Rusia'],
            ['nama_bangsa' => 'Australia'],
            ['nama_bangsa' => 'Afrika Selatan'],
            ['nama_bangsa' => 'Brazil'],
            ['nama_bangsa' => 'Argentina'],
            ['nama_bangsa' => 'Meksiko'],
            ['nama_bangsa' => 'Kanada'],
        ];

        DB::table('bangsas')->insert($bangsa);
    }
}
