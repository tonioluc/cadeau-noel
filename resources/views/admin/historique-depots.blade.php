@extends('layouts.app')

@section('title', 'Admin - Historique des dépôts')

@section('sidebar')
@include('partials.side-bar-admin')
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <h1 class="text-3xl font-bold text-anthracite mb-6">Historique des dépôts (tous utilisateurs)</h1>

    <form method="GET" action="{{ route('admin.depots.historique') }}" class="bg-vert-clair p-4 rounded-xl shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-vert-foret text-sm font-sans mb-1">Utilisateur (ID)</label>
                <input type="number" name="user" value="{{ $currentUser }}" class="w-full border rounded-lg px-3 py-2" placeholder="ex: 1" />
            </div>
            <div>
                <label class="block text-vert-foret text-sm font-sans mb-1">Statut</label>
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
                    <th class="text-left px-4 py-3 text-vert-foret">Dépôt #</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Utilisateur</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Montant demandé</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Montant crédité</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Commission (%)</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($depots as $depot)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $depot->id_depot }}</td>
                        <td class="px-4 py-3">#{{ $depot->id_utilisateur }} — {{ optional($depot->utilisateur)->nom }}</td>
                        <td class="px-4 py-3">{{ number_format($depot->montant_demande, 2, ',', ' ') }} Ar</td>
                        <td class="px-4 py-3">{{ number_format($depot->montant_credit, 2, ',', ' ') }} Ar</td>
                        <td class="px-4 py-3">{{ number_format($depot->commission_applique, 2, ',', ' ') }}</td>
                        <td class="px-4 py-3">{{ optional($depot->statut)->libelle ?? '—' }}</td>
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
        <a href="{{ route('admin.accueil') }}" class="text-vert-foret hover:underline">← Retour tableau de bord</a>
    </div>
</div>
@endsection
