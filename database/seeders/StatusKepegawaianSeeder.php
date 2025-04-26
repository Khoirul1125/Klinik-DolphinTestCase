<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusKepegawaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusKepegawaian = [
            ['nama' => 'Pegawai Tetap'],
            ['nama' => 'Pegawai Kontrak'],
            ['nama' => 'Pegawai Honorer'],
            ['nama' => 'Pegawai Tamu'],
            ['nama' => 'Magang'],
            ['nama' => 'Tenaga Harian Lepas'],
            ['nama' => 'Pekerja Paruh Waktu'],
            ['nama' => 'Pekerja Freelance'],
            ['nama' => 'Tenaga Sukarela'],
        ];

        DB::table('statdoks')->insert($statusKepegawaian);
    }
}
