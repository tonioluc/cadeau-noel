<?php

namespace Database\Seeders;

use App\Models\Parametre;
use Illuminate\Database\Seeder;

class ParametreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Parametre::updateOrCreate(
            ['code' => 'COMM'],
            [
                'description' => 'Commision en % que le site prend',
                'valeur' => '10',
            ]
        );
    }
}
