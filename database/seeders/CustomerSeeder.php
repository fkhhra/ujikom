<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Ahmad Fauzi', 'Siti Rahayu', 'Budi Prakoso', 'Dewi Lestari', 'Eko Prasetyo',
            'Fitri Handayani', 'Gunawan Santoso', 'Hesti Permata', 'Irfan Hakim', 'Joko Widodo',
            'Kartika Sari', 'Lukman Hakim', 'Maya Indah', 'Nanda Pratama', 'Oki Setiana',
            'Putra Ramadhan', 'Qori Anugrah', 'Rizky Billar', 'Siska Amelia', 'Teguh Arifianto'
        ];

        $cities = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang', 'Medan', 'Makassar', 'Palembang'];

        foreach ($names as $index => $name) {
            Customer::create([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '.', $name)) . '@example.com',
                'password' => Hash::make('password'),
                'phone' => '08' . rand(1111111111, 9999999999),
                'address' => 'Jl. Random No. ' . ($index + 1),
                'city' => $cities[array_rand($cities)],
                'email_verified_at' => now(),
            ]);
        }
    }
}
