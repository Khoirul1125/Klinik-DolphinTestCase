<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class lisensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['key' => 'd4605551-a9db-4c44-8852-916959c90793'],
            ['key' => '7d3e9041-b932-4a77-80eb-eda2e35324da'],
        ];

        DB::table('licenses')->insert($data);
    }
}
