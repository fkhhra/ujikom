<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $indonesianNames = [
            'Aditya Pratama', 'Budi Santoso', 'Citra Lestari', 'Dedi Kurniawan', 'Eka Saputra',
            'Farah Nabila', 'Gilang Ramadhan', 'Hana Pertiwi', 'Indra Wijaya', 'Joko Susilo',
            'Kurnia Mega', 'Luthfi Hakim', 'Maulana Malik', 'Nanda Pratama', 'Oki Setiana',
            'Putra Ramadhan', 'Qori Anugrah', 'Rizky Billar', 'Siska Amelia', 'Teguh Arifianto'
        ];

        shuffle($indonesianNames);

        $users = [
            // Admin
            ['name' => array_pop($indonesianNames), 'email' => 'admin@trivo.id', 'password' => Hash::make('password'), 'role' => 'admin', 'branch_id' => 1],

            // Managers
            ['name' => array_pop($indonesianNames), 'email' => 'manager.jkt@trivo.id', 'password' => Hash::make('password'), 'role' => 'manager', 'branch_id' => 1],
            ['name' => array_pop($indonesianNames), 'email' => 'manager.bdg@trivo.id', 'password' => Hash::make('password'), 'role' => 'manager', 'branch_id' => 2],
            ['name' => array_pop($indonesianNames), 'email' => 'manager.sby@trivo.id', 'password' => Hash::make('password'), 'role' => 'manager', 'branch_id' => 3],

            // Cashiers
            ['name' => array_pop($indonesianNames), 'email' => 'kasir1.jkt@trivo.id', 'password' => Hash::make('password'), 'role' => 'cashier', 'branch_id' => 1],
            ['name' => array_pop($indonesianNames), 'email' => 'kasir2.jkt@trivo.id', 'password' => Hash::make('password'), 'role' => 'cashier', 'branch_id' => 1],
            ['name' => array_pop($indonesianNames), 'email' => 'kasir1.bdg@trivo.id', 'password' => Hash::make('password'), 'role' => 'cashier', 'branch_id' => 2],
            ['name' => array_pop($indonesianNames), 'email' => 'kasir1.sby@trivo.id', 'password' => Hash::make('password'), 'role' => 'cashier', 'branch_id' => 3],

            // Couriers
            ['name' => array_pop($indonesianNames), 'email' => 'kurir1.jkt@trivo.id', 'password' => Hash::make('password'), 'role' => 'courier', 'branch_id' => 1],
            ['name' => array_pop($indonesianNames), 'email' => 'kurir2.jkt@trivo.id', 'password' => Hash::make('password'), 'role' => 'courier', 'branch_id' => 1],
            ['name' => array_pop($indonesianNames), 'email' => 'kurir1.bdg@trivo.id', 'password' => Hash::make('password'), 'role' => 'courier', 'branch_id' => 2],
            ['name' => array_pop($indonesianNames), 'email' => 'kurir1.sby@trivo.id', 'password' => Hash::make('password'), 'role' => 'courier', 'branch_id' => 3],
            ['name' => array_pop($indonesianNames), 'email' => 'kurir1.yog@trivo.id', 'password' => Hash::make('password'), 'role' => 'courier', 'branch_id' => 4],
        ];

        foreach ($users as $user) {
            User::create(array_merge($user, ['email_verified_at' => now()]));
        }
    }
}
