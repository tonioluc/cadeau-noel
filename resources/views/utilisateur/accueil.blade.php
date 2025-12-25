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
    
    .curved-text {
        position: absolute;
        top: 30px;
        left: 100px;
        width: 400px;
        height: 150px;
    }
    
    .curved-text span {
        position: absolute;
        font-size: 20px;
        font-weight: 700;
        color: #2D2D2D;
        text-shadow: 1px 1px 3px rgba(255,255,255,0.8);
        transform-origin: center 180px;
    }
</style>

<div class="content-bg flex items-center justify-center relative">
    <!-- Contenu principal -->
    <div class="w-full max-w-4xl ml-auto mr-24">
        @if (session('success'))
            <div class="bg-vert-clair border-l-4 border-rose-corail p-4 rounded mb-8 shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-rose-corail mr-3 text-xl"></i>
                    <p class="text-vert-foret font-sans font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Message de bienvenue principal -->
        <div class="text-right mb-12">
            <h1 class="text-7xl font-christmas font-bold text-anthracite mb-4 drop-shadow-lg">
                Bonjour {{ $utilisateur->nom }} !
            </h1>
            <p class="text-3xl text-vert-foret font-sans font-light">
                Bienvenue dans votre espace MagiCadeaux
            </p>
        </div>

        <!-- Carte solde -->
        <div class="bg-vert-clair rounded-2xl shadow-xl p-8 mb-12 border-2 border-white/50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-wallet text-rose-corail text-4xl mr-4"></i>
                    <div>
                        <p class="text-vert-foret font-sans text-sm uppercase tracking-wide">Votre solde</p>
                        <p class="text-anthracite font-sans font-bold text-3xl">{{ number_format($utilisateur->solde, 2, ',', ' ') }} Ar</p>
                    </div>
                </div>
                <a href="{{ route('depot.show') }}">
                    <button class="bg-rose-corail hover:bg-anthracite text-white font-semibold py-3 px-8 rounded-xl transition-all duration-300 font-sans">
                        <i class="fas fa-plus mr-2"></i>Ajouter
                    </button>
                </a>
            </div>
        </div>

        <!-- Bouton principal d'action -->
        <a href="{{ route('utilisateur.form-entrer-nbr-enfants') }}">
            <button class="w-full bg-rose-corail hover:bg-anthracite text-white font-bold py-6 px-8 rounded-2xl transition-all duration-300 transform hover:scale-105 shadow-2xl font-sans text-2xl">
                <i class="fas fa-wand-magic-sparkles mr-3"></i>Obtenir des cadeaux
            </button>
        </a>

        <!-- Message subtil -->
        <p class="text-vert-foret font-sans text-right mt-8 text-lg italic opacity-75">
            La magie de Noël commence ici...
        </p>
    </div>
</div>
@endsection