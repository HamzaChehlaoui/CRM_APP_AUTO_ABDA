<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'General Director'],
            ['name' => 'Assistant Director'],
            ['name' => 'Branch Manager - Safi'],
            ['name' => 'Branch Manager - Essaouira'],
            ['name' => 'Branch Manager - Sidi Bennour'],
        ]);
    }
}
