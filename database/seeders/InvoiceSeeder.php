<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\Car;
use App\Models\User;
use App\Models\Branch;
use Faker\Factory;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('fr_FR');
        $clients = Client::pluck('id')->toArray();
        $cars = Car::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();
        $branches = Branch::pluck('id')->toArray();

        foreach (range(1, 10) as $i) {
            Invoice::create([
                'invoice_number' => $faker->unique()->bothify('INV#####'),
                'sale_date' => $faker->dateTimeBetween('-2 years', 'now'),
                'total_amount' => $faker->randomFloat(2, 15000, 400000),
                'ivn' => $faker->unique()->bothify('IVN#####'),
                'accord_reference' => $faker->bothify('ACD###'),
                'purchase_order_number' => $faker->bothify('BC###'),
                'delivery_note_number' => $faker->bothify('BL###'),
                'payment_order_reference' => $faker->bothify('OR###'),
                'client_id' => $faker->randomElement($clients),
                'car_id' => $faker->randomElement($cars),
                'user_id' => $faker->randomElement($users),
            ]);
        }
    }
}
