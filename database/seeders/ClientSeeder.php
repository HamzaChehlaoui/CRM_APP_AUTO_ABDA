<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;
use App\Models\Branch;
use Faker\Factory;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        // $faker = Factory::create('fr_FR');
        // $branches = Branch::pluck('id')->toArray();
        // $users = User::pluck('id')->toArray();

        // foreach (range(1, 50) as $i) {
        //     Client::create([
        //         'full_name' => $faker->name,
        //         'phone' => $faker->phoneNumber,
        //         'cin' => $faker->unique()->bothify('????#####'),
        //         'address' => $faker->address,
        //         'email' => $faker->email,
        //         'branch_id' => $faker->randomElement($branches),
        //         'created_by' => $faker->randomElement($users),
        //         'branch_id'=>2,
        //     ]);
        // }
    }
}
