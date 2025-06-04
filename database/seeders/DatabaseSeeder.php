<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\{Role, Branch, User, Client, Car, Invoice, Suivi, Notification, Entretien, Reclamation};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call seeders in order
        $this->call([
            RolesTableSeeder::class,
            BranchesTableSeeder::class,
            UsersTableSeeder::class,
            ClientSeeder::class,
            CarSeeder::class,
            InvoiceSeeder::class,
            SuiviSeeder::class,
            NotificationSeeder::class,
            ReclamationSeeder::class,
        ]);
    }
}
