<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.net'],
            [
                'name' => 'Super Administrador',
                'email' => 'admin@admin.net',
                'sex' => 'Masculino',
                //'password' => Hash::make('eladmin.0305'),
                'password' => '$2y$12$UdkNyUpEss5NWI4SDJd3aOJ.Z679/HbiLwNqaGtLz1nlrNkSWusMe',
                'status' => 1, // Asegúrate de que tu modelo tenga este campo

            ]
        );
    }
}
