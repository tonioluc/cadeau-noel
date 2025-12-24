<?php

namespace App\Http\Controllers;

use App\Models\Cadeau;
use App\Models\CategorieCadeau;
use App\Http\Requests\StoreCadeauRequest;
use App\Http\Requests\UpdateCadeauRequest;
use Illuminate\Support\Facades\File;

class AdminCadeauController extends Controller
{
    public function index()
    {
        $cadeaux = Cadeau::with('categorie')->orderByDesc('id_cadeau')->paginate(15);
        return view('admin.cadeaux-index', compact('cadeaux'));
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
}
