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
            ['name' => 'Branch Magasin - Safi'],
            ['name' => 'Branch Crrosserie - Safi'],
            ['name' => 'Branch Atelier - Safi'],
            ['name' => 'Branch - Essaouira'],
            ['name' => 'Branch - Sidi Bennour'],
        ]);
    }
}
