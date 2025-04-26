<?php

namespace Database\Seeders;

use App\Models\set_satusehat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Set_satusehatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        set_satusehat::create([
            'org_id' => 'org_1234',
            'client_id' => 'client_1234',
            'client_secret' => 'secret_1234',
            'SCREET_KEY' => 'key_1234',
            'SATUSEHAT_BASE_URL' => 'https://api.satusehat.example.com',
        ]);
    }
}
