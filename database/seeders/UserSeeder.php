<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@donasibarang.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        // Create Donatur User
        User::create([
            'name' => 'John Donatur',
            'email' => 'donatur@donasibarang.com',
            'password' => Hash::make('password123'),
            'role' => 'donatur',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        // Create Organisasi User
        User::create([
            'name' => 'Panti Asuhan Harapan',
            'email' => 'organisasi@donasibarang.com',
            'password' => Hash::make('password123'),
            'role' => 'organisasi',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        // Create additional test users
        User::create([
            'name' => 'Sarah Dermawan',
            'email' => 'sarah@example.com',
            'password' => Hash::make('password123'),
            'role' => 'donatur',
            'is_verified' => false, // Pending verification
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Yayasan Anak Bangsa',
            'email' => 'yayasan@example.com',
            'password' => Hash::make('password123'),
            'role' => 'organisasi',
            'is_verified' => false, // Pending verification
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Ahmad Baik Hati',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('password123'),
            'role' => 'donatur',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);
    }
} 