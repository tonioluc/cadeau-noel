@extends('layouts.app')

@section('title', 'Nouveau Paramètre')

@section('sidebar')
    @include('partials.side-bar-admin')
@endsection

@section('content')
<div class="p-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.parametres.index') }}" class="text-vert-foret hover:underline mb-4 inline-block">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
            <h1 class="text-4xl font-christmas text-anthracite">
                <i class="fas fa-plus text-rose-corail mr-3"></i>Nouveau Paramètre
            </h1>
            <p class="text-vert-foret mt-2">Créer un nouveau paramètre système</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded mb-6">
                <ul class="list-disc list-inside text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-xl shadow p-8">
            <form action="{{ route('admin.parametres.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="code" class="block text-vert-foret font-medium mb-2 font-sans">
                        <i class="fas fa-code text-rose-corail mr-2"></i>Code
                    </label>
                    <input 
                        type="text" 
                        name="code" 
                        id="code" 
                        value="{{ old('code') }}"
                        class="w-full px-4 py-3 rounded-lg border-2 border-vert-clair focus:border-rose-corail focus:outline-none transition-colors font-sans"
                        placeholder="Ex: COMMISSION"
                        required
                    >
                    <p class="text-sm text-vert-foret/60 mt-1">Code unique en majuscules (ex: COMMISSION, TVA, etc.)</p>
                </div>

                <div>
                    <label for="libelle" class="block text-vert-foret font-medium mb-2 font-sans">
                        <i class="fas fa-tag text-rose-corail mr-2"></i>Libellé
                    </label>
                    <input 
                        type="text" 
                        name="libelle" 
                        id="libelle" 
                        value="{{ old('libelle') }}"
                        class="w-full px-4 py-3 rounded-lg border-2 border-vert-clair focus:border-rose-corail focus:outline-none transition-colors font-sans"
                        placeholder="Ex: Taux de commission"
                        required
                    >
                </div>

                <div>
                    <label for="valeur" class="block text-vert-foret font-medium mb-2 font-sans">
                        <i class="fas fa-hashtag text-rose-corail mr-2"></i>Valeur
                    </label>
                    <input 
                        type="number" 
                        name="valeur" 
                        id="valeur" 
                        step="any"
                        value="{{ old('valeur') }}"
                        class="w-full px-4 py-3 rounded-lg border-2 border-vert-clair focus:border-rose-corail focus:outline-none transition-colors font-sans"
                        placeholder="Ex: 10"
                        required
                    >
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-rose-corail hover:bg-rose-corail/80 text-white font-semibold py-4 px-6 rounded-lg transition-colors font-sans text-lg">
                        <i class="fas fa-save mr-2"></i>Créer le paramètre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
