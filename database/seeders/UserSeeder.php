<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Administrador', 'email' => 'admin@salestracker.com', 'password' => 'admin123', 'role' => 'admin', 'active' => true],
            ['name' => 'Juan Pérez', 'email' => 'juan@salestracker.com', 'password' => 'juan2026', 'role' => 'ventas', 'active' => true],
            ['name' => 'María Rojas', 'email' => 'maria@salestracker.com', 'password' => 'maria2026', 'role' => 'ventas', 'active' => true],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'role' => $userData['role'],
                    'active' => $userData['active'],
                ]
            );
        }
    }
}
