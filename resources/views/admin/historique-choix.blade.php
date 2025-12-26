@extends('layouts.app')

@section('title', 'Admin - Historique des choix validés')

@section('sidebar')
@include('partials.side-bar-admin')
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <h1 class="text-3xl font-bold text-anthracite mb-6">Historique des choix validés (tous utilisateurs)</h1>

    <form method="GET" action="{{ route('admin.choix.historique') }}" class="bg-vert-clair p-4 rounded-xl shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-vert-foret text-sm font-sans mb-1">Utilisateur (ID)</label>
                <input type="number" name="user" value="{{ $currentUser }}" class="w-full border rounded-lg px-3 py-2" placeholder="ex: 1" />
            </div>
            <div>
                <label class="block text-vert-foret text-sm font-sans mb-1">Ordre</label>
                <select name="tri" class="w-full border rounded-lg px-3 py-2">
                    <option value="desc" {{ ($currentTri ?? 'desc') === 'desc' ? 'selected' : '' }}>Plus récent d'abord</option>
                    <option value="asc" {{ ($currentTri ?? 'desc') === 'asc' ? 'selected' : '' }}>Plus ancien d'abord</option>
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
                    <th class="text-left px-4 py-3 text-vert-foret">Choix #</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Utilisateur</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Date</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Montant total</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Nombre de cadeaux</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($choix as $cv)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $cv->id_choix }}</td>
                        <td class="px-4 py-3">#{{ $cv->id_utilisateur }} — {{ optional($cv->utilisateur)->nom }}</td>
                        <td class="px-4 py-3">{{ optional($cv->date_choix)->format('d/m/Y H:i') ?? '—' }}</td>
                        <td class="px-4 py-3">{{ number_format($cv->montant_total, 2, ',', ' ') }} Ar</td>
                        <td class="px-4 py-3">{{ $cv->details_count }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.choix.detail', ['id' => $cv->id_choix]) }}" class="text-rose-corail hover:underline">Voir le détail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-vert-foret">Aucun choix validé trouvé.</td>
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
