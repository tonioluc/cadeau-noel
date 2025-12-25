@extends('layouts.app')

@section('title', 'Modifier Paramètre - ' . $parametre->code)

@section('sidebar')
    @include('partials.side-bar-admin')
@endsection

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-2xl mx-auto px-4">
        <!-- En-tête -->
        <div class="mb-8">
            <a href="{{ route('admin.parametres.index') }}" class="inline-flex items-center text-sauge hover:text-vert-foret transition-colors mb-4">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Retour à la liste
            </a>
            <h1 class="text-3xl font-bold text-anthracite font-mountains">
                <i class="fa-solid fa-pen-to-square text-rose-corail mr-3"></i>
                Modifier le Paramètre
            </h1>
            <p class="text-gray-600 mt-2">Code : <strong class="text-anthracite">{{ $parametre->code }}</strong></p>
        </div>

        <!-- Messages flash -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fa-solid fa-check-circle mr-3"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fa-solid fa-info-circle mr-3"></i>
                {{ session('info') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center mb-2">
                    <i class="fa-solid fa-exclamation-triangle mr-3"></i>
                    <strong>Erreurs de validation</strong>
                </div>
                <ul class="list-disc list-inside ml-6">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-vert-clair/30">
            <form method="POST" action="{{ route('admin.parametres.update', $parametre->code) }}">
                @csrf
                @method('PUT')

                <!-- Code (lecture seule) -->
                <div class="mb-6">
                    <label class="block text-anthracite font-semibold mb-2">
                        <i class="fa-solid fa-code mr-2 text-sauge"></i>
                        Code
                    </label>
                    <input type="text" 
                           value="{{ $parametre->code }}" 
                           disabled
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed">
                    <p class="text-sm text-gray-500 mt-1">Le code ne peut pas être modifié</p>
                </div>

                <!-- Libellé (lecture seule) -->
                <div class="mb-6">
                    <label class="block text-anthracite font-semibold mb-2">
                        <i class="fa-solid fa-tag mr-2 text-sauge"></i>
                        Libellé
                    </label>
                    <input type="text" 
                           value="{{ $parametre->libelle }}" 
                           disabled
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed">
                </div>

                <!-- Valeur actuelle -->
                <div class="mb-6">
                    <label class="block text-anthracite font-semibold mb-2">
                        <i class="fa-solid fa-history mr-2 text-gray-400"></i>
                        Valeur actuelle
                    </label>
                    <input type="text" 
                           value="{{ $parametre->valeur }}" 
                           disabled
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed">
                </div>

                <!-- Nouvelle valeur -->
                <div class="mb-8">
                    <label for="valeur" class="block text-anthracite font-semibold mb-2">
                        <i class="fa-solid fa-pen mr-2 text-rose-corail"></i>
                        Nouvelle valeur <span class="text-rose-corail">*</span>
                    </label>
                    <input type="text" 
                           id="valeur"
                           name="valeur" 
                           value="{{ old('valeur', $parametre->valeur) }}"
                           required
                           class="w-full px-4 py-3 rounded-xl border-2 border-vert-clair focus:border-sauge focus:ring-2 focus:ring-sauge/20 transition-all outline-none @error('valeur') border-red-400 @enderror"
                           placeholder="Entrez la nouvelle valeur">
                    @error('valeur')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.parametres.index') }}" 
                       class="px-6 py-3 rounded-xl border-2 border-gray-300 text-gray-600 hover:bg-gray-100 transition-all flex items-center">
                        <i class="fa-solid fa-times mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-sauge to-vert-foret text-white rounded-xl hover:shadow-lg transform hover:scale-105 transition-all flex items-center">
                        <i class="fa-solid fa-save mr-2"></i>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>

        <!-- Info historique -->
        <div class="mt-6 bg-blue-50 rounded-xl p-4 border border-blue-200">
            <div class="flex items-start">
                <i class="fa-solid fa-info-circle text-blue-500 mt-1 mr-3"></i>
                <div>
                    <p class="text-blue-800 font-medium">Historique des modifications</p>
                    <p class="text-blue-600 text-sm mt-1">
                        Chaque modification de valeur est automatiquement enregistrée dans l'historique des paramètres avec la date et l'heure du changement.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
