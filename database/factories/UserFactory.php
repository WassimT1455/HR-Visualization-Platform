<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => fake()->randomElement(['admin', 'employee']),
            'matricule' => 'EMP-' . fake()->unique()->numberBetween(1000, 9999),
            'fonction' => fake()->randomElement([
                'Développeur',
                'RH',
                'Comptable',
                'Chef de projet',
                'Technicien IT'
            ]),
            'solde_conges' => fake()->numberBetween(0, 30),
        ];
    }
}
