<?php

namespace Database\Seeders;

use App\Models\CategorieCadeau;
use Illuminate\Database\Seeder;

class CategorieCadeauSeeder extends Seeder
{
    public function run(): void
    {
        $labels = [
            'Fille',
            'Garçon',
            'Neutre',
        ];

        foreach ($labels as $libelle) {
            CategorieCadeau::firstOrCreate(['libelle' => $libelle]);
        }
    }
}
