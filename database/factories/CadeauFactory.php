<?php

namespace Database\Factories;

use App\Models\Cadeau;
use App\Models\CategorieCadeau;
use Illuminate\Database\Eloquent\Factories\Factory;

class CadeauFactory extends Factory
{
    protected $model = Cadeau::class;

    // Noms de cadeaux réalistes par catégorie
    protected static array $cadeauxFille = [
        'Poupée Barbie',
        'Maison de poupée',
        'Kit de maquillage enfant',
        'Bracelet à perles',
        'Licorne en peluche',
        'Déguisement princesse',
        'Journal intime',
        'Kit de bijoux à créer',
        'Peluche chat rose',
        'Coffret de vernis à ongles',
    ];

    protected static array $cadeauxGarcon = [
        'Voiture télécommandée',
        'LEGO Technic',
        'Ballon de football',
        'Figurine superhéros',
        'Drone pour enfant',
        'Circuit de voitures',
        'Robot programmable',
        'Pistolet Nerf',
        'Skateboard',
        'Kit de dinosaures',
    ];

    protected static array $cadeauxNeutre = [
        'Puzzle 500 pièces',
        'Jeu de société Monopoly',
        'Livre d\'aventure',
        'Console de jeux portable',
        'Kit de peinture',
        'Instrument de musique (ukulélé)',
        'Tablette éducative',
        'Jeu vidéo',
        'Vélo',
        'Trottinette',
        'Kit de magie',
        'Télescope pour enfant',
    ];

    public function definition(): array
    {
        // On récupère une catégorie au hasard
        $categorie = CategorieCadeau::inRandomOrder()->first();
        
        // On choisit un nom selon la catégorie
        $nom = match ($categorie?->libelle) {
            'Fille' => $this->faker->randomElement(self::$cadeauxFille),
            'Garçon' => $this->faker->randomElement(self::$cadeauxGarcon),
            'Neutre' => $this->faker->randomElement(self::$cadeauxNeutre),
            default => $this->faker->randomElement(array_merge(
                self::$cadeauxFille,
                self::$cadeauxGarcon,
                self::$cadeauxNeutre
            )),
        };

        return [
            'nom' => $nom,
            'description' => $this->faker->sentence(10),
            'id_categorie_cadeau' => $categorie?->id_categorie_cadeau ?? 1,
            'prix' => $this->faker->randomFloat(2, 20000, 1500000),
            'chemin_image' => null,
            'date_ajout' => now(),
        ];
    }

    /**
     * État pour créer un cadeau de catégorie Fille
     */
    public function fille(): static
    {
        return $this->state(function (array $attributes) {
            $categorie = CategorieCadeau::where('libelle', 'Fille')->first();
            return [
                'nom' => $this->faker->randomElement(self::$cadeauxFille),
                'id_categorie_cadeau' => $categorie?->id_categorie_cadeau ?? 1,
            ];
        });
    }

    /**
     * État pour créer un cadeau de catégorie Garçon
     */
    public function garcon(): static
    {
        return $this->state(function (array $attributes) {
            $categorie = CategorieCadeau::where('libelle', 'Garçon')->first();
            return [
                'nom' => $this->faker->randomElement(self::$cadeauxGarcon),
                'id_categorie_cadeau' => $categorie?->id_categorie_cadeau ?? 1,
            ];
        });
    }

    /**
     * État pour créer un cadeau de catégorie Neutre
     */
    public function neutre(): static
    {
        return $this->state(function (array $attributes) {
            $categorie = CategorieCadeau::where('libelle', 'Neutre')->first();
            return [
                'nom' => $this->faker->randomElement(self::$cadeauxNeutre),
                'id_categorie_cadeau' => $categorie?->id_categorie_cadeau ?? 1,
            ];
        });
    }
}
