<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BranchSeeder::class,
            UserSeeder::class,
            VehicleSeeder::class,
            RateSeeder::class,
            CustomerSeeder::class,
            ShipmentSeeder::class,
        ]);
    }
}
