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
                'email' => 'hamzachehlaoui3@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'branch_id' => null,
            ],
            [
                'name' => 'Assistant Director',
                'email' => 'assistant@crm.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'branch_id' => null,
            ],
            [
                'name' => 'Safi Manager',
                'email' => 'safi@crm.com',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'branch_id' => 1,
            ],
            [
                'name' => 'Essaouira Manager',
                'email' => 'essaouira@crm.com',
                'password' => Hash::make('password'),
                'role_id' => 4,
                'branch_id' => 2,
            ],
            [
                'name' => 'Sidi Bennour Manager',
                'email' => 'sidi@crm.com',
                'password' => Hash::make('password'),
                'role_id' => 5,
                'branch_id' => 3,
            ],
        ]);
    }
}
