<?php
$utilisateur = \App\Models\Utilisateur::find(session('id_utilisateur'));
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Accueil') - MagiCadeaux</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mountains+of+Christmas:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sauge': '#84A36E',
                        'anthracite': '#2D2D2D',
                        'vert-foret': '#35452E',
                        'rose-corail': '#F08C8E',
                        'vert-clair': '#C2D6B0',
                    },
                    fontFamily: {
                        'christmas': ['"Mountains of Christmas"', 'cursive'],
                        'sans': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>

<body class="bg-sauge min-h-screen flex flex-col">

    <!-- Top Bar -->
    <header class="bg-vert-foret shadow-lg sticky top-0 z-50">
        <div class="px-4 py-4 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <i class="fas fa-gifts text-rose-corail text-3xl"></i>
                <h1 class="text-3xl font-christmas font-bold text-white">
                    MagiCadeaux
                </h1>
            </div>

            <!-- User Info & Dropdown -->
            <div class="flex items-center space-x-6">
                <!-- Solde / Total commissions (auto) -->
                <div class="bg-vert-clair/20 px-4 py-2 rounded-lg border border-vert-clair/30">
                    <i class="fas fa-coins text-yellow-300 mr-2"></i>
                    <span class="text-white font-sans font-semibold">
                        @hasSection('solde')
                            @yield('solde')
                        @elseif(isset($totalCommissions))
                            Total commission obtenue : {{ number_format($totalCommissions, 2, ',', ' ') }} Ar
                        @else
                            Solde : {{ number_format($utilisateur->solde ?? 0, 2, ',', ' ') }} Ar
                        @endif
                    </span>
                </div>

                <!-- User Dropdown -->
                <div class="relative dropdown">
                    <button class="flex items-center space-x-2 bg-vert-clair/20 hover:bg-vert-clair/30 px-4 py-2 rounded-lg transition-colors border border-vert-clair/30">
                        <i class="fas fa-user-circle text-white text-2xl"></i>
                        <span class="text-white font-sans font-medium">
                            {{ $utilisateur->nom ?? 'Utilisateur' }}
                        </span>
                        <i class="fas fa-chevron-down text-white text-sm"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border-2 border-vert-clair overflow-hidden">
                        <hr class="border-vert-clair">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 hover:bg-red-50 transition-colors font-sans text-red-600">
                                <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="flex flex-1">
        <!-- Sidebar (overridable via @section('sidebar')) -->
        <aside class="w-64 bg-vert-foret shadow-xl">
            @hasSection('sidebar')
            <div class="p-4">
                @yield('sidebar')
            </div>
            @else
            <nav class="p-4 space-y-2">
                <a href="{{ route('utilisateur.accueil') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-vert-clair/20 transition-colors group {{ request()->routeIs('utilisateur.accueil') ? 'bg-rose-corail text-white' : 'text-white/80' }}">
                    <i class="fas fa-home text-xl {{ request()->routeIs('utilisateur.accueil') ? 'text-white' : 'text-rose-corail' }}"></i>
                    <span class="font-sans font-medium group-hover:text-white">Accueil</span>
                </a>

                <a href="{{ route('depot.show') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-vert-clair/20 transition-colors group {{ request()->routeIs('depot.show') ? 'bg-rose-corail text-white' : 'text-white/80' }}">
                    <i class="fas fa-hand-holding-dollar text-xl {{ request()->routeIs('depot.show') ? 'text-white' : 'text-rose-corail' }}"></i>
                    <span class="font-sans font-medium group-hover:text-white">Faire un dépôt</span>
                </a>

                <a href="{{ route('utilisateur.form-entrer-nbr-enfants') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-vert-clair/20 transition-colors group {{ request()->routeIs('utilisateur.form-entrer-nbr-enfants') || request()->routeIs('utilisateur.suggerer-cadeaux') ? 'bg-rose-corail text-white' : 'text-white/80' }}">
                    <i class="fas fa-gift text-xl {{ request()->routeIs('utilisateur.form-entrer-nbr-enfants') || request()->routeIs('utilisateur.suggerer-cadeaux') ? 'text-white' : 'text-rose-corail' }}"></i>
                    <span class="font-sans font-medium group-hover:text-white">Obtenir des cadeaux</span>
                </a>
                <a href="{{ route('utilisateur.historique-depots') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-vert-clair/20 transition-colors group {{ request()->routeIs('utilisateur.historique-depots') ? 'bg-rose-corail text-white' : 'text-white/80' }}">
                    <i class="fas fa-list text-xl {{ request()->routeIs('utilisateur.historique-depots') ? 'text-white' : 'text-rose-corail' }}"></i>
                    <span class="font-sans font-medium group-hover:text-white">Historique des dépôts</span>
                </a>
                <a href="{{ route('utilisateur.historique-choix') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-vert-clair/20 transition-colors group {{ request()->routeIs('utilisateur.historique-choix') ? 'bg-rose-corail text-white' : 'text-white/80' }}">
                    <i class="fas fa-gifts text-xl {{ request()->routeIs('utilisateur.historique-choix') ? 'text-white' : 'text-rose-corail' }}"></i>
                    <span class="font-sans font-medium group-hover:text-white">Historique des choix</span>
                </a>
            </nav>
            @endif
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- Content Area -->
            <div class="flex-1">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="bg-vert-foret shadow-lg">
                <div class="container mx-auto px-6 py-4">
                    <div class="flex items-center justify-center space-x-2">
                        <i class="fas fa-sparkles text-yellow-300"></i>
                        <p class="text-white font-christmas text-xl">
                            La magie de Noël à portée de main
                        </p>
                        <i class="fas fa-sparkles text-yellow-300"></i>
                    </div>
                    <p class="text-center text-white/60 text-sm font-sans mt-2">
                        © 2025 MagiCadeaux - Tous droits réservés
                    </p>
                </div>
            </footer>
        </main>
    </div>

    <script>
        // Dropdown toggle: click to open, click outside or Esc to close
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle dropdown menus on button click
            document.querySelectorAll('.dropdown').forEach(function(drop) {
                var btn = drop.querySelector('button');
                var menu = drop.querySelector('.dropdown-menu');
                if (!btn || !menu) return;

                // Ensure menu starts hidden (Tailwind 'hidden' class)
                if (!menu.classList.contains('hidden') && menu.style.display === '') {
                    menu.classList.add('hidden');
                }

                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    // Toggle Tailwind hidden class
                    menu.classList.toggle('hidden');
                });
            });

            // Close on outside click
            document.addEventListener('click', function() {
                document.querySelectorAll('.dropdown .dropdown-menu').forEach(function(m) {
                    if (!m.classList.contains('hidden')) m.classList.add('hidden');
                });
            });

            // Close on Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.dropdown .dropdown-menu').forEach(function(m) {
                        if (!m.classList.contains('hidden')) m.classList.add('hidden');
                    });
                }
            });
        });
    </script>

</body>

</html>