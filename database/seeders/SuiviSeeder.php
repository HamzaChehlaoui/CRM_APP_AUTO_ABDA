<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Suivi;
use App\Models\Client;
use App\Models\User;
use Faker\Factory;

class SuiviSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('fr_FR');
        $clients = Client::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        foreach (range(1, 10) as $i) {
            Suivi::create([
                'client_id' => $faker->randomElement($clients),
                'user_id' => $faker->randomElement($users),
                'note' => $faker->sentence(),
                'status' => $faker->randomElement(['en_cours', 'termine', 'annule']),
                'date_suivi' => $faker->dateTimeBetween('-1 year', 'now'),
            
            ]);
        }
    }
}
