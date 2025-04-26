<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now();
        $superadmin = User::create(
            [
                'name' => 'superadmin',
                'profile'=>'default.jpg',
                'username' => 'superadmin',
                'email' => 'superadmin@tes.tes',
                'phone' => '6282130394490',
                'email_verified_at' => $date,
                'password' => bcrypt('123123123')
            ]
        );
        $superadmin->assignRole('Super-Admin');
    }
}
