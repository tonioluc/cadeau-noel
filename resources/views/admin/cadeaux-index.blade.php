@extends('layouts.app')

@section('title', 'Gestion des Cadeaux')

@section('sidebar')
    @include('partials.side-bar-admin')
@endsection

@section('content')
<div class="min-h-screen py-4 md:py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- En-tête -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 md:mb-8">
            <div class="mb-4 md:mb-0">
                <h1 class="text-2xl md:text-3xl font-bold text-anthracite font-mountains">
                    <i class="fa-solid fa-gifts text-rose-corail mr-2 md:mr-3"></i>
                    Gestion des Cadeaux
                </h1>
                <p class="text-gray-600 mt-1 md:mt-2 text-sm md:text-base">{{ $cadeaux->total() }} cadeau(x) au total</p>
            </div>
            <a href="{{ route('admin.cadeaux.create') }}" 
               class="inline-flex items-center justify-center px-4 md:px-6 py-2 md:py-3 bg-gradient-to-r from-vert-foret to-vert-foret text-white rounded-xl hover:shadow-lg transform hover:scale-105 transition-all text-sm md:text-base">
                <i class="fa-solid fa-plus mr-2"></i>
                Ajouter un cadeau
            </a>
        </div>

        <!-- Message de succès -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fa-solid fa-check-circle mr-3"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Filtres -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg p-6 mb-6 border border-vert-clair/30">
            <form method="GET" action="{{ route('admin.cadeaux.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Recherche par nom -->
                <div>
                    <label class="block text-sm font-medium text-anthracite mb-2">
                        <i class="fa-solid fa-search mr-1 text-sauge"></i>
                        Rechercher par nom
                    </label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Nom du cadeau..."
                           class="w-full px-4 py-2 rounded-xl border-2 border-vert-clair focus:border-sauge focus:ring-2 focus:ring-sauge/20 transition-all outline-none">
                </div>

                <!-- Filtre par catégorie -->
                <div>
                    <label class="block text-sm font-medium text-anthracite mb-2">
                        <i class="fa-solid fa-tag mr-1 text-sauge"></i>
                        Catégorie
                    </label>
                    <select name="categorie" 
                            class="w-full px-4 py-2 rounded-xl border-2 border-vert-clair focus:border-sauge focus:ring-2 focus:ring-sauge/20 transition-all outline-none">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id_categorie_cadeau }}" {{ request('categorie') == $cat->id_categorie_cadeau ? 'selected' : '' }}>
                                {{ $cat->libelle }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tri par prix -->
                <div>
                    <label class="block text-sm font-medium text-anthracite mb-2">
                        <i class="fa-solid fa-sort mr-1 text-sauge"></i>
                        Trier par prix
                    </label>
                    <select name="tri_prix" 
                            class="w-full px-4 py-2 rounded-xl border-2 border-vert-clair focus:border-sauge focus:ring-2 focus:ring-sauge/20 transition-all outline-none">
                        <option value="">Par défaut</option>
                        <option value="asc" {{ request('tri_prix') == 'asc' ? 'selected' : '' }}>
                            <i class="fa-solid fa-arrow-up"></i> Prix croissant
                        </option>
                        <option value="desc" {{ request('tri_prix') == 'desc' ? 'selected' : '' }}>
                            <i class="fa-solid fa-arrow-down"></i> Prix décroissant
                        </option>
                    </select>
                </div>

                <!-- Boutons -->
                <div class="flex items-end gap-2">
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-sauge text-white rounded-xl hover:bg-vert-foret transition-all flex items-center justify-center">
                        <i class="fa-solid fa-filter mr-2"></i>
                        Filtrer
                    </button>
                    <a href="{{ route('admin.cadeaux.index') }}" 
                       class="px-4 py-2 border-2 border-gray-300 text-gray-600 rounded-xl hover:bg-gray-100 transition-all flex items-center justify-center">
                        <i class="fa-solid fa-times"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Tableau des cadeaux -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-vert-clair/30">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-anthracite to-vert-foret text-white">
                            <th class="px-6 py-4 text-left font-semibold">
                                <i class="fa-solid fa-hashtag mr-2"></i>ID
                            </th>
                            <th class="px-6 py-4 text-left font-semibold">
                                <i class="fa-solid fa-image mr-2"></i>Image
                            </th>
                            <th class="px-6 py-4 text-left font-semibold">
                                <i class="fa-solid fa-gift mr-2"></i>Nom
                            </th>
                            <th class="px-6 py-4 text-left font-semibold">
                                <i class="fa-solid fa-tag mr-2"></i>Catégorie
                            </th>
                            <th class="px-6 py-4 text-left font-semibold">
                                <i class="fa-solid fa-coins mr-2"></i>Prix
                            </th>
                            <th class="px-6 py-4 text-center font-semibold">
                                <i class="fa-solid fa-cogs mr-2"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($cadeaux as $c)
                            <tr class="hover:bg-vert-clair/20 transition-colors">
                                <td class="px-6 py-4 text-anthracite font-medium">
                                    #{{ $c->id_cadeau }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($c->chemin_image)
                                        <img src="{{ asset($c->chemin_image) }}" 
                                             alt="{{ $c->nom }}" 
                                             class="h-12 w-12 object-cover rounded-lg shadow-md">
                                    @else
                                        <div class="h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fa-solid fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-anthracite font-medium">
                                    {{ $c->nom }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $catLabel = optional($c->categorie)->libelle;
                                        $catColor = match($catLabel) {
                                            'Fille' => 'bg-pink-100 text-pink-700',
                                            'Garçon' => 'bg-blue-100 text-blue-700',
                                            'Neutre' => 'bg-purple-100 text-purple-700',
                                            default => 'bg-gray-100 text-gray-700',
                                        };
                                        $catIcon = match($catLabel) {
                                            'Fille' => 'fa-solid fa-venus',
                                            'Garçon' => 'fa-solid fa-mars',
                                            'Neutre' => 'fa-solid fa-genderless',
                                            default => 'fa-solid fa-tag',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $catColor }}">
                                        <i class="{{ $catIcon }} mr-1"></i>
                                        {{ $catLabel ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sauge font-bold text-lg">
                                        {{ number_format($c->prix, 0, ',', ' ') }} Ar
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.cadeaux.edit', $c->id_cadeau) }}" 
                                           class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors"
                                           title="Modifier">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.cadeaux.destroy', $c->id_cadeau) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cadeau ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors"
                                                    title="Supprimer">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fa-solid fa-box-open text-6xl text-gray-300 mb-4"></i>
                                        <p class="text-gray-500 text-lg">Aucun cadeau trouvé</p>
                                        <p class="text-gray-400 text-sm mt-1">Ajoutez votre premier cadeau ou modifiez vos filtres</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($cadeaux->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $cadeaux->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection