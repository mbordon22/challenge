<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make("password")
        ]);

        $user = User::create([
            'name' => 'user1',
            'email' => 'user1@example.com',
            'password' => Hash::make("123qwe")
        ]);

        $user = User::create([
            'name' => 'user2',
            'email' => 'user2@example.com',
            'password' => Hash::make("123qwe")
        ]);
    }
}
