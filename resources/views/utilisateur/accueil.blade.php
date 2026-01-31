@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<style>
    .content-bg {
        background-image: url('{{ asset('images/accueil.png') }}');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        min-height: calc(100vh - 12rem);
    }
    
    @media (max-width: 768px) {
        .content-bg {
            background-position: right center;
        }
    }
</style>

<div class="content-bg flex items-center justify-center relative p-4 md:p-8">
    <!-- Contenu principal -->
    <div class="w-full max-w-4xl mx-auto lg:ml-auto lg:mr-24">
        @if (session('success'))
            <div class="bg-vert-clair border-l-4 border-rose-corail p-3 md:p-4 rounded mb-4 md:mb-8 shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-rose-corail mr-3 text-lg md:text-xl"></i>
                    <p class="text-vert-foret font-sans font-medium text-sm md:text-base">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Message de bienvenue principal -->
        <div class="text-center lg:text-right mb-6 md:mb-12">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-christmas font-bold text-anthracite mb-2 md:mb-4 drop-shadow-lg">
                Bonjour {{ $utilisateur->nom }} !
            </h1>
            <p class="text-lg sm:text-xl md:text-2xl lg:text-3xl text-vert-foret font-sans font-light">
                Bienvenue dans votre espace MagiCadeaux
            </p>
        </div>

        <!-- Carte solde -->
        <div class="bg-vert-clair rounded-xl md:rounded-2xl shadow-xl p-4 md:p-8 mb-6 md:mb-12 border-2 border-white/50">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center justify-center md:justify-start">
                    <i class="fas fa-wallet text-rose-corail text-2xl md:text-4xl mr-3 md:mr-4"></i>
                    <div>
                        <p class="text-vert-foret font-sans text-xs md:text-sm uppercase tracking-wide">Votre solde</p>
                        <p class="text-anthracite font-sans font-bold text-xl md:text-3xl">{{ number_format($utilisateur->solde, 2, ',', ' ') }} Ar</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 md:gap-3">
                    <a href="{{ route('utilisateur.historique-depots') }}" class="w-full sm:w-auto">
                        <button class="w-full bg-anthracite hover:bg-rose-corail text-white font-semibold py-2 md:py-3 px-4 md:px-6 rounded-lg md:rounded-xl transition-all duration-300 font-sans text-sm md:text-base">
                            <i class="fas fa-list mr-2"></i>Mes dépôts
                        </button>
                    </a>
                    <a href="{{ route('utilisateur.historique-choix') }}" class="w-full sm:w-auto">
                        <button class="w-full bg-vert-foret hover:bg-anthracite text-white font-semibold py-2 md:py-3 px-4 md:px-6 rounded-lg md:rounded-xl transition-all duration-300 font-sans text-sm md:text-base">
                            <i class="fas fa-gifts mr-2"></i>Choix validés
                        </button>
                    </a>
                    <a href="{{ route('depot.show') }}" class="w-full sm:w-auto">
                        <button class="w-full bg-rose-corail hover:bg-anthracite text-white font-semibold py-2 md:py-3 px-4 md:px-8 rounded-lg md:rounded-xl transition-all duration-300 font-sans text-sm md:text-base">
                            <i class="fas fa-plus mr-2"></i>Ajouter
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bouton principal d'action -->
        <a href="{{ route('utilisateur.form-entrer-nbr-enfants') }}">
            <button class="w-full bg-rose-corail hover:bg-anthracite text-white font-bold py-4 md:py-6 px-6 md:px-8 rounded-xl md:rounded-2xl transition-all duration-300 transform hover:scale-105 shadow-2xl font-sans text-lg md:text-2xl">
                <i class="fas fa-wand-magic-sparkles mr-2 md:mr-3"></i>Obtenir des cadeaux
            </button>
        </a>

        <!-- Message subtil -->
        <p class="text-vert-foret font-sans text-center lg:text-right mt-4 md:mt-8 text-sm md:text-lg italic opacity-75">
            La magie de Noël commence ici...
        </p>
    </div>
</div>
@endsection