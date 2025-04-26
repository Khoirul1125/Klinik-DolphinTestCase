<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class Set_bpjsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('set_bpjs')->insert([
            [
                'CONSID' => '0',
                'USERNAME' => 'user',
                'PASSWORD' => 'password',
                'SCREET_KEY' => 'secretkey',
                'USER_KEY' => 'userkey',
                'APP_CODE' => 'appcode',
                'BASE_URL' => 'https://example.com',
                'SERVICE' => 'service',
                'SERVICE_ANTREAN' => 'service_antrian',
                'KPFK' => 'Kode Klinik',
            ],
        ]);
    }
}
