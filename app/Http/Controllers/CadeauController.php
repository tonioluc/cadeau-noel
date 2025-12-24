<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateNombreEnfants;
use App\Models\Cadeau;
use App\Models\CategorieCadeau;
use Illuminate\Http\Request;

class CadeauController extends Controller
{
    public function showForm()
    {
        return view('utilisateur.form-nbr-enfants');
    }

    /**
     * Suggère des cadeaux aléatoires pour chaque enfant (filles et garçons).
     * Les cadeaux sont stockés en session pour permettre les échanges.
     */
    public function suggererCadeaux(ValidateNombreEnfants $request)
    {
        $data = $request->validated();
        $nbrFilles = (int) $data['filles'];
        $nbrGarcons = (int) $data['garcons'];

        // Récupérer les IDs des catégories
        $categorieFille = CategorieCadeau::where('libelle', 'Fille')->first();
        $categorieGarcon = CategorieCadeau::where('libelle', 'Garçon')->first();
        $categorieNeutre = CategorieCadeau::where('libelle', 'Neutre')->first();

        // Liste des IDs de cadeaux déjà attribués (pour éviter les doublons)
        $idsUtilises = [];

        // Cadeaux pour filles: catégorie Fille ou Neutre
        $suggestionsFilles = [];
        if ($nbrFilles > 0 && $categorieFille && $categorieNeutre) {
            $cadeauxPourFilles = Cadeau::whereIn('id_categorie_cadeau', [
                $categorieFille->id_categorie_cadeau,
                $categorieNeutre->id_categorie_cadeau,
            ])->inRandomOrder()->take($nbrFilles)->get();

            $suggestionsFilles = $cadeauxPourFilles->toArray();
            // Ajouter les IDs utilisés pour les exclure des garçons
            $idsUtilises = $cadeauxPourFilles->pluck('id_cadeau')->toArray();
        }

        // Cadeaux pour garçons: catégorie Garçon ou Neutre (exclure ceux déjà attribués aux filles)
        $suggestionsGarcons = [];
        if ($nbrGarcons > 0 && $categorieGarcon && $categorieNeutre) {
            $cadeauxPourGarcons = Cadeau::whereIn('id_categorie_cadeau', [
                $categorieGarcon->id_categorie_cadeau,
                $categorieNeutre->id_categorie_cadeau,
            ])
                ->whereNotIn('id_cadeau', $idsUtilises) // Exclure les cadeaux déjà attribués
                ->inRandomOrder()
                ->take($nbrGarcons)
                ->get();

            $suggestionsGarcons = $cadeauxPourGarcons->toArray();
        }

        // Stocker en session pour les échanges ultérieurs
        session([
            'filles' => $nbrFilles,
            'garcons' => $nbrGarcons,
            'suggestions_filles' => $suggestionsFilles,
            'suggestions_garcons' => $suggestionsGarcons,
        ]);

        return $this->afficherSuggestions();
    }

    /**
     * Affiche la page des suggestions (récupère les données depuis la session).
     */
    private function afficherSuggestions()
    {
        $nbrFilles = session('filles', 0);
        $nbrGarcons = session('garcons', 0);
        $suggestionsFilles = collect(session('suggestions_filles', []))->map(fn($c) => Cadeau::with('categorie')->find($c['id_cadeau']));
        $suggestionsGarcons = collect(session('suggestions_garcons', []))->map(fn($c) => Cadeau::with('categorie')->find($c['id_cadeau']));

        // Calculer le total
        $total = $suggestionsFilles->sum('prix') + $suggestionsGarcons->sum('prix');

        return view('utilisateur.liste-cadeaux-suggeres', compact(
            'filles',
            'garcons',
            'suggestionsFilles',
            'suggestionsGarcons',
            'total'
        ));
    }

    /**
     * Échange les cadeaux sélectionnés par de nouveaux cadeaux aléatoires.
     */
    public function echangerCadeaux(Request $request)
    {
        $echangerFilles = $request->input('echanger_filles', []);
        $echangerGarcons = $request->input('echanger_garcons', []);

        // Récupérer les suggestions actuelles depuis la session
        $suggestionsFilles = session('suggestions_filles', []);
        $suggestionsGarcons = session('suggestions_garcons', []);

        // Récupérer les IDs des catégories
        $categorieFille = CategorieCadeau::where('libelle', 'Fille')->first();
        $categorieGarcon = CategorieCadeau::where('libelle', 'Garçon')->first();
        $categorieNeutre = CategorieCadeau::where('libelle', 'Neutre')->first();

        // IDs des cadeaux déjà attribués (pour les exclure)
        $idsExclus = collect($suggestionsFilles)->pluck('id_cadeau')
            ->merge(collect($suggestionsGarcons)->pluck('id_cadeau'))
            ->toArray();

        // Échanger les cadeaux des filles sélectionnées
        foreach ($echangerFilles as $index) {
            if (isset($suggestionsFilles[$index])) {
                $nouveauCadeau = Cadeau::whereIn('id_categorie_cadeau', [
                    $categorieFille->id_categorie_cadeau,
                    $categorieNeutre->id_categorie_cadeau,
                ])
                    ->whereNotIn('id_cadeau', $idsExclus)
                    ->inRandomOrder()
                    ->first();

                if ($nouveauCadeau) {
                    $suggestionsFilles[$index] = $nouveauCadeau->toArray();
                    $idsExclus[] = $nouveauCadeau->id_cadeau;
                }
            }
        }

        // Échanger les cadeaux des garçons sélectionnés
        foreach ($echangerGarcons as $index) {
            if (isset($suggestionsGarcons[$index])) {
                $nouveauCadeau = Cadeau::whereIn('id_categorie_cadeau', [
                    $categorieGarcon->id_categorie_cadeau,
                    $categorieNeutre->id_categorie_cadeau,
                ])
                    ->whereNotIn('id_cadeau', $idsExclus)
                    ->inRandomOrder()
                    ->first();

                if ($nouveauCadeau) {
                    $suggestionsGarcons[$index] = $nouveauCadeau->toArray();
                    $idsExclus[] = $nouveauCadeau->id_cadeau;
                }
            }
        }

        // Mettre à jour la session
        session([
            'suggestions_filles' => $suggestionsFilles,
            'suggestions_garcons' => $suggestionsGarcons,
        ]);

        return $this->afficherSuggestions()->with('success', 'Cadeaux échangés avec succès !');
    }

    /**
     * Valide le choix des cadeaux et enregistre la sélection.
     */
    public function validerCadeaux(Request $request)
    {
        $suggestionsFilles = session('suggestions_filles', []);
        $suggestionsGarcons = session('suggestions_garcons', []);

        if (empty($suggestionsFilles) && empty($suggestionsGarcons)) {
            return redirect()->route('utilisateur.form-entrer-nbr-enfants')
                ->withErrors(['global' => 'Aucun cadeau à valider. Veuillez recommencer.']);
        }

        // TODO: Enregistrer le choix validé dans la base de données (table choix_valide, detail_choix_valide)
        // Pour l'instant, on simule la validation

        // Nettoyer la session
        session()->forget(['filles', 'garcons', 'suggestions_filles', 'suggestions_garcons']);

        return redirect()->route('utilisateur.accueil')
            ->with('success', 'Votre choix de cadeaux a été validé avec succès !');
    }
}
