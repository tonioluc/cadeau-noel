<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le cadeau</title>
</head>
<body>
    <h1>Modifier le cadeau: <strong>{{ $cadeau->nom }}</strong></h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.cadeaux.update', $cadeau->id_cadeau) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label>Nom</label>
            <input type="text" name="nom" value="{{ old('nom', $cadeau->nom) }}" required>
        </div>
        <div style="margin-top: .5rem;">
            <label>Description</label>
            <textarea name="description">{{ old('description', $cadeau->description) }}</textarea>
        </div>
        <div style="margin-top: .5rem;">
            <label>Catégorie</label>
            <select name="id_categorie_cadeau" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id_categorie_cadeau }}" {{ (old('id_categorie_cadeau', $cadeau->id_categorie_cadeau) == $cat->id_categorie_cadeau) ? 'selected' : '' }}>
                        {{ $cat->libelle }}
                    </option>
                @endforeach
            </select>
        </div>
        <div style="margin-top: .5rem;">
            <label>Prix</label>
            <input type="number" step="0.01" name="prix" value="{{ old('prix', $cadeau->prix) }}" required>
        </div>
        <div style="margin-top: .5rem;">
            <label>Image actuelle</label>
            <div>
                @if($cadeau->chemin_image)
                    <img src="{{ asset($cadeau->chemin_image) }}" alt="Image" style="height:60px;">
                @else
                    —
                @endif
            </div>
        </div>
        <div style="margin-top: .5rem;">
            <label>Nouvelle image (optionnel)</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <div style="margin-top: 1rem;">
            <button type="submit">Enregistrer</button>
            <a href="{{ route('admin.cadeaux.index') }}" style="margin-left: .5rem;">Annuler</a>
        </div>
    </form>
</body>
</html>