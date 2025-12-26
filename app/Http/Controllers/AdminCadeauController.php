<?php

namespace App\Http\Controllers;

use App\Models\Cadeau;
use App\Models\CategorieCadeau;
use App\Models\ChoixValide;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCadeauRequest;
use App\Http\Requests\UpdateCadeauRequest;
use Illuminate\Support\Facades\File;

class AdminCadeauController extends Controller
{
    public function index(Request $request)
    {
        $query = Cadeau::with('categorie');

        // Recherche par nom
        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        // Filtre par catégorie
        if ($request->filled('categorie')) {
            $query->where('id_categorie_cadeau', $request->categorie);
        }

        // Tri par prix
        $triPrix = $request->input('tri_prix', 'desc');
        if ($triPrix === 'asc') {
            $query->orderBy('prix', 'asc');
        } elseif ($triPrix === 'desc') {
            $query->orderBy('prix', 'desc');
        } else {
            $query->orderByDesc('id_cadeau');
        }

        $cadeaux = $query->paginate(5)->withQueryString();
        $categories = CategorieCadeau::orderBy('libelle')->get();

        return view('admin.cadeaux-index', compact('cadeaux', 'categories'));
    }

    public function create()
    {
        $categories = CategorieCadeau::orderBy('libelle')->get();
        return view('admin.cadeau-create', compact('categories'));
    }

    public function store(StoreCadeauRequest $request)
    {
        $validated = $request->validated();

        $cheminImage = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
            $destination = public_path('uploads/cadeaux');
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }
            $image->move($destination, $filename);
            $cheminImage = 'uploads/cadeaux/' . $filename;
        }

        Cadeau::create([
            'nom' => $validated['nom'],
            'description' => $validated['description'] ?? null,
            'id_categorie_cadeau' => $validated['id_categorie_cadeau'],
            'prix' => $validated['prix'],
            'chemin_image' => $cheminImage,
        ]);

        return redirect()->route('admin.cadeaux.index')->with('success', 'Cadeau créé avec succès.');
    }

    public function edit($id)
    {
        $cadeau = Cadeau::findOrFail($id);
        $categories = CategorieCadeau::orderBy('libelle')->get();
        return view('admin.cadeau-edit', compact('cadeau', 'categories'));
    }

    public function update(UpdateCadeauRequest $request, $id)
    {
        $cadeau = Cadeau::findOrFail($id);

        $validated = $request->validated();

        $cheminImage = $cadeau->chemin_image;
        if ($request->hasFile('image')) {
            if ($cheminImage && File::exists(public_path($cheminImage))) {
                File::delete(public_path($cheminImage));
            }
            $image = $request->file('image');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
            $destination = public_path('uploads/cadeaux');
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }
            $image->move($destination, $filename);
            $cheminImage = 'uploads/cadeaux/' . $filename;
        }

        $cadeau->update([
            'nom' => $validated['nom'],
            'description' => $validated['description'] ?? null,
            'id_categorie_cadeau' => $validated['id_categorie_cadeau'],
            'prix' => $validated['prix'],
            'chemin_image' => $cheminImage,
        ]);

        return redirect()->route('admin.cadeaux.index')->with('success', 'Cadeau mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $cadeau = Cadeau::findOrFail($id);
        if ($cadeau->chemin_image && File::exists(public_path($cadeau->chemin_image))) {
            File::delete(public_path($cadeau->chemin_image));
        }
        $cadeau->delete();
        return redirect()->route('admin.cadeaux.index')->with('success', 'Cadeau supprimé avec succès.');
    }

    /**
     * Admin: Historique des choix validés pour tous les utilisateurs.
     */
    public function adminHistoriqueChoix(Request $request)
    {
        $tri = strtolower($request->query('tri', 'desc')) === 'asc' ? 'asc' : 'desc';
        $userId = $request->query('user');

        $choix = ChoixValide::with(['utilisateur'])
            ->withCount('details')
            ->when($userId, fn($q) => $q->where('id_utilisateur', (int) $userId))
            ->orderBy('date_choix', $tri)
            ->get();

        return view('admin.historique-choix', [
            'choix' => $choix,
            'currentTri' => $tri,
            'currentUser' => $userId,
        ]);
    }

    /**
     * Admin: Détail d'un choix validé (sans restriction d'utilisateur).
     */
    public function adminDetailChoix($id)
    {
        $choix = ChoixValide::with(['utilisateur', 'details.cadeau.categorie'])
            ->where('id_choix', $id)
            ->firstOrFail();

        return view('admin.detail-choix', [
            'choix' => $choix,
        ]);
    }
}
