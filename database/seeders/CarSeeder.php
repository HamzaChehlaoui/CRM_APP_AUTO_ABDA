<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use Faker\Factory;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('fr_FR');
        $brands = ["Toyota", "Renault", "Peugeot", "Hyundai", "Kia", "Volkswagen", "Dacia", "Ford", "Fiat", "Nissan"];
        $models = ["Yaris", "Clio", "208", "i20", "Sportage", "Golf", "Logan", "Focus", "Punto", "Micra"];

        foreach (range(0, 9) as $i) {
            Car::create([
                'brand' => $brands[$i],
                'model' => $models[$i],
                'ivn' => $faker->unique()->bothify('IVN#####'),
                'registration_number' => $faker->unique()->bothify('??-####-??'),
                'chassis_number' => $faker->unique()->bothify('CH########'),
                'color' => $faker->safeColorName(),
                'year' => $faker->numberBetween(2015, 2024),
                'branch_id'=>1,
                'client_id'=>1,
            ]);
        }
    }
}
