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
            ['nom' => 'Poupée Barbie', 'prix' => 29.99],
            ['nom' => 'Maison de poupée', 'prix' => 89.99],
            ['nom' => 'Kit de maquillage enfant', 'prix' => 19.99],
            ['nom' => 'Bracelet à perles', 'prix' => 14.99],
            ['nom' => 'Licorne en peluche', 'prix' => 24.99],
            ['nom' => 'Déguisement princesse', 'prix' => 34.99],
            ['nom' => 'Journal intime', 'prix' => 12.99],
            ['nom' => 'Kit de bijoux à créer', 'prix' => 22.99],
            ['nom' => 'Peluche chat rose', 'prix' => 18.99],
            ['nom' => 'Coffret de vernis à ongles', 'prix' => 15.99],
        ];

        // Cadeaux pour garçons
        $cadeauxGarcon = [
            ['nom' => 'Voiture télécommandée', 'prix' => 49.99],
            ['nom' => 'LEGO Technic', 'prix' => 79.99],
            ['nom' => 'Ballon de football', 'prix' => 19.99],
            ['nom' => 'Figurine superhéros', 'prix' => 24.99],
            ['nom' => 'Drone pour enfant', 'prix' => 59.99],
            ['nom' => 'Circuit de voitures', 'prix' => 44.99],
            ['nom' => 'Robot programmable', 'prix' => 69.99],
            ['nom' => 'Pistolet Nerf', 'prix' => 29.99],
            ['nom' => 'Skateboard', 'prix' => 54.99],
            ['nom' => 'Kit de dinosaures', 'prix' => 34.99],
        ];

        // Cadeaux neutres
        $cadeauxNeutre = [
            ['nom' => 'Puzzle 500 pièces', 'prix' => 14.99],
            ['nom' => 'Jeu de société Monopoly', 'prix' => 29.99],
            ['nom' => 'Livre d\'aventure', 'prix' => 12.99],
            ['nom' => 'Console de jeux portable', 'prix' => 149.99],
            ['nom' => 'Kit de peinture', 'prix' => 24.99],
            ['nom' => 'Ukulélé', 'prix' => 39.99],
            ['nom' => 'Tablette éducative', 'prix' => 99.99],
            ['nom' => 'Jeu vidéo Mario Kart', 'prix' => 49.99],
            ['nom' => 'Kit de magie', 'prix' => 29.99],
            ['nom' => 'Télescope pour enfant', 'prix' => 59.99],
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
