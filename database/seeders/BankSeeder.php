<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            ['nama' => 'Bank Central Asia (BCA)'],
            ['nama' => 'Bank Mandiri'],
            ['nama' => 'Bank Negara Indonesia (BNI)'],
            ['nama' => 'Bank Rakyat Indonesia (BRI)'],
            ['nama' => 'Bank Syariah Indonesia (BSI)'],
            ['nama' => 'Bank Tabungan Negara (BTN)'],
            ['nama' => 'CIMB Niaga'],
            ['nama' => 'Bank Danamon'],
            ['nama' => 'Bank Permata'],
            ['nama' => 'Bank Mega'],
            ['nama' => 'Bank OCBC NISP'],
            ['nama' => 'Bank Bukopin'],
            ['nama' => 'Bank Maybank Indonesia'],
            ['nama' => 'Bank Panin'],
            ['nama' => 'Bank BTPN'],
        ];

        DB::table('banks')->insert($banks);
    }
}
