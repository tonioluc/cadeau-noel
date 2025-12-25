<?php

namespace Database\Seeders;

use App\Models\Cadeau;
use App\Models\CategorieCadeau;
use Illuminate\Database\Seeder;

class CadeauSeeder extends Seeder
{
    public function run(): void
    {
        // Créer 10 cadeaux pour chaque catégorie
        $categorieFille = CategorieCadeau::where('libelle', 'Fille')->first();
        $categorieGarcon = CategorieCadeau::where('libelle', 'Garçon')->first();
        $categorieNeutre = CategorieCadeau::where('libelle', 'Neutre')->first();

        // Cadeaux pour filles
        $cadeauxFille = [
            ['nom' => 'Poupée Barbie', 'prix' => 20000],
            ['nom' => 'Maison de poupée', 'prix' => 80000],
            ['nom' => 'Kit de maquillage enfant', 'prix' => 10000],
            ['nom' => 'Bracelet à perles', 'prix' => 24000],
            ['nom' => 'Licorne en peluche', 'prix' => 34000],
            ['nom' => 'Déguisement princesse', 'prix' => 44000],
            ['nom' => 'Journal intime', 'prix' => 20000],
            ['nom' => 'Kit de bijoux à créer', 'prix' => 32000],
            ['nom' => 'Peluche chat rose', 'prix' => 28000],
            ['nom' => 'Coffret de vernis à ongles', 'prix' => 25000],
        ];

        // Cadeaux pour garçons
        $cadeauxGarcon = [
            ['nom' => 'Voiture télécommandée', 'prix' => 50000],
            ['nom' => 'LEGO Technic', 'prix' => 80000],
            ['nom' => 'Ballon de football', 'prix' => 20000],
            ['nom' => 'Figurine superhéros', 'prix' => 34000],
            ['nom' => 'Drone pour enfant', 'prix' => 70000],
            ['nom' => 'Circuit de voitures', 'prix' => 54000],
            ['nom' => 'Robot programmable', 'prix' => 90000],
            ['nom' => 'Pistolet Nerf', 'prix' => 30000],
            ['nom' => 'Skateboard', 'prix' => 64000],
            ['nom' => 'Kit de dinosaures', 'prix' => 44000],
        ];

        // Cadeaux neutres
        $cadeauxNeutre = [
            ['nom' => 'Puzzle 500 pièces', 'prix' => 24000],
            ['nom' => 'Jeu de société Monopoly', 'prix' => 30000],
            ['nom' => 'Livre d\'aventure', 'prix' => 20000],
            ['nom' => 'Console de jeux portable', 'prix' => 140000],
            ['nom' => 'Kit de peinture', 'prix' => 34000],
            ['nom' => 'Ukulélé', 'prix' => 40000],
            ['nom' => 'Tablette éducative', 'prix' => 110000],
            ['nom' => 'Jeu vidéo Mario Kart', 'prix' => 50000],
            ['nom' => 'Kit de magie', 'prix' => 30000],
            ['nom' => 'Télescope pour enfant', 'prix' => 70000],
        ];

        foreach ($cadeauxFille as $cadeau) {
            Cadeau::firstOrCreate(
                ['nom' => $cadeau['nom']],
                [
                    'description' => 'Un cadeau parfait pour les filles',
                    'id_categorie_cadeau' => $categorieFille->id_categorie_cadeau,
                    'prix' => $cadeau['prix'],
                    'date_ajout' => now(),
                ]
            );
        }

        foreach ($cadeauxGarcon as $cadeau) {
            Cadeau::firstOrCreate(
                ['nom' => $cadeau['nom']],
                [
                    'description' => 'Un cadeau parfait pour les garçons',
                    'id_categorie_cadeau' => $categorieGarcon->id_categorie_cadeau,
                    'prix' => $cadeau['prix'],
                    'date_ajout' => now(),
                ]
            );
        }

        foreach ($cadeauxNeutre as $cadeau) {
            Cadeau::firstOrCreate(
                ['nom' => $cadeau['nom']],
                [
                    'description' => 'Un cadeau pour tous les enfants',
                    'id_categorie_cadeau' => $categorieNeutre->id_categorie_cadeau,
                    'prix' => $cadeau['prix'],
                    'date_ajout' => now(),
                ]
            );
        }
    }
}
