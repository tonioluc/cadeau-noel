<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = Utilisateur::create([
            'nom' => $data['nom'],
            'mot_de_passe' => Hash::make($data['mot_de_passe']),
        ]);

        // Store the user's id in session
        Session::put('id_utilisateur', $user->id_utilisateur);

        return redirect()->route('utilisateur.accueil');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = Utilisateur::where('nom', $data['nom'])->first();

        if ($user && Hash::check($data['mot_de_passe'], $user->mot_de_passe)) {
            Session::put('id_utilisateur', $user->id_utilisateur);
            return redirect()->route('utilisateur.accueil');
        }

        return back()
            ->withErrors(['credentials' => "Nom d'utilisateur ou mot de passe incorrect."])
            ->withInput();
    }
}
