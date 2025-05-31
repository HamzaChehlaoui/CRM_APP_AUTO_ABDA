<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entretien;
use App\Models\Client;
use App\Models\Car;
use App\Models\User;
use Faker\Factory;

class EntretienSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('fr_FR');
        $clients = Client::pluck('id')->toArray();
        $cars = Car::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        foreach (range(1, 10) as $i) {
            Entretien::create([
                'car_id' => $faker->randomElement($cars),
                'client_id' => $faker->randomElement($clients),
                'user_id' => $faker->randomElement($users),
                'type' => $faker->randomElement(['Révision', 'Diagnostic', 'Entretien périodique']),
                'scheduled_at' => $faker->dateTimeBetween('-6 months', '+3 months'),
                'description' => $faker->text(100),
                'status' => $faker->randomElement(['planifié', 'réalisé', 'annulé']),
            ]);
        }
    }
}
