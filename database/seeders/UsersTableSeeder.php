<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'General Director',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'branch_id' => null,
            ],
            [
                'name' => 'Assistant Director',
                'email' => 'hamzachehlaoui3@gmail.com',
                'password' => Hash::make('password@autoabda'),
                'role_id' => 2,
                'branch_id' => null,
            ],
            [
                'name' => 'Safi Magasin - e',
                'email' => 'safimagasin@crm.com',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'branch_id' => 1,
            ],
            [
                'name' => 'Safi Carrosserie - e',
                'email' => 'saficarrosserie@crm.com',
                'password' => Hash::make('password'),
                'role_id' => 4,
                'branch_id' => 2,
            ],
            [
                'name' => 'Safi Atelier - e',
                'email' => 'safiatelier@crm.com',
                'password' => Hash::make('password'),
                'role_id' => 5,
                'branch_id' => 3,
            ],
            [
                'name' => 'Essaouira e',
                'email' => 'essaouira@crm.com',
                'password' => Hash::make('password'),
                'role_id' => 6,
                'branch_id' => 4,
            ],
            [
                'name' => 'Sidi Bennour e',
                'email' => 'sidi@crm.com',
                'password' => Hash::make('password'),
                'role_id' => 7,
                'branch_id' => 5,
            ],
        ]);
    }
}
