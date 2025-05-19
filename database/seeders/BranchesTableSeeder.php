<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('branches')->insert([
            ['name' => 'Safi'],
            ['name' => 'Essaouira'],
            ['name' => 'Sidi Bennour'],
        ]);
    }
}
