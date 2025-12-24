<h1>Cadeaux suggérés pour vos enfants</h1>

<p>
    <strong>Nombre de filles :</strong> {{ $filles }} |
    <strong>Nombre de garçons :</strong> {{ $garcons }}
</p>

@if (session('success'))
    <div style="color: green; margin-bottom: 1em;">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div style="color: red; margin-bottom: 1em;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('utilisateur.echanger-cadeaux') }}">
    @csrf

    {{-- Cadeaux pour les filles --}}
    @if ($filles > 0)
        <h2>Cadeaux pour les filles</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Échanger</th>
                    <th>Enfant</th>
                    <th>Cadeau</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suggestionsFilles as $index => $cadeau)
                    <tr>
                        <td style="text-align: center;">
                            <input type="checkbox" name="echanger_filles[]" value="{{ $index }}">
                        </td>
                        <td>Fille {{ $index + 1 }}</td>
                        <td>{{ $cadeau->nom }}</td>
                        <td>{{ $cadeau->categorie->libelle }}</td>
                        <td>{{ number_format($cadeau->prix, 2, ',', ' ') }} Ar</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Cadeaux pour les garçons --}}
    @if ($garcons > 0)
        <h2>Cadeaux pour les garçons</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Échanger</th>
                    <th>Enfant</th>
                    <th>Cadeau</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suggestionsGarcons as $index => $cadeau)
                    <tr>
                        <td style="text-align: center;">
                            <input type="checkbox" name="echanger_garcons[]" value="{{ $index }}">
                        </td>
                        <td>Garçon {{ $index + 1 }}</td>
                        <td>{{ $cadeau->nom }}</td>
                        <td>{{ $cadeau->categorie->libelle }}</td>
                        <td>{{ number_format($cadeau->prix, 2, ',', ' ') }} Ar</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Résumé --}}
    <h3>Résumé</h3>
    <p><strong>Total :</strong> {{ number_format($total, 2, ',', ' ') }} Ar</p>

    <div style="margin-top: 1em;">
        <button type="submit" name="action" value="echanger">Échanger les cadeaux sélectionnés</button>
        <button type="submit" name="action" value="valider" formaction="{{ route('utilisateur.valider-cadeaux') }}">Valider ce choix</button>
    </div>
</form>

<div style="margin-top: 1em;">
    <a href="{{ route('utilisateur.form-entrer-nbr-enfants') }}">← Retour au formulaire</a>
</div>
