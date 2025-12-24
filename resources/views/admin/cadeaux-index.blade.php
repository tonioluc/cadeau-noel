<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des cadeaux</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #f5f5f5; }
    </style>
    <script>
        function confirmDelete() {
            return confirm('Confirmer la suppression ?');
        }
    </script>
</head>
<body>
    <h1>Liste des cadeaux</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="margin-bottom: 1rem;">
        <a href="{{ route('admin.cadeaux.create') }}">+ Ajouter un cadeau</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($cadeaux as $c)
            <tr>
                <td>{{ $c->id_cadeau }}</td>
                <td>{{ $c->nom }}</td>
                <td>{{ optional($c->categorie)->libelle }}</td>
                <td>{{ number_format($c->prix, 2, ',', ' ') }} Ar</td>
                <td>
                    @if($c->chemin_image)
                        <img src="{{ asset($c->chemin_image) }}" alt="Image" style="height:50px;">
                    @else
                        —
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.cadeaux.edit', $c->id_cadeau) }}">Modifier</a>
                    <form action="{{ route('admin.cadeaux.destroy', $c->id_cadeau) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="margin-left: 8px;">Supprimer</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center;">Aucun cadeau pour le moment.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top: 1rem;">
        {{ $cadeaux->links() }}
    </div>
</body>
</html>