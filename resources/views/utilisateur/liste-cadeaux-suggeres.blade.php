@extends('layouts.app')

@section('title', 'Cadeaux suggérés')

@section('content')
@php
    $solde = $utilisateur->solde;
    $resteSolde = $solde - $total;
@endphp

<style>
    .content-bg {
        /* background-image: url('{{ asset('images/simple-fond.png') }}'); */
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        min-height: calc(100vh - 12rem);
    }

    .gifts-container {
        display: flex;
        gap: 2rem;
        align-items: flex-start;
        justify-content: space-between;
    }

    .gifts-column {
        width: 100%;
    }

    @media (min-width: 768px) {
        .gifts-column { width: 48%; }
    }

    .gift-card {
        background: rgba(255,255,255,0.9);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        transition: transform 0.25s ease; 
    }

    .gift-card:hover { transform: translateY(-6px); }

    .gift-fille { border: 2px solid #F08C8E; }
    .gift-garcon { border: 2px solid #7FB3D5; }

    .gift-title { font-weight: 700; color: #2D2D2D; }
    .gift-category { color: #35452E; }
    .gift-price { font-weight: 700; color: #2D2D2D; }

    .gift-thumb { width: 96px; height: 96px; object-fit: cover; border-radius: 8px; }

    /* floating animation placeholder (JS will animate transform) */
    .float-card { will-change: transform; }

    .summary-box {
        background: rgba(255,255,255,0.9);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1rem;
    }
</style>

<div class="content-bg p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-4xl font-christmas text-anthracite">Cadeaux suggérés</h1>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-vert-clair/20 border-l-4 border-rose-corail p-3 rounded mb-4 text-vert-foret">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded mb-4 text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('utilisateur.echanger-cadeaux') }}">
            @csrf

            <div class="gifts-container flex-col md:flex-row">
                <!-- Filles colonne -->
                <div class="gifts-column">
                    <h2 class="text-xl font-semibold text-anthracite mb-4"><i class="fas fa-female text-rose-corail mr-2"></i>Filles ({{ $nbrFilles }})</h2>
                    @forelse ($suggestionsFilles as $index => $cadeau)
                        @php $img = $cadeau->image ? asset('images/'.$cadeau->image) : asset('images/gift-image.png'); @endphp
                        <div class="gift-card gift-fille float-card" data-index="f-{{ $index }}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-4">
                                    <img src="{{ $img }}" alt="{{ $cadeau->nom }}" class="gift-thumb">
                                    <div>
                                        <p class="gift-title"><i class="fas fa-gift text-rose-corail mr-2"></i>{{ $cadeau->nom }}</p>
                                        <p class="gift-category text-sm"><i class="fas fa-tag text-vert-foret mr-1"></i>{{ $cadeau->categorie->libelle }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="gift-price"><i class="fas fa-coins text-yellow-400 mr-1"></i>{{ number_format($cadeau->prix, 2, ',', ' ') }} Ar</p>
                                </div>
                            </div>
                            <div class="mt-3 flex items-center justify-between">
                                <label class="flex items-center text-vert-foret">
                                    <input type="checkbox" name="echanger_filles[]" value="{{ $index }}" class="mr-2">
                                    <i class="fas fa-exchange-alt mr-2 text-vert-foret"></i>Échanger
                                </label>
                                <small class="text-sm text-vert-foret">Enfant {{ $index + 1 }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-vert-foret/70">Aucune suggestion pour les filles.</p>
                    @endforelse
                </div>

                <!-- Garçons colonne -->
                <div class="gifts-column">
                    <h2 class="text-xl font-semibold text-anthracite mb-4"><i class="fas fa-male" style="color:#7FB3D5; margin-right:0.5rem"></i>Garçons ({{ $nbrGarcons }})</h2>
                    @forelse ($suggestionsGarcons as $index => $cadeau)
                        @php $img = $cadeau->image ? asset('images/'.$cadeau->image) : asset('images/gift-image.png'); @endphp
                        <div class="gift-card gift-garcon float-card" data-index="g-{{ $index }}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-4">
                                    <img src="{{ $img }}" alt="{{ $cadeau->nom }}" class="gift-thumb">
                                    <div>
                                        <p class="gift-title"><i class="fas fa-gift text-[#7FB3D5] mr-2"></i>{{ $cadeau->nom }}</p>
                                        <p class="gift-category text-sm"><i class="fas fa-tag text-vert-foret mr-1"></i>{{ $cadeau->categorie->libelle }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="gift-price"><i class="fas fa-coins text-yellow-400 mr-1"></i>{{ number_format($cadeau->prix, 2, ',', ' ') }} Ar</p>
                                </div>
                            </div>
                            <div class="mt-3 flex items-center justify-between">
                                <label class="flex items-center text-vert-foret">
                                    <input type="checkbox" name="echanger_garcons[]" value="{{ $index }}" class="mr-2">
                                    <i class="fas fa-exchange-alt mr-2 text-vert-foret"></i>Échanger
                                </label>
                                <small class="text-sm text-vert-foret">Enfant {{ $index + 1 }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-vert-foret/70">Aucune suggestion pour les garçons.</p>
                    @endforelse
                </div>
            </div>

            <!-- Résumé et actions -->
            <div class="summary-box">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-semibold text-vert-foret">Total <i class="fas fa-coins text-yellow-400 mr-2"></i></p>
                        <p class="text-2xl font-bold text-anthracite">{{ number_format($total, 2, ',', ' ') }} Ar</p>
                    </div>
                    <div class="text-right">
                        @if ($resteSolde < 0)
                            <p class="text-red-600 font-semibold"><i class="fas fa-exclamation-triangle mr-2"></i>Solde insuffisant : {{ number_format($resteSolde, 2, ',', ' ') }} Ar</p>
                            <a href="{{ route('depot.show') }}" class="text-rose-corail font-semibold"><i class="fas fa-piggy-bank mr-2"></i>Faire un dépôt</a>
                        @else
                            <p class="text-vert-foret"><i class="fas fa-check-circle text-vert-foret mr-2"></i>Reste du solde après validation : <strong>{{ number_format($resteSolde, 2, ',', ' ') }} Ar</strong></p>
                            <div class="mt-3 space-x-3">
                                <button type="submit" name="action" value="echanger" class="bg-vert-foret text-white font-semibold py-2 px-4 rounded">
                                    <i class="fas fa-exchange-alt mr-2"></i>Échanger les sélectionnés
                                </button>
                                <button type="submit" name="action" value="valider" formaction="{{ route('utilisateur.valider-cadeaux') }}" class="bg-rose-corail text-white font-semibold py-2 px-4 rounded">
                                    <i class="fas fa-check mr-2"></i>Valider ce choix
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        <div class="mt-6 text-right">
            <a href="{{ route('utilisateur.form-entrer-nbr-enfants') }}" class="text-vert-foret hover:underline">← Retour au formulaire</a>
        </div>
    </div>
</div>
@endsection
