@extends('layouts.app')

@section('title', 'Faire un dépôt')

@section('content')
<style>
    .content-bg {
        background-image: url('{{ asset('images/fond-form-depot.png') }}');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: right center;
    }
    
    @media (max-width: 768px) {
        .content-bg {
            background-position: center center;
        }
    }
</style>

<div class="content-bg min-h-[calc(100vh-12rem)] flex items-center justify-center md:justify-start p-4 md:p-6 md:pl-24 lg:pl-60">
    <div class="w-full max-w-md mx-auto md:mx-0 md:mr-8">
        <div class="bg-white/95 backdrop-blur-sm rounded-xl md:rounded-2xl shadow-2xl p-6 md:p-8 lg:p-10">
            <div class="text-left mb-6">
                <i class="fas fa-coins text-rose-corail text-4xl mb-2"></i>
                <h1 class="text-3xl font-christmas font-bold text-anthracite mb-1">Faire un dépôt</h1>
                <p class="text-vert-foret font-sans">Ajoutez des fonds à votre solde pour générer des cadeaux.</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3 mt-1"></i>
                        <ul class="list-disc list-inside text-red-700 font-sans">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <p class="text-green-700 font-sans">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('depot.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="montant" class="block text-vert-foret font-medium mb-2 font-sans">Montant du dépôt (Ar)</label>
                    <input
                        type="number"
                        name="montant"
                        id="montant"
                        step="0.01"
                        min="0.01"
                        required
                        value="{{ old('montant') }}"
                        class="w-full px-4 py-3 rounded-lg border-2 border-vert-clair focus:border-rose-corail focus:outline-none transition-colors font-sans text-lg"
                        placeholder="Ex: 10000"
                    >
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-rose-corail hover:bg-[#e07b7d] text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow font-sans text-lg">
                        <i class="fas fa-paper-plane mr-2"></i>Effectuer le dépôt
                    </button>
                </div>
            </form>

            <div class="mt-6 text-left">
                <a href="{{ route('utilisateur.accueil') }}" class="text-vert-foret hover:underline font-sans">← Retour à l'accueil</a>
            </div>
        </div>
    </div>
</div>
@endsection