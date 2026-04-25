<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\User;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $prefixes = ['B', 'D', 'L', 'AB', 'H', 'F', 'N', 'BE'];
        $types = ['motor', 'mobil', 'truck'];
        $ownerships = ['personal', 'company'];

        $couriers = User::where('role', 'courier')->get();

        foreach ($couriers as $courier) {
            $plate = $prefixes[array_rand($prefixes)] . ' ' . rand(1000, 9999) . ' ' . chr(rand(65, 90)) . chr(rand(65, 90));
            
            $vehicle = Vehicle::create([
                'plate_number' => $plate,
                'type' => $types[array_rand($types)],
                'branch_id' => $courier->branch_id,
                'ownership' => $ownerships[array_rand($ownerships)],
            ]);
            
            $courier->update(['vehicle_id' => $vehicle->id]);
        }
    }
}
