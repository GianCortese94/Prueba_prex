<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['email' => 'admin@example.com', 'name' => 'Admin User'],
            ['email' => 'user1@example.com', 'name' => 'User One'],
            ['email' => 'user2@example.com', 'name' => 'User Two'],
            ['email' => 'user3@example.com', 'name' => 'User Three'],
            ['email' => 'user4@example.com', 'name' => 'User Four'],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password123'),
                ]
            );
        }
    }
}
