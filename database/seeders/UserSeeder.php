<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Rygan Rocamora',
            'email' => 'rocamora@kaonta.test',
            'password' => Hash::make('kaonta2026'),
        ]);

        User::create([
            'name' => 'Tita Rocamora',
            'email' => 'tita.rocamora@kaonta.test',
            'password' => Hash::make('kaonta2026'),
        ]);

        User::factory()->count(10)->create();
    }
}