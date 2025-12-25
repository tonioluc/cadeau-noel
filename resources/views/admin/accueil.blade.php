@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('sidebar')
@include('partials.side-bar-admin')
@endsection


@section('solde','Total commission obtenue : '.number_format($totalCommissions, 2, ',', ' ').' Ar')

@section('content')
<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-christmas text-anthracite">
                <i class="fas fa-gauge-high text-rose-corail mr-3"></i>Dashboard
            </h1>
            <p class="text-vert-foret mt-2">Bienvenue dans l'espace d'administration MagiCadeaux</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Utilisateurs -->
            <div class="bg-vert-clair rounded-xl p-6 shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-vert-foret text-sm font-medium">Utilisateurs</p>
                        <p class="text-3xl font-bold text-anthracite">{{ $totalUtilisateurs }}</p>
                    </div>
                    <div class="bg-white/50 p-3 rounded-full">
                        <i class="fas fa-users text-2xl text-vert-foret"></i>
                    </div>
                </div>
            </div>

            <!-- Total Cadeaux -->
            <div class="bg-vert-clair rounded-xl p-6 shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-vert-foret text-sm font-medium">Cadeaux</p>
                        <p class="text-3xl font-bold text-anthracite">{{ $totalCadeaux }}</p>
                    </div>
                    <div class="bg-white/50 p-3 rounded-full">
                        <i class="fas fa-gift text-2xl text-rose-corail"></i>
                    </div>
                </div>
            </div>

            <!-- Dépôts en attente -->
            <div class="bg-vert-clair rounded-xl p-6 shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-vert-foret text-sm font-medium">Dépôts en attente</p>
                        <p class="text-3xl font-bold text-anthracite">{{ $depotsEnAttente }}</p>
                    </div>
                    <div class="bg-white/50 p-3 rounded-full">
                        <i class="fas fa-clock text-2xl text-yellow-600"></i>
                    </div>
                </div>
            </div>

            <!-- Total Commissions -->
            <div class="bg-vert-clair rounded-xl p-6 shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-vert-foret text-sm font-medium">Commissions</p>
                        <p class="text-2xl font-bold text-anthracite">{{ number_format($totalCommissions, 0, ',', ' ') }} Ar</p>
                    </div>
                    <div class="bg-white/50 p-3 rounded-full">
                        <i class="fas fa-coins text-2xl text-yellow-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Gestion Cadeaux -->
            <a href="{{ route('admin.cadeaux.index') }}" class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition-shadow border-l-4 border-rose-corail">
                <div class="flex items-center space-x-4">
                    <div class="bg-rose-corail/10 p-4 rounded-full">
                        <i class="fas fa-gift text-2xl text-rose-corail"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-anthracite">Gérer les cadeaux</h3>
                        <p class="text-vert-foret text-sm">Ajouter, modifier ou supprimer des cadeaux</p>
                    </div>
                </div>
            </a>

            <!-- Validation Dépôts -->
            <a href="{{ route('depot.en-attente.list') }}" class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition-shadow border-l-4 border-yellow-500">
                <div class="flex items-center space-x-4">
                    <div class="bg-yellow-500/10 p-4 rounded-full">
                        <i class="fas fa-clipboard-check text-2xl text-yellow-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-anthracite">Valider les dépôts</h3>
                        <p class="text-vert-foret text-sm">{{ $depotsEnAttente }} dépôt(s) en attente</p>
                    </div>
                </div>
            </a>

            <!-- Paramètres -->
            <a href="{{ route('admin.parametres.index') }}" class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition-shadow border-l-4 border-vert-foret">
                <div class="flex items-center space-x-4">
                    <div class="bg-vert-foret/10 p-4 rounded-full">
                        <i class="fas fa-sliders text-2xl text-vert-foret"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-anthracite">Gérer les paramètres</h3>
                        <p class="text-vert-foret text-sm">Ajouter, modifier ou supprimer des paramètres</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection