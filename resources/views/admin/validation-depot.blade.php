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
        <!-- Liste des dépôts -->
        <div class="grid gap-4">
            @if($depots->isEmpty())
            <div class="bg-white/90 rounded-2xl shadow p-8 border border-gray-200 text-center">
                <i class="fa-solid fa-inbox text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Aucun dépôt en attente.</p>
            </div>
            @else
            @foreach($depots as $depot)
            <div class="bg-white/90 rounded-2xl shadow p-6 border border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-start gap-4">
                    <div class="w-44">
                        <p class="text-sm text-gray-500">ID dépôt</p>
                        <p class="text-anthracite font-medium">#{{ $depot->id_depot }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Utilisateur</p>
                        <p class="text-anthracite font-medium">{{ optional($depot->utilisateur)->nom ?? '—' }}<span class="text-gray-400"> • {{ optional($depot->utilisateur)->email ?? '' }}</span></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Montant demandé</p>
                        <p class="text-sauge font-bold text-lg">{{ number_format($depot->montant_demande, 0, ',', ' ') }} Ar</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Commission</p>
                        <p class="text-anthracite">{{ $depot->commission_applique }} %</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Montant crédité</p>
                        <p class="text-vert-foret font-medium">{{ number_format($depot->montant_credit, 0, ',', ' ') }} Ar</p>
                    </div>
                </div>

                <div class="mt-4 md:mt-0 flex items-center gap-3">
                    <form method="POST" action="{{ route('depot.valider') }}" onsubmit="return confirmValidate(this);">
                        @csrf
                        <input type="hidden" name="id_depot" value="{{ $depot->id_depot }}">
                        <button type="submit" class="px-4 py-2 bg-vert-foret text-white rounded-lg hover:bg-vert-foret/90 flex items-center">
                            <i class="fa-solid fa-check mr-2"></i> Valider
                        </button>
                    </form>

                    <form method="POST" action="{{ route('depot.rejeter') }}" style="display:inline; margin-left:0.5rem;">
                        @csrf
                        <input type="hidden" name="id_depot" value="{{ $depot->id_depot }}">
                        <button type="submit" class="px-4 py-2 bg-rose-corail text-white rounded-lg hover:bg-rose-corail/90 flex items-center">
                            <i class="fa-solid fa-times mr-2"></i> Refuser
                        </button>
                    </form>

                    <a href="{{ route('admin.parametres.index') }}" class="px-3 py-2 border rounded-lg text-gray-600">Détails</a>
                </div>
            </div>
            @endforeach

            @endif
        </div>
    </div>
</div>
@endsection