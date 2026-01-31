@extends('layouts.app')

@section('title', 'Détail du choix validé')

@section('content')
<div class="max-w-5xl mx-auto py-4 md:py-8 px-4">
    <h1 class="text-2xl md:text-3xl font-bold text-anthracite mb-4 md:mb-6">Détail du choix #{{ $choix->id_choix }}</h1>

    <div class="bg-vert-clair rounded-xl p-4 md:p-6 shadow mb-4 md:mb-6 grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6">
        <div class="text-center sm:text-left">
            <p class="text-vert-foret text-xs md:text-sm uppercase">Date</p>
            <p class="text-anthracite text-base md:text-lg">{{ optional($choix->date_choix)->format('d/m/Y H:i') ?? '—' }}</p>
        </div>
        <div class="text-center sm:text-left">
            <p class="text-vert-foret text-xs md:text-sm uppercase">Montant total</p>
            <p class="text-anthracite text-base md:text-lg font-bold">{{ number_format($choix->montant_total, 2, ',', ' ') }} Ar</p>
        </div>
        <div class="text-center sm:text-left">
            <p class="text-vert-foret text-xs md:text-sm uppercase">Nombre de cadeaux</p>
            <p class="text-anthracite text-base md:text-lg">{{ $choix->details->count() }}</p>
        </div>
    </div>

    <!-- Mobile view: cards -->
    <div class="md:hidden space-y-3">
        @forelse($choix->details as $detail)
            @php
                $img = ($detail->cadeau && $detail->cadeau->chemin_image)
                    ? asset($detail->cadeau->chemin_image)
                    : asset('images/gift-image.png');
            @endphp
            <div class="bg-white rounded-xl shadow p-4">
                <div class="flex gap-3">
                    <img src="{{ $img }}" alt="{{ $detail->cadeau->nom ?? 'Cadeau' }}" class="h-16 w-16 object-cover rounded" />
                    <div class="flex-1">
                        <p class="font-bold text-anthracite">{{ $detail->cadeau->nom ?? '—' }}</p>
                        <p class="text-sm text-gray-600">{{ optional($detail->cadeau->categorie)->libelle ?? '—' }}</p>
                        <p class="text-sm font-semibold text-vert-foret mt-1">{{ isset($detail->cadeau->prix) ? number_format($detail->cadeau->prix, 2, ',', ' ') . ' Ar' : '—' }}</p>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t flex justify-between text-sm">
                    <span class="text-gray-600">{{ $detail->type_enfant }} - Enfant n°{{ $detail->numero_enfant }}</span>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow p-6 text-center text-vert-foret">
                Aucun détail disponible.
            </div>
        @endforelse
    </div>

    <!-- Desktop view: table -->
    <div class="hidden md:block bg-white rounded-xl shadow overflow-x-auto">
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

    <div class="mt-4 md:mt-6">
        <a href="{{ route('utilisateur.historique-choix') }}" class="text-vert-foret hover:underline text-sm md:text-base">← Retour à l'historique</a>
    </div>
</div>
@endsection
