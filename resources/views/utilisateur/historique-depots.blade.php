@extends('layouts.app')

@section('title', 'Historique des dépôts')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <h1 class="text-3xl font-bold text-anthracite mb-6">Historique de vos dépôts</h1>

    <form method="GET" action="{{ route('utilisateur.historique-depots') }}" class="bg-vert-clair p-4 rounded-xl shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-vert-foret text-sm font-sans mb-1">Filtrer par statut</label>
                <select name="statut" class="w-full border rounded-lg px-3 py-2">
                    <option value="Tous" {{ ($currentStatut ?? 'Tous') === 'Tous' ? 'selected' : '' }}>Tous</option>
                    @foreach($statuts as $st)
                        <option value="{{ $st->libelle }}" {{ ($currentStatut ?? 'Tous') === $st->libelle ? 'selected' : '' }}>{{ $st->libelle }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-vert-foret text-sm font-sans mb-1">Trier par</label>
                <select name="par" class="w-full border rounded-lg px-3 py-2">
                    <option value="demande" {{ ($currentPar ?? 'demande') === 'demande' ? 'selected' : '' }}>Montant demandé</option>
                    <option value="credit" {{ ($currentPar ?? 'demande') === 'credit' ? 'selected' : '' }}>Montant crédité</option>
                </select>
            </div>
            <div>
                <label class="block text-vert-foret text-sm font-sans mb-1">Ordre</label>
                <select name="tri" class="w-full border rounded-lg px-3 py-2">
                    <option value="desc" {{ ($currentTri ?? 'desc') === 'desc' ? 'selected' : '' }}>Décroissant</option>
                    <option value="asc" {{ ($currentTri ?? 'desc') === 'asc' ? 'selected' : '' }}>Croissant</option>
                </select>
            </div>
            <div>
                <button type="submit" class="bg-rose-corail hover:bg-anthracite text-white font-semibold py-2 px-4 rounded-lg">Appliquer</button>
            </div>
        </div>
    </form>

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-vert-clair">
                <tr>
                    <th class="text-left px-4 py-3 text-vert-foret">#</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Montant demandé</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Montant crédité</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Commission (%)</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Statut actuel</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Dernier changement</th>
                </tr>
            </thead>
            <tbody>
                @forelse($depots as $depot)
                    @php
                        $dernier = optional($depot->historiques)->sortByDesc('date_changement')->first();
                    @endphp
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $depot->id_depot }}</td>
                        <td class="px-4 py-3">{{ number_format($depot->montant_demande, 2, ',', ' ') }} Ar</td>
                        <td class="px-4 py-3">{{ number_format($depot->montant_credit, 2, ',', ' ') }} Ar</td>
                        <td class="px-4 py-3">{{ number_format($depot->commission_applique, 2, ',', ' ') }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-3 py-1 rounded-full text-white text-sm
                                {{ $depot->statut && $depot->statut->libelle === 'Valide' ? 'bg-green-600' : '' }}
                                {{ $depot->statut && $depot->statut->libelle === 'Rejete' ? 'bg-red-600' : '' }}
                                {{ $depot->statut && $depot->statut->libelle === 'En attente' ? 'bg-yellow-500' : '' }}">
                                {{ $depot->statut->libelle ?? '—' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $dernier ? $dernier->date_changement->format('d/m/Y H:i') : '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-vert-foret">Aucun dépôt trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('utilisateur.accueil') }}" class="text-vert-foret hover:underline">← Retour à l'accueil</a>
    </div>
</div>
@endsection
