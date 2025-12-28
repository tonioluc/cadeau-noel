@extends('layouts.app')

@section('title', 'Validation des dépôts')

@section('sidebar')
@include('partials.side-bar-admin')
@endsection

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-anthracite font-mountains">
                    <i class="fa-solid fa-wallet text-rose-corail mr-3"></i>
                    Validation des dépôts
                </h1>
                <p class="text-gray-600 mt-1">Liste des dépôts en attente de validation</p>
            </div>
        </div>
        <!-- Liste des dépôts (tableau) -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-vert-clair/30">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-anthracite to-vert-foret text-white">
                            <th class="px-6 py-4 text-left font-semibold">ID dépôt</th>
                            <th class="px-6 py-4 text-left font-semibold">Utilisateur</th>
                            <th class="px-6 py-4 text-left font-semibold">Montant demandé</th>
                            <th class="px-6 py-4 text-left font-semibold">Commission</th>
                            <th class="px-6 py-4 text-left font-semibold">Montant crédité</th>
                            <th class="px-6 py-4 text-center font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($depots as $depot)
                            <tr class="hover:bg-vert-clair/20 transition-colors">
                                <td class="px-6 py-4 text-anthracite font-medium">#{{ $depot->id_depot }}</td>
                                <td class="px-6 py-4 text-anthracite font-medium">{{ optional($depot->utilisateur)->nom ?? '—' }}</span></td>
                                <td class="px-6 py-4"><span class="text-sauge font-bold">{{ number_format($depot->montant_demande, 0, ',', ' ') }} Ar</span></td>
                                <td class="px-6 py-4">{{ $depot->commission_applique }} %</td>
                                <td class="px-6 py-4 text-vert-foret font-medium">{{ number_format($depot->montant_credit, 0, ',', ' ') }} Ar</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <form method="POST" action="{{ route('depot.valider') }}" onsubmit="return confirmValidate(this);">
                                            @csrf
                                            <input type="hidden" name="id_depot" value="{{ $depot->id_depot }}">
                                            <button type="submit" class="p-2 bg-vert-foret text-white rounded-lg hover:bg-vert-foret/90" title="Valider">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('depot.rejeter') }}">
                                            @csrf
                                            <input type="hidden" name="id_depot" value="{{ $depot->id_depot }}">
                                            <button type="submit" class="p-2 bg-rose-corail text-white rounded-lg hover:bg-rose-corail/90" title="Refuser">
                                                <i class="fa-solid fa-times"></i>
                                            </button>
                                        </form>

                                        <a href="{{ route('admin.parametres.index') }}" class="p-2 border rounded-lg text-gray-600" title="Détails">Détails</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fa-solid fa-inbox text-4xl text-gray-300 mb-4"></i>
                                        <p class="text-gray-500 text-lg">Aucun dépôt en attente.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection