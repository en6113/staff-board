<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'user',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'user2',
                'email' => 'user2@example.com',
                'password' => bcrypt('password'),
            ],
        ];

        foreach($users as $user) {
            User::create($user);
        }
    }
}
