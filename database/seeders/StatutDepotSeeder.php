<?php

namespace Database\Seeders;

use App\Models\StatutDepot;
use Illuminate\Database\Seeder;

class StatutDepotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            'En attente',
            'Valide',
            'Rejete',
        ] as $libelle) {
            StatutDepot::updateOrCreate(['libelle' => $libelle]);
        }
    }
}
