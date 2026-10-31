<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin de démo
        User::create([
            'name' => 'Admin Demo',
            'email' => 'admin@demo.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'matricule' => 'ADMIN-001',
            'fonction' => 'Administrateur',
            'solde_conges' => 30,
        ]);

        // Employés de démo
        User::factory()->count(15)->create([
            'role' => 'employee',
        ]);
    }
}
