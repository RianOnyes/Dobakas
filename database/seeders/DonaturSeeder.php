<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DonaturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Test Donatur',
            'email' => 'donatur@test.com',
            'password' => Hash::make('password'),
            'role' => 'donatur',
            'email_verified_at' => now(),
        ]);
    }
} 