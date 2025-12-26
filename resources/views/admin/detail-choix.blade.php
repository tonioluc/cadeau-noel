@extends('layouts.app')

@section('title', 'Admin - Détail du choix validé')

@section('sidebar')
@include('partials.side-bar-admin')
@endsection

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <h1 class="text-3xl font-bold text-anthracite mb-6">Détail du choix #{{ $choix->id_choix }}</h1>

    <div class="bg-vert-clair rounded-xl p-6 shadow mb-6 grid grid-cols-1 md:grid-cols-4 gap-6">
        <div>
            <p class="text-vert-foret text-sm uppercase">Utilisateur</p>
            <p class="text-anthracite text-lg">#{{ $choix->id_utilisateur }} — {{ optional($choix->utilisateur)->nom }}</p>
        </div>
        <div>
            <p class="text-vert-foret text-sm uppercase">Date</p>
            <p class="text-anthracite text-lg">{{ optional($choix->date_choix)->format('d/m/Y H:i') ?? '—' }}</p>
        </div>
        <div>
            <p class="text-vert-foret text-sm uppercase">Montant total</p>
            <p class="text-anthracite text-lg">{{ number_format($choix->montant_total, 2, ',', ' ') }} Ar</p>
        </div>
        <div>
            <p class="text-vert-foret text-sm uppercase">Nombre de cadeaux</p>
            <p class="text-anthracite text-lg">{{ $choix->details->count() }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-vert-clair">
                <tr>
                    <th class="text-left px-4 py-3 text-vert-foret">Image</th>
                    <th class="text-left px-4 py-3 text-vert-foret">#</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Cadeau</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Catégorie</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Prix</th>
                    <th class="text-left px-4 py-3 text-vert-foret">Type enfant</th>
                    <th class="text-left px-4 py-3 text-vert-foret">N° enfant</th>
                </tr>
            </thead>
            <tbody>
                @forelse($choix->details as $detail)
                    <tr class="border-t">
                        <td class="px-4 py-3">
                            @php
                                $img = ($detail->cadeau && $detail->cadeau->chemin_image)
                                    ? asset($detail->cadeau->chemin_image)
                                    : asset('images/gift-image.png');
                            @endphp
                            <img src="{{ $img }}" alt="{{ $detail->cadeau->nom ?? 'Cadeau' }}" class="h-12 w-12 object-cover rounded" />
                        </td>
                        <td class="px-4 py-3">{{ $detail->id_detail }}</td>
                        <td class="px-4 py-3">{{ $detail->cadeau->nom ?? '—' }}</td>
                        <td class="px-4 py-3">{{ optional($detail->cadeau->categorie)->libelle ?? '—' }}</td>
                        <td class="px-4 py-3">{{ isset($detail->cadeau->prix) ? number_format($detail->cadeau->prix, 2, ',', ' ') . ' Ar' : '—' }}</td>
                        <td class="px-4 py-3">{{ $detail->type_enfant }}</td>
                        <td class="px-4 py-3">{{ $detail->numero_enfant }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-vert-foret">Aucun détail disponible.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.choix.historique') }}" class="text-vert-foret hover:underline">← Retour à l'historique</a>
    </div>
</div>
@endsection
