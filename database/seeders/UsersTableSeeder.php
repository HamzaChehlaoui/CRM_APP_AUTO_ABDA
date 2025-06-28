<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'General Director',
                'email' => 'hamza.khaoot1@gmail.com',
                'password' => 'password@autoabda',
                'role_id' => 1,
                'branch_id' => null,
            ],
            [
                'name' => 'Assistant Director',
                'email' => 'hamzachehlaoui3@gmail.com',
                'password' => 'password@autoabda',
                'role_id' => 2,
                'branch_id' => null,
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'role_id' => $userData['role_id'],
                    'branch_id' => $userData['branch_id'],
                ]
            );
        }
    }
}
