<?php

namespace App\Http\Controllers;

use App\Models\Parametre;
use App\Models\HistoriqueParametre;
use App\Http\Requests\UpdateParametreRequest;
use Illuminate\Support\Facades\DB;

class ParametreController extends Controller
{
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

        return redirect()->route('admin.parametres.edit', $code)->with('success', 'Paramètre mis à jour avec succès.');
    }
}
