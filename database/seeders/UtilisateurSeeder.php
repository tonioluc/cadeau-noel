<?php

namespace Database\Seeders;

use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UtilisateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default user User1 with password 'mdp'
        Utilisateur::updateOrCreate(
            ['nom' => 'admin'],
            [
            'mot_de_passe' => Hash::make('admin'),
            ]
        );

        Utilisateur::updateOrCreate(
            ['nom' => 'User1'],
            [
            'mot_de_passe' => Hash::make('mdp'),
            ]
        );
    }
}
