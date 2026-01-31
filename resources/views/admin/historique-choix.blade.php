@extends('layouts.app')

@section('title', 'Admin - Historique des choix validés')

@section('sidebar')
@include('partials.side-bar-admin')
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-4 md:py-8 px-4">
    <h1 class="text-2xl md:text-3xl font-bold text-anthracite mb-4 md:mb-6">Historique des choix validés</h1>

    <form method="GET" action="{{ route('admin.choix.historique') }}" class="bg-vert-clair p-3 md:p-4 rounded-xl shadow mb-4 md:mb-6">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4 items-end">
            <div>
                <label class="block text-vert-foret text-xs md:text-sm font-sans mb-1">Utilisateur (ID)</label>
                <input type="number" name="user" value="{{ $currentUser }}" class="w-full border rounded-lg px-2 md:px-3 py-2 text-sm" placeholder="ex: 1" />
            </div>
            <div>
                <label class="block text-vert-foret text-xs md:text-sm font-sans mb-1">Ordre</label>
                <select name="tri" class="w-full border rounded-lg px-2 md:px-3 py-2 text-sm">
                    <option value="desc" {{ ($currentTri ?? 'desc') === 'desc' ? 'selected' : '' }}>Plus récent d'abord</option>
                    <option value="asc" {{ ($currentTri ?? 'desc') === 'asc' ? 'selected' : '' }}>Plus ancien d'abord</option>
                </select>
            </div>
            <div class="col-span-2 md:col-span-1">
                <button type="submit" class="w-full bg-rose-corail hover:bg-anthracite text-white font-semibold py-2 px-3 md:px-4 rounded-lg text-sm">Appliquer</button>
            </div>
        </div>
    </form>

    <!-- Mobile view: cards -->
    <div class="md:hidden space-y-3">
        @forelse($choix as $cv)
            <div class="bg-white rounded-xl shadow p-4">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-bold text-anthracite">#{{ $cv->id_choix }}</span>
                    <span class="text-xs text-gray-500">{{ optional($cv->date_choix)->format('d/m/Y') ?? '—' }}</span>
                </div>
                <p class="text-sm text-gray-600 mb-2">#{{ $cv->id_utilisateur }} — {{ optional($cv->utilisateur)->nom }}</p>
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Montant total:</span>
                        <span class="font-semibold">{{ number_format($cv->montant_total, 2, ',', ' ') }} Ar</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Cadeaux:</span>
                        <span>{{ $cv->details_count }}</span>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t">
                    <a href="{{ route('admin.choix.detail', ['id' => $cv->id_choix]) }}" class="block w-full text-center bg-rose-corail text-white py-2 rounded-lg text-sm">Voir le détail</a>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow p-6 text-center text-vert-foret">
                Aucun choix validé trouvé.
            </div>
        @endforelse
    </div>

    <!-- Desktop view: table -->
    <div class="hidden md:block bg-white rounded-xl shadow overflow-x-auto">
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

    <div class="mt-4 md:mt-6">
        <a href="{{ route('admin.accueil') }}" class="text-vert-foret hover:underline text-sm md:text-base">← Retour tableau de bord</a>
    </div>
</div>
@endsection
