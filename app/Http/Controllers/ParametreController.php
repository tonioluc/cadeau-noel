<?php

namespace App\Http\Controllers;

use App\Models\Parametre;
use App\Models\HistoriqueParametre;
use App\Http\Requests\UpdateParametreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParametreController extends Controller
{
    // Liste tous les paramètres
    public function index()
    {
        $parametres = Parametre::all();
        return view('admin.parametres-index', compact('parametres'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('admin.parametre-create');
    }

    // Enregistre un nouveau paramètre
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:parametres,code',
            'libelle' => 'required|string|max:255',
            'valeur' => 'required|numeric',
        ], [
            'code.required' => 'Le code est obligatoire.',
            'code.unique' => 'Ce code existe déjà.',
            'libelle.required' => 'Le libellé est obligatoire.',
            'valeur.required' => 'La valeur est obligatoire.',
            'valeur.numeric' => 'La valeur doit être un nombre.',
        ]);

        Parametre::create($validated);

        return redirect()->route('admin.parametres.index')->with('success', 'Paramètre créé avec succès.');
    }

    // Affiche le formulaire d'édition pour un paramètre par son code
    public function edit(string $code)
    {
        $parametre = Parametre::where('code', $code)->first();
        if (!$parametre) {
            abort(404, 'Paramètre introuvable.');
        }

        return view('admin.parametre-edit', compact('parametre'));
    }

    // Met à jour la valeur du paramètre, en journalisant d'abord l'historique
    public function update(UpdateParametreRequest $request, string $code)
    {
        $parametre = Parametre::where('code', $code)->first();
        if (!$parametre) {
            return back()->withErrors(['parametre' => 'Paramètre introuvable.']);
        }

        // Validation via FormRequest (messages FR personnalisés)
        $validated = $request->validated();

        $ancienne = (string) $parametre->valeur;
        $nouvelle = (string) $validated['valeur'];

        if ($ancienne === $nouvelle) {
            return back()->with('info', 'Aucune modification détectée.');
        }

        DB::beginTransaction();
        try {
            // 1) Créer l'entrée d'historique
            HistoriqueParametre::create([
                'id_parametre' => $parametre->id_parametre,
                'ancienne_valeur' => $ancienne,
                'nouvelle_valeur' => $nouvelle,
            ]);

            // 2) Mettre à jour le paramètre
            $parametre->valeur = $nouvelle;
            $parametre->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => "Impossible de mettre à jour le paramètre: ".$e->getMessage()]);
        }

        return redirect()->route('admin.parametres.index')->with('success', 'Paramètre mis à jour avec succès.');
    }

    // Supprime un paramètre
    public function destroy(string $code)
    {
        $parametre = Parametre::where('code', $code)->first();
        if (!$parametre) {
            return back()->withErrors(['parametre' => 'Paramètre introuvable.']);
        }

        // Supprimer l'historique associé d'abord
        HistoriqueParametre::where('id_parametre', $parametre->id_parametre)->delete();
        $parametre->delete();

        return redirect()->route('admin.parametres.index')->with('success', 'Paramètre supprimé avec succès.');
    }
}
