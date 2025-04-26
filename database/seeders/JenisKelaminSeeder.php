<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisKelaminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisKelamin = [
            ['nama' => 'Laki-laki', 'kode' => 'L'],
            ['nama' => 'Perempuan', 'kode' => 'P'],
            ['nama' => 'Tidak Diketahui', 'kode' => 'T'],
            ['nama' => 'Lainnya', 'kode' => 'X'],
        ];

        DB::table('seks')->insert($jenisKelamin);
    }
}
