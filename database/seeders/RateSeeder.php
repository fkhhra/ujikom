<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rate;

class RateSeeder extends Seeder
{
    public function run(): void
    {
        $cities = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang', 'Medan', 'Makassar', 'Palembang'];

        $base_prices = [
            'Jakarta'   => ['Bandung' => 8000, 'Surabaya' => 15000, 'Yogyakarta' => 12000, 'Semarang' => 12000, 'Medan' => 22000, 'Makassar' => 25000, 'Palembang' => 16000],
            'Bandung'   => ['Jakarta' => 8000, 'Surabaya' => 14000, 'Yogyakarta' => 11000, 'Semarang' => 11000, 'Medan' => 23000, 'Makassar' => 26000, 'Palembang' => 17000],
            'Surabaya'  => ['Jakarta' => 15000, 'Bandung' => 14000, 'Yogyakarta' => 9000, 'Semarang' => 10000, 'Medan' => 26000, 'Makassar' => 20000, 'Palembang' => 22000],
            'Yogyakarta'=> ['Jakarta' => 12000, 'Bandung' => 11000, 'Surabaya' => 9000, 'Semarang' => 7000, 'Medan' => 24000, 'Makassar' => 22000, 'Palembang' => 20000],
            'Semarang'  => ['Jakarta' => 12000, 'Bandung' => 11000, 'Surabaya' => 10000, 'Yogyakarta' => 7000, 'Medan' => 25000, 'Makassar' => 23000, 'Palembang' => 21000],
            'Medan'     => ['Jakarta' => 22000, 'Bandung' => 23000, 'Surabaya' => 26000, 'Yogyakarta' => 24000, 'Semarang' => 25000, 'Makassar' => 30000, 'Palembang' => 18000],
            'Makassar'  => ['Jakarta' => 25000, 'Bandung' => 26000, 'Surabaya' => 20000, 'Yogyakarta' => 22000, 'Semarang' => 23000, 'Medan' => 30000, 'Palembang' => 28000],
            'Palembang' => ['Jakarta' => 16000, 'Bandung' => 17000, 'Surabaya' => 22000, 'Yogyakarta' => 20000, 'Semarang' => 21000, 'Medan' => 18000, 'Makassar' => 28000],
        ];

        $est_days = [
            'Jakarta'   => ['Bandung' => 1, 'Surabaya' => 2, 'Yogyakarta' => 2, 'Semarang' => 2, 'Medan' => 4, 'Makassar' => 5, 'Palembang' => 3],
            'Bandung'   => ['Jakarta' => 1, 'Surabaya' => 2, 'Yogyakarta' => 2, 'Semarang' => 2, 'Medan' => 4, 'Makassar' => 5, 'Palembang' => 3],
            'Surabaya'  => ['Jakarta' => 2, 'Bandung' => 2, 'Yogyakarta' => 1, 'Semarang' => 1, 'Medan' => 5, 'Makassar' => 3, 'Palembang' => 4],
            'Yogyakarta'=> ['Jakarta' => 2, 'Bandung' => 2, 'Surabaya' => 1, 'Semarang' => 1, 'Medan' => 5, 'Makassar' => 4, 'Palembang' => 4],
            'Semarang'  => ['Jakarta' => 2, 'Bandung' => 2, 'Surabaya' => 1, 'Yogyakarta' => 1, 'Medan' => 5, 'Makassar' => 4, 'Palembang' => 4],
            'Medan'     => ['Jakarta' => 4, 'Bandung' => 4, 'Surabaya' => 5, 'Yogyakarta' => 5, 'Semarang' => 5, 'Makassar' => 6, 'Palembang' => 3],
            'Makassar'  => ['Jakarta' => 5, 'Bandung' => 5, 'Surabaya' => 3, 'Yogyakarta' => 4, 'Semarang' => 4, 'Medan' => 6, 'Palembang' => 5],
            'Palembang' => ['Jakarta' => 3, 'Bandung' => 3, 'Surabaya' => 4, 'Yogyakarta' => 4, 'Semarang' => 4, 'Medan' => 3, 'Makassar' => 5],
        ];

        foreach ($cities as $origin) {
            foreach ($cities as $dest) {
                if ($origin !== $dest) {
                    Rate::create([
                        'origin_city'      => $origin,
                        'destination_city' => $dest,
                        'price_per_kg'     => $base_prices[$origin][$dest] ?? 20000,
                        'estimated_days'   => $est_days[$origin][$dest] ?? 3,
                    ]);
                }
            }
        }
    }
}
