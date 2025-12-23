<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepotRequest;
use App\Models\CommissionSite;
use App\Models\Depot;
use App\Models\Utilisateur;
use App\Models\HistoriqueStatutDepot;
use App\Models\Parametre;
use App\Models\StatutDepot;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DepotController extends Controller
{
    public function showForm()
    {
        return view('utilisateur.form-depot');
    }
    public function deposer(DepotRequest $request)
    {
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

    public function showValidation()
    {
        // Récupère l'id du statut "En attente"
        $statutId = StatutDepot::where('libelle', 'En attente')->value('id_statut_depot');

        if ($statutId) {
            // Charger les dépôts en attente avec leur statut et utilisateur
            $depots = Depot::with(['statut', 'utilisateur'])
                ->where('id_statut_depot', $statutId)
                ->get();
        } else {
            $depots = collect();
        }

        return view('admin.validation-depot', compact('depots'));
    }

    public function validerDepot(Request $request)
    {
        $idDepot = $request->input('id_depot');
        if (!$idDepot) {
            return back()->withErrors(['id_depot' => 'Identifiant de dépôt manquant.']);
        }

        // Récupérer l'id du statut "Validé"
        $statutValideId = StatutDepot::where('libelle', 'Valide')->value('id_statut_depot');
        if (!$statutValideId) {
            return back()->withErrors(['statut' => 'Le statut "Validé" n\'existe pas.']);
        }

        DB::beginTransaction();
        try {
            // Mettre à jour le statut du dépôt
            $depot = Depot::findOrFail($idDepot);
            $depot->id_statut_depot = $statutValideId;
            $depot->save();

            // Utilisateur
            $utilisateur = Utilisateur::findOrFail((int) $depot->id_utilisateur);
            $utilisateur->solde += $depot->montant_credit;
            $utilisateur->save();

            // Enregistrer l'historique du statut
            HistoriqueStatutDepot::create([
                'id_statut_depot' => $statutValideId,
                'id_depot' => $idDepot,
            ]);

            CommissionSite::create([
                'id_depot' => $idDepot,
                'montant_commission' => round($depot->montant_demande - $depot->montant_credit, 2),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors de la validation du dépôt : ' . $e->getMessage()]);
        }

        return redirect()->route('depot.en-attente.list')->with('success', 'Dépôt validé avec succès.');
    }

    public function rejeterDepot(Request $request)
    {
        $idDepot = $request->input('id_depot');
        if (!$idDepot) {
            return back()->withErrors(['id_depot' => 'Identifiant de dépôt manquant.']);
        }

        // Récupérer l'id du statut "Refusé"
        $statutRefuseId = StatutDepot::where('libelle', 'Rejete')->value('id_statut_depot');
        if (!$statutRefuseId) {
            return back()->withErrors(['statut' => 'Le statut "Refusé" n\'existe pas.']);
        }

        DB::beginTransaction();
        try {
            // Mettre à jour le statut du dépôt
            $depot = Depot::findOrFail($idDepot);
            $depot->id_statut_depot = $statutRefuseId;
            $depot->save();

            // Enregistrer l'historique du statut
            HistoriqueStatutDepot::create([
                'id_statut_depot' => $statutRefuseId,
                'id_depot' => $idDepot,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors du rejet du dépôt : ' . $e->getMessage()]);
        }

        return redirect()->route('depot.en-attente.list')->with('success', 'Dépôt refusé avec succès.');
    }
}