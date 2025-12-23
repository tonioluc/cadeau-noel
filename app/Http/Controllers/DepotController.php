<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepotRequest;
use App\Models\Depot;
use App\Models\HistoriqueStatutDepot;
use App\Models\Parametre;
use App\Models\StatutDepot;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class DepotController extends Controller
{
    public function showForm()
    {
        // Vérifier l'utilisateur connecté
        
        return view('utilisateur.form-depot');
    }
    public function deposer(DepotRequest $request)
    {
        // Vérifier l'utilisateur connecté
        
        $idUtilisateur = Session::get('id_utilisateur');

        $data = $request->validated();
        $montant = (float) $data['montant'];

        // Récupérer la commission actuelle (code COMM)
        $param = Parametre::where('code', 'COMM')->first();
        if (!$param) {
            return back()->withErrors(['commission' => 'Commission (COMM) non configurée.'])->withInput();
        }

        $commissionPercent = (float) $param->valeur; // ex: "10" => 10%
        $commissionRate = $commissionPercent / 100.0;

        // Calculs
        $commissionApplique = round($montant * $commissionRate, 2);
        $montantCredit = round($montant - $commissionApplique, 2);

        // Déterminer le statut initial du dépôt
        $statutId = StatutDepot::where('libelle', 'En attente')->value('id_statut_depot');
        if (!$statutId) {
            $first = StatutDepot::query()->value('id_statut_depot');
            if ($first) {
                $statutId = $first;
            } else {
                // Si aucun statut n'existe, en créer un minimal
                $created = StatutDepot::create(['libelle' => 'En attente']);
                $statutId = $created->id_statut_depot;
            }
        }

        // Démarrer la transaction
        DB::beginTransaction();
        try {
            // Création du dépôt
            $depot = Depot::create([
            'id_utilisateur' => $idUtilisateur,
            'montant_demande' => $montant,
            'montant_credit' => $montantCredit,
            'commission_applique' => $commissionPercent,
            'id_statut_depot' => $statutId,
            ]);

            // Enregistrement de l'historique du statut
            HistoriqueStatutDepot::create([
            'id_statut_depot' => $statutId,
            'id_depot' => $depot->id_depot,
            ]);

            // Valider la transaction
            DB::commit();
        } catch (\Exception $e) {
            // Annuler la transaction en cas d'erreur
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors de l\'enregistrement du dépôt : ' . $e->getMessage()])->withInput();
        }

        return redirect()->route('depot.show')->with('success', 'Dépôt enregistré avec succès.');
    }
}
