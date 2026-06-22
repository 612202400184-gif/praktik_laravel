<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // Cek apakah email sudah ada
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Operator
        User::updateOrCreate(
            ['email' => 'operator@example.com'],
            [
                'name' => 'Operator User',
                'password' => Hash::make('password123'),
                'role' => 'operator',
            ]
        );

        // 3. Akun Viewer (Hanya Lihat)
        User::updateOrCreate(
            ['email' => 'viewer@example.com'],
            [
                'name' => 'Viewer User',
                'password' => Hash::make('password123'),
                'role' => 'viewer',
            ]
        );
    }
} 