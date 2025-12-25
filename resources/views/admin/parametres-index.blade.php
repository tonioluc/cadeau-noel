@extends('layouts.app')

@section('title', 'Gestion des Paramètres')

@section('sidebar')
    @include('partials.side-bar-admin')
@endsection

@section('content')
<div class="p-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-christmas text-anthracite">
                    <i class="fas fa-sliders text-rose-corail mr-3"></i>Gestion des Paramètres
                </h1>
                <p class="text-vert-foret mt-2">Gérer les paramètres du système</p>
            </div>
            <a href="{{ route('admin.parametres.create') }}" class="bg-rose-corail hover:bg-rose-corail/80 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>Nouveau Paramètre
            </a>
        </div>

        @if (session('success'))
            <div class="bg-vert-clair border-l-4 border-vert-foret p-4 rounded mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-vert-foret mr-3"></i>
                    <p class="text-vert-foret font-sans">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded mb-6">
                <ul class="list-disc list-inside text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-vert-foret text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-sans font-medium">Code</th>
                        <th class="px-6 py-4 text-left font-sans font-medium">Libellé</th>
                        <th class="px-6 py-4 text-left font-sans font-medium">Valeur</th>
                        <th class="px-6 py-4 text-center font-sans font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-vert-clair">
                    @forelse ($parametres as $parametre)
                        <tr class="hover:bg-vert-clair/10 transition-colors">
                            <td class="px-6 py-4">
                                <span class="bg-vert-clair/30 text-vert-foret px-3 py-1 rounded font-mono text-sm">{{ $parametre->code }}</span>
                            </td>
                            <td class="px-6 py-4 text-anthracite font-sans">{{ $parametre->libelle }}</td>
                            <td class="px-6 py-4 text-anthracite font-sans font-semibold">{{ $parametre->valeur }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="{{ route('admin.parametres.edit', $parametre->code) }}" class="bg-vert-foret hover:bg-vert-foret/80 text-white px-3 py-2 rounded transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.parametres.destroy', $parametre->code) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce paramètre ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-vert-foret/60">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p>Aucun paramètre trouvé</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
