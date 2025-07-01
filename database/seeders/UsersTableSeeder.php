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
            [
                'name' => 'Safi Magasin - e',
                'email' => 'safimagasin@crm.com',
                'password' => 'password',
                'role_id' => 3,
                'branch_id' => 1,
            ],
            [
                'name' => 'Safi Carrosserie - e',
                'email' => 'saficarrosserie@crm.com',
                'password' => 'password',
                'role_id' => 4,
                'branch_id' => 2,
            ],
            [
                'name' => 'Safi Atelier - e',
                'email' => 'safiatelier@crm.com',
                'password' => 'password',
                'role_id' => 5,
                'branch_id' => 3,
            ],
            [
                'name' => 'Essaouira e',
                'email' => 'essaouira@crm.com',
                'password' => 'password',
                'role_id' => 6,
                'branch_id' => 4,
            ],
            [
                'name' => 'Sidi Bennour e',
                'email' => 'sidi@crm.com',
                'password' => 'password',
                'role_id' => 7,
                'branch_id' => 5,
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
