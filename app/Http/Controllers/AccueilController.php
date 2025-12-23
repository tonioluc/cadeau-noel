<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;

class AccueilController extends Controller
{
    public function index()
    {
        
        return view('utilisateur.accueil', [
            'utilisateur' => Utilisateur::findOrFail(session('id_utilisateur')),
        ]);
    }
}
