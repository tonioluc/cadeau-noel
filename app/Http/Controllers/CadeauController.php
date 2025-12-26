<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateNombreEnfants;
use App\Models\Cadeau;
use App\Models\CategorieCadeau;
use App\Models\ChoixValide;
use App\Models\DetailChoixValide;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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
            'nbrFilles' => $nbrFilles,
            'nbrGarcons' => $nbrGarcons,
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
        $nbrFilles = session('nbrFilles', 0);
        $nbrGarcons = session('nbrGarcons', 0);
        $suggestionsFilles = collect(session('suggestions_filles', []))->map(fn($c) => Cadeau::with('categorie')->find($c['id_cadeau']));
        $suggestionsGarcons = collect(session('suggestions_garcons', []))->map(fn($c) => Cadeau::with('categorie')->find($c['id_cadeau']));
        $idUtilisateur = session('id_utilisateur');
        $utilisateur = Utilisateur::find($idUtilisateur);

        // Calculer le total
        $total = $suggestionsFilles->sum('prix') + $suggestionsGarcons->sum('prix');

        return view('utilisateur.liste-cadeaux-suggeres', compact(
            'utilisateur',
            'nbrFilles',
            'nbrGarcons',
            'suggestionsFilles',
            'suggestionsGarcons',
            'total'
        ));
    }

    private function echangerCadeauxPourCategorie(&$suggestions, $categorieIds, &$idsExclus, $indices)
    {
        foreach ($indices as $index) {
            if (isset($suggestions[$index])) {
                $nouveauCadeau = Cadeau::whereIn('id_categorie_cadeau', $categorieIds)
                    ->whereNotIn('id_cadeau', $idsExclus)
                    ->inRandomOrder()
                    ->first();

                if ($nouveauCadeau) {
                    $suggestions[$index] = $nouveauCadeau->toArray();
                    $idsExclus[] = $nouveauCadeau->id_cadeau;
                }
            }
        }
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
        $this->echangerCadeauxPourCategorie(
            $suggestionsFilles,
            [$categorieFille->id_categorie_cadeau, $categorieNeutre->id_categorie_cadeau],
            $idsExclus,
            $echangerFilles
        );

        // Échanger les cadeaux des garçons sélectionnés
        $this->echangerCadeauxPourCategorie(
            $suggestionsGarcons,
            [$categorieGarcon->id_categorie_cadeau, $categorieNeutre->id_categorie_cadeau],
            $idsExclus,
            $echangerGarcons
        );

        // Mettre à jour la session
        session([
            'suggestions_filles' => $suggestionsFilles,
            'suggestions_garcons' => $suggestionsGarcons,
        ]);

        return $this->afficherSuggestions()->with('success', 'Cadeaux échangés avec succès !');
    }

    function saveToDetailChoixValide($nbrEnfants, $suggestions, $typeEnfant, $idChoixValide)
    {
        for ($i = 1; $i <= $nbrEnfants; $i++) {
            DetailChoixValide::create([
                'id_cadeau' => $suggestions[$i - 1]['id_cadeau'],
                'type_enfant' => $typeEnfant,
                'id_choix' => $idChoixValide,
                'numero_enfant' => $i,
            ]);
        }
    }

    /**
     * Valide le choix des cadeaux et enregistre la sélection.
     */
    public function validerCadeaux()
    {
        $suggestionsFilles = session('suggestions_filles', []);
        $suggestionsGarcons = session('suggestions_garcons', []);

        if (empty($suggestionsFilles) && empty($suggestionsGarcons)) {
            return redirect()->route('utilisateur.form-entrer-nbr-enfants')
                ->withErrors(['global' => 'Aucun cadeau à valider. Veuillez recommencer.']);
        }

        $idUtilisateur = session('id_utilisateur');
        $utilisateur = Utilisateur::find($idUtilisateur);
        $total = collect($suggestionsFilles)->sum('prix') + collect($suggestionsGarcons)->sum('prix');
        if ($utilisateur->solde < $total) {
            return redirect()->route('utilisateur.accueil')
                ->withErrors(['global' => 'Solde insuffisant pour valider ces cadeaux.']);
        }
        DB::beginTransaction();
        try {
            // Débiter le solde de l'utilisateur
            $utilisateur->solde -= $total;
            $utilisateur->save();

            // Enregistrer les cadeaux choisis
            $choixValide = ChoixValide::create([
                'id_utilisateur' => $idUtilisateur,
                'montant_total' => $total,
                'nbr_fille' => count($suggestionsFilles),
                'nbr_garcon' => count($suggestionsGarcons),
            ]);

            $nbrFilles = session('nbrFilles', 0);
            $nbrGarcons = session('nbrGarcons', 0);

            $this->saveToDetailChoixValide($nbrGarcons, $suggestionsGarcons, 'GARCON', $choixValide->id_choix);
            $this->saveToDetailChoixValide($nbrFilles, $suggestionsFilles, 'FILLE', $choixValide->id_choix);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('utilisateur.form-entrer-nbr-enfants')->withErrors(['global' => 'Erreur lors de la validation des cadeaux : ' . $e->getMessage()]);
        }
        // Nettoyer la session
        session()->forget(['nbrFilles', 'nbrGarcons', 'suggestions_filles', 'suggestions_garcons']);

        return redirect()->route('utilisateur.form-entrer-nbr-enfants')
            ->with('success', 'Votre choix de cadeaux a été validé avec succès !');
    }

    /**
     * Affiche l'historique des choix validés de l'utilisateur connecté.
     */
    public function historiqueChoix(Request $request)
    {
        $idUtilisateur = Session::get('id_utilisateur');

        $tri = strtolower($request->query('tri', 'desc')) === 'asc' ? 'asc' : 'desc';

        $choix = ChoixValide::withCount('details')
            ->where('id_utilisateur', $idUtilisateur)
            ->orderBy('date_choix', $tri)
            ->get();

        return view('utilisateur.historique-choix', [
            'choix' => $choix,
            'currentTri' => $tri,
        ]);
    }

    /**
     * Affiche le détail d'un choix validé (vérifie qu'il appartient à l'utilisateur connecté).
     */
    public function detailChoix($id)
    {
        $idUtilisateur = Session::get('id_utilisateur');

        $choix = ChoixValide::with(['details.cadeau.categorie'])
            ->where('id_choix', $id)
            ->where('id_utilisateur', $idUtilisateur)
            ->firstOrFail();

        return view('utilisateur.detail-choix', [
            'choix' => $choix,
        ]);
    }

}
