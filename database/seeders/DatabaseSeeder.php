<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@tenantlady.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'plan' => 'business',
            'referral_code' => 'ADMIN001',
        ]);

        User::create([
            'name' => 'Demo Landlord',
            'email' => 'landlord@tenantlady.com',
            'password' => Hash::make('password'),
            'role' => 'landlord',
            'plan' => 'starter',
            'referral_code' => 'DEMO123',
        ]);
    }
}
