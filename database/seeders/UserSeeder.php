<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'id' => Str::uuid(),
                'name' => 'Wiku Karno',
                'email' => 'hi@wikukarno.com',
                'role' => 'admin',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        User::insert($user);
    }
}
