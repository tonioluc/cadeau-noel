@extends('layouts.app')

@section('title', 'Obtenir des cadeaux')

@section('content')
<style>
    .content-bg {
        background-image: url('{{ asset('images/fond-formulaire.png') }}');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: left center;
    }
</style>

<div class="content-bg min-h-[calc(100vh-12rem)] flex items-center justify-end p-6 pr-60 pb-0 mb-0">
    <div class="w-full max-w-xl">
        <!-- Formulaire -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8 md:p-12">
            <div class="text-center mb-8">
                <i class="fas fa-gift text-rose-corail text-5xl mb-4"></i>
                <h1 class="text-4xl font-christmas font-bold text-anthracite mb-2">
                    Générateur de Cadeaux
                </h1>
                <p class="text-vert-foret font-sans">
                    Remplissez le formulaire pour obtenir vos suggestions
                </p>
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

            <form method="POST" action="{{ route('utilisateur.suggerer-cadeaux') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="filles" class="block text-vert-foret font-medium mb-2 font-sans">
                        <i class="fas fa-child-dress text-rose-corail mr-2"></i>Nombre de filles
                    </label>
                    <input 
                        type="number" 
                        name="filles" 
                        id="filles" 
                        min="0" 
                        value="{{ old('filles', 0) }}"
                        class="w-full px-4 py-3 rounded-lg border-2 border-vert-clair focus:border-rose-corail focus:outline-none transition-colors font-sans text-lg"
                        placeholder="0"
                    >
                </div>

                <div>
                    <label for="garcons" class="block text-vert-foret font-medium mb-2 font-sans">
                        <i class="fas fa-child text-rose-corail mr-2"></i>Nombre de garçons
                    </label>
                    <input 
                        type="number" 
                        name="garcons" 
                        id="garcons" 
                        min="0" 
                        value="{{ old('garcons', 0) }}"
                        class="w-full px-4 py-3 rounded-lg border-2 border-vert-clair focus:border-rose-corail focus:outline-none transition-colors font-sans text-lg"
                        placeholder="0"
                    >
                </div>

                <div class="pt-4">
                    <button 
                        type="submit"
                        class="w-full bg-rose-corail hover:bg-[#e07b7d] text-white font-semibold py-4 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg font-sans text-lg"
                    >
                        <i class="fas fa-wand-magic-sparkles mr-2"></i>Générer les cadeaux
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <p class="text-vert-foret/60 font-sans text-sm">
                    <i class="fas fa-info-circle mr-1"></i>
                    Les cadeaux seront générés aléatoirement selon vos critères
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
