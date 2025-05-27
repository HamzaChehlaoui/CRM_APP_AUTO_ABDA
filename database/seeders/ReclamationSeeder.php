<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reclamation;
use App\Models\Client;
use App\Models\User;
use Faker\Factory;

class ReclamationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('fr_FR');
        $clients = Client::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        foreach (range(1, 10) as $i) {
            Reclamation::create([
                'client_id' => $faker->randomElement($clients),
                'user_id' => $faker->randomElement($users),
                'description' => $faker->text(150),
                'status' => $faker->randomElement(['nouvelle', 'en_cours', 'résolue']),
                'branch_id'=>1,
            ]);
        }
    }
}
