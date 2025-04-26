<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suku = [
            // Suku di Indonesia
            ['nama_suku' => 'Jawa'],
            ['nama_suku' => 'Sunda'],
            ['nama_suku' => 'Batak'],
            ['nama_suku' => 'Minangkabau'],
            ['nama_suku' => 'Bugis'],
            ['nama_suku' => 'Madura'],
            ['nama_suku' => 'Bali'],
            ['nama_suku' => 'Dayak'],
            ['nama_suku' => 'Toraja'],
            ['nama_suku' => 'Sasak'],
            ['nama_suku' => 'Banjar'],
            ['nama_suku' => 'Betawi'],
            ['nama_suku' => 'Ambon'],
            ['nama_suku' => 'Papua'],
            ['nama_suku' => 'Aceh'],

            // Suku di luar negeri
            ['nama_suku' => 'Han (Tiongkok)'],
            ['nama_suku' => 'Yamato (Jepang)'],
            ['nama_suku' => 'Koreans (Korea)'],
            ['nama_suku' => 'Punjabi (India, Pakistan)'],
            ['nama_suku' => 'Zulu (Afrika Selatan)'],
            ['nama_suku' => 'Maori (Selandia Baru)'],
            ['nama_suku' => 'Cherokee (Amerika Utara)'],
            ['nama_suku' => 'Inuit (Kanada, Greenland)'],
            ['nama_suku' => 'Berber (Afrika Utara)'],
            ['nama_suku' => 'Aztec (Meksiko)'],
            ['nama_suku' => 'Quechua (Peru, Andes)'],
            ['nama_suku' => 'Sami (Skandinavia)'],
            ['nama_suku' => 'Basque (Spanyol, Prancis)'],
            ['nama_suku' => 'Mongol (Mongolia)'],
            ['nama_suku' => 'Bedouin (Timur Tengah)'],
        ];

        DB::table('sukus')->insert($suku);
    }
}
