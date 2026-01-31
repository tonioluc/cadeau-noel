@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('sidebar')
@include('partials.side-bar-admin')
@endsection


@section('solde','Total commission obtenue : '.number_format($totalCommissions, 2, ',', ' ').' Ar')

@section('content')
<div class="p-4 md:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6 md:mb-8">
            <h1 class="text-2xl md:text-4xl font-christmas text-anthracite">
                <i class="fas fa-gauge-high text-rose-corail mr-2 md:mr-3"></i>Dashboard
            </h1>
            <p class="text-vert-foret mt-1 md:mt-2 text-sm md:text-base">Bienvenue dans l'espace d'administration MagiCadeaux</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-8">
            <!-- Total Utilisateurs -->
            <div class="bg-vert-clair rounded-xl p-4 md:p-6 shadow">
                <div class="flex flex-col md:flex-row items-start md:items-center md:justify-between">
                    <div>
                        <p class="text-vert-foret text-xs md:text-sm font-medium">Utilisateurs</p>
                        <p class="text-xl md:text-3xl font-bold text-anthracite">{{ $totalUtilisateurs }}</p>
                    </div>
                    <div class="bg-white/50 p-2 md:p-3 rounded-full mt-2 md:mt-0">
                        <i class="fas fa-users text-lg md:text-2xl text-vert-foret"></i>
                    </div>
                </div>
            </div>

            <!-- Total Cadeaux -->
            <div class="bg-vert-clair rounded-xl p-4 md:p-6 shadow">
                <div class="flex flex-col md:flex-row items-start md:items-center md:justify-between">
                    <div>
                        <p class="text-vert-foret text-xs md:text-sm font-medium">Cadeaux</p>
                        <p class="text-xl md:text-3xl font-bold text-anthracite">{{ $totalCadeaux }}</p>
                    </div>
                    <div class="bg-white/50 p-2 md:p-3 rounded-full mt-2 md:mt-0">
                        <i class="fas fa-gift text-lg md:text-2xl text-rose-corail"></i>
                    </div>
                </div>
            </div>

            <!-- Dépôts en attente -->
            <div class="bg-vert-clair rounded-xl p-4 md:p-6 shadow">
                <div class="flex flex-col md:flex-row items-start md:items-center md:justify-between">
                    <div>
                        <p class="text-vert-foret text-xs md:text-sm font-medium">Dépôts en attente</p>
                        <p class="text-xl md:text-3xl font-bold text-anthracite">{{ $depotsEnAttente }}</p>
                    </div>
                    <div class="bg-white/50 p-2 md:p-3 rounded-full mt-2 md:mt-0">
                        <i class="fas fa-clock text-lg md:text-2xl text-yellow-600"></i>
                    </div>
                </div>
            </div>

            <!-- Total Commissions -->
            <div class="bg-vert-clair rounded-xl p-4 md:p-6 shadow">
                <div class="flex flex-col md:flex-row items-start md:items-center md:justify-between">
                    <div>
                        <p class="text-vert-foret text-xs md:text-sm font-medium">Commissions</p>
                        <p class="text-lg md:text-2xl font-bold text-anthracite">{{ number_format($totalCommissions, 0, ',', ' ') }} Ar</p>
                    </div>
                    <div class="bg-white/50 p-2 md:p-3 rounded-full mt-2 md:mt-0">
                        <i class="fas fa-coins text-lg md:text-2xl text-yellow-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
            <!-- Gestion Cadeaux -->
            <a href="{{ route('admin.cadeaux.index') }}" class="bg-white rounded-xl p-4 md:p-6 shadow hover:shadow-lg transition-shadow border-l-4 border-rose-corail">
                <div class="flex items-center space-x-3 md:space-x-4">
                    <div class="bg-rose-corail/10 p-3 md:p-4 rounded-full">
                        <i class="fas fa-gift text-xl md:text-2xl text-rose-corail"></i>
                    </div>
                    <div>
                        <h3 class="text-base md:text-lg font-semibold text-anthracite">Gérer les cadeaux</h3>
                        <p class="text-vert-foret text-xs md:text-sm">Ajouter, modifier ou supprimer des cadeaux</p>
                    </div>
                </div>
            </a>

            <!-- Validation Dépôts -->
            <a href="{{ route('depot.en-attente.list') }}" class="bg-white rounded-xl p-4 md:p-6 shadow hover:shadow-lg transition-shadow border-l-4 border-yellow-500">
                <div class="flex items-center space-x-3 md:space-x-4">
                    <div class="bg-yellow-500/10 p-3 md:p-4 rounded-full">
                        <i class="fas fa-clipboard-check text-xl md:text-2xl text-yellow-600"></i>
                    </div>
                    <div>
                        <h3 class="text-base md:text-lg font-semibold text-anthracite">Valider les dépôts</h3>
                        <p class="text-vert-foret text-xs md:text-sm">{{ $depotsEnAttente }} dépôt(s) en attente</p>
                    </div>
                </div>
            </a>

            <!-- Paramètres -->
            <a href="{{ route('admin.parametres.index') }}" class="bg-white rounded-xl p-4 md:p-6 shadow hover:shadow-lg transition-shadow border-l-4 border-vert-foret">
                <div class="flex items-center space-x-3 md:space-x-4">
                    <div class="bg-vert-foret/10 p-3 md:p-4 rounded-full">
                        <i class="fas fa-sliders text-xl md:text-2xl text-vert-foret"></i>
                    </div>
                    <div>
                        <h3 class="text-base md:text-lg font-semibold text-anthracite">Gérer les paramètres</h3>
                        <p class="text-vert-foret text-xs md:text-sm">Ajouter, modifier ou supprimer des paramètres</p>
                    </div>
                </div>
            </a>

            <!-- Historique Dépôts -->
            <a href="{{ route('admin.depots.historique') }}" class="bg-white rounded-xl p-4 md:p-6 shadow hover:shadow-lg transition-shadow border-l-4 border-anthracite">
                <div class="flex items-center space-x-3 md:space-x-4">
                    <div class="bg-anthracite/10 p-3 md:p-4 rounded-full">
                        <i class="fas fa-list text-xl md:text-2xl text-anthracite"></i>
                    </div>
                    <div>
                        <h3 class="text-base md:text-lg font-semibold text-anthracite">Historique des dépôts</h3>
                        <p class="text-vert-foret text-xs md:text-sm">Voir tous les dépôts</p>
                    </div>
                </div>
            </a>

            <!-- Historique Choix validés -->
            <a href="{{ route('admin.choix.historique') }}" class="bg-white rounded-xl p-4 md:p-6 shadow hover:shadow-lg transition-shadow border-l-4 border-rose-corail">
                <div class="flex items-center space-x-3 md:space-x-4">
                    <div class="bg-rose-corail/10 p-3 md:p-4 rounded-full">
                        <i class="fas fa-gifts text-xl md:text-2xl text-rose-corail"></i>
                    </div>
                    <div>
                        <h3 class="text-base md:text-lg font-semibold text-anthracite">Historique des choix</h3>
                        <p class="text-vert-foret text-xs md:text-sm">Voir les choix validés</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection