<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\Cadeau;
use App\Models\Depot;
use App\Models\CommissionSite;

class AccueilController extends Controller
{
    public function index()
    {
        
        return view('utilisateur.accueil', [
            'utilisateur' => Utilisateur::findOrFail(session('id_utilisateur')),
        ]);
    }

    public function adminIndex()
    {
        // Dashboard stats
        $totalUtilisateurs = Utilisateur::where('id_utilisateur', 1)->count();
        $totalCadeaux = Cadeau::count();
        $depotsEnAttente = Depot::where('id_statut_depot', 1)->count(); // 1 = en attente
        $totalCommissions = CommissionSite::sum('montant_commission') ?? 0;

        return view('admin.accueil', [
            'utilisateur' => Utilisateur::findOrFail(session('id_utilisateur')),
            'totalUtilisateurs' => $totalUtilisateurs,
            'totalCadeaux' => $totalCadeaux,
            'depotsEnAttente' => $depotsEnAttente,
            'totalCommissions' => $totalCommissions,
        ]);
    }
}
