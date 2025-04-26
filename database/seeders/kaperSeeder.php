<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kaperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('katpers')->insert([
            [
                'kode_rawatan' => 'ADM',
                'nama_rawatan' => 'ADMINISTRASI'
            ],
            [
                'nama' => 'KNS',
                'skor' => 'KONSULTASI'
            ]
        ]);
    }
}
