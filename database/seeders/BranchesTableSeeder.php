<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('branches')->insert([
            ['name' => 'Magasin Safi'],
            ['name' => 'Carrosserie Safi'],
            ['name' => 'Atelier Safi'],
            ['name' => 'Essaouira'],
            ['name' => 'Sidi Bennour'],
        ]);
    }
}
