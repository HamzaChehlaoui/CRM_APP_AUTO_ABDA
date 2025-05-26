<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;
use Faker\Factory;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('fr_FR');
        $users = User::pluck('id')->toArray();

        foreach (range(1, 10) as $i) {
            Notification::create([
                'user_id' => $faker->randomElement($users),
                'title' => $faker->sentence(4),
                'content' => $faker->paragraph(),
                'is_read' => $faker->boolean(),
            ]);
        }
    }
}
