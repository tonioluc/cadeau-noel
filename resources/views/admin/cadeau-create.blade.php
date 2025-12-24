<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un cadeau</title>
</head>
<body>
    <h1>Ajouter un cadeau</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.cadeaux.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label>Nom</label>
            <input type="text" name="nom" value="{{ old('nom') }}" required>
        </div>
        <div style="margin-top: .5rem;">
            <label>Description</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>
        <div style="margin-top: .5rem;">
            <label>Catégorie</label>
            <select name="id_categorie_cadeau" required>
                <option value="">-- Sélectionner --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id_categorie_cadeau }}" {{ old('id_categorie_cadeau') == $cat->id_categorie_cadeau ? 'selected' : '' }}>
                        {{ $cat->libelle }}
                    </option>
                @endforeach
            </select>
        </div>
        <div style="margin-top: .5rem;">
            <label>Prix</label>
            <input type="number" step="0.01" name="prix" value="{{ old('prix') }}" required>
        </div>
        <div style="margin-top: .5rem;">
            <label>Image (optionnel)</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <div style="margin-top: 1rem;">
            <button type="submit">Créer</button>
            <a href="{{ route('admin.cadeaux.index') }}" style="margin-left: .5rem;">Annuler</a>
        </div>
    </form>
</body>
</html>