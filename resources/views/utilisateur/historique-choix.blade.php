@extends('layouts.app')

@section('title', 'Historique des choix validés')

@section('content')
<div class="max-w-6xl mx-auto py-4 md:py-8 px-4">
    <h1 class="text-2xl md:text-3xl font-bold text-anthracite mb-4 md:mb-6">Historique de vos choix validés</h1>

    <form method="GET" action="{{ route('utilisateur.historique-choix') }}" class="bg-vert-clair p-3 md:p-4 rounded-xl shadow mb-4 md:mb-6">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3 sm:gap-4">
            <div class="flex-1">
                <label class="block text-vert-foret text-xs md:text-sm font-sans mb-1">Ordre</label>
                <select name="tri" class="w-full border rounded-lg px-2 md:px-3 py-2 text-sm">
                    <option value="desc" {{ ($currentTri ?? 'desc') === 'desc' ? 'selected' : '' }}>Plus récent d'abord</option>
                    <option value="asc" {{ ($currentTri ?? 'desc') === 'asc' ? 'selected' : '' }}>Plus ancien d'abord</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full sm:w-auto bg-rose-corail hover:bg-anthracite text-white font-semibold py-2 px-4 rounded-lg text-sm">Appliquer</button>
            </div>
        </div>
    </form>

    <!-- Mobile view: cards -->
    <div class="md:hidden space-y-3">
        @forelse($choix as $cv)
            <div class="bg-white rounded-xl shadow p-4">
                <div class="flex justify-between items-start mb-2">
                    <span class="text-xs text-vert-foret">#{{ $cv->id_choix }}</span>
                    <span class="text-xs text-gray-500">{{ optional($cv->date_choix)->format('d/m/Y H:i') ?? '—' }}</span>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-vert-foret">Montant total:</span>
                        <span class="font-semibold">{{ number_format($cv->montant_total, 2, ',', ' ') }} Ar</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-vert-foret">Nombre de cadeaux:</span>
                        <span class="font-semibold">{{ $cv->details_count }}</span>
                    </div>
                    <div class="pt-2">
                        <a href="{{ route('utilisateur.detail-choix', ['id' => $cv->id_choix]) }}" class="block w-full text-center bg-rose-corail text-white py-2 rounded-lg text-sm">Voir le détail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow p-6 text-center text-vert-foret">
                Aucun choix validé pour le moment.
            </div>
        @endforelse
    </div>

    <!-- Desktop view: table -->
    <div class="hidden md:block bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-vert-clair">
                <tr>
                    <th class="text-left px-4 py-3 text-vert-foret">#</th>
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
                        <td class="px-4 py-3">{{ optional($cv->date_choix)->format('d/m/Y H:i') ?? '—' }}</td>
                        <td class="px-4 py-3">{{ number_format($cv->montant_total, 2, ',', ' ') }} Ar</td>
                        <td class="px-4 py-3">{{ $cv->details_count }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('utilisateur.detail-choix', ['id' => $cv->id_choix]) }}" class="text-rose-corail hover:underline">Voir le détail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-vert-foret">Aucun choix validé pour le moment.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 md:mt-6">
        <a href="{{ route('utilisateur.accueil') }}" class="text-vert-foret hover:underline text-sm md:text-base">← Retour à l'accueil</a>
    </div>
</div>
@endsection
