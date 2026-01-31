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
        /* Mobile sidebar */
        .mobile-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        .mobile-sidebar.open {
            transform: translateX(0);
        }
        .sidebar-overlay {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }
        .sidebar-overlay.open {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>

<body class="bg-sauge min-h-screen flex flex-col">

    <!-- Top Bar -->
    <header class="bg-vert-foret shadow-lg sticky top-0 z-50">
        <div class="px-4 py-3 md:py-4 flex justify-between items-center">
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="lg:hidden text-white text-2xl mr-3 p-2 hover:bg-vert-clair/20 rounded-lg">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <i class="fas fa-gifts text-rose-corail text-2xl md:text-3xl"></i>
                <h1 class="text-xl md:text-3xl font-christmas font-bold text-white">
                    MagiCadeaux
                </h1>
            </div>

            <!-- User Info & Dropdown -->
            <div class="flex items-center space-x-2 md:space-x-6">
                <!-- Solde / Total commissions (auto) - Hidden on small screens -->
                <div class="hidden sm:flex bg-vert-clair/20 px-2 md:px-4 py-2 rounded-lg border border-vert-clair/30">
                    <i class="fas fa-coins text-yellow-300 mr-2"></i>
                    <span class="text-white font-sans font-semibold text-xs md:text-base">
                        @hasSection('solde')
                            @yield('solde')
                        @elseif(isset($totalCommissions))
                            <span class="hidden md:inline">Total commission :</span> {{ number_format($totalCommissions, 2, ',', ' ') }} Ar
                        @else
                            <span class="hidden md:inline">Solde :</span> {{ number_format($utilisateur->solde ?? 0, 2, ',', ' ') }} Ar
                        @endif
                    </span>
                </div>

                <!-- User Dropdown -->
                <div class="relative dropdown">
                    <button class="flex items-center space-x-1 md:space-x-2 bg-vert-clair/20 hover:bg-vert-clair/30 px-2 md:px-4 py-2 rounded-lg transition-colors border border-vert-clair/30">
                        <i class="fas fa-user-circle text-white text-xl md:text-2xl"></i>
                        <span class="text-white font-sans font-medium text-sm md:text-base hidden sm:inline">
                            {{ $utilisateur->nom ?? 'Utilisateur' }}
                        </span>
                        <i class="fas fa-chevron-down text-white text-xs md:text-sm"></i>
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

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="sidebar-overlay fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

    <div class="flex flex-1">
        <!-- Sidebar (overridable via @section('sidebar')) -->
        <aside id="sidebar" class="mobile-sidebar fixed lg:relative w-64 bg-vert-foret shadow-xl z-50 h-full lg:h-auto lg:transform-none">
            <!-- Close button for mobile -->
            <div class="lg:hidden flex justify-end p-4">
                <button id="close-sidebar-btn" class="text-white text-2xl hover:bg-vert-clair/20 p-2 rounded-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Mobile solde display -->
            <div class="lg:hidden px-4 pb-4">
                <div class="bg-vert-clair/20 px-4 py-3 rounded-lg border border-vert-clair/30">
                    <i class="fas fa-coins text-yellow-300 mr-2"></i>
                    <span class="text-white font-sans font-semibold text-sm">
                        @hasSection('solde')
                            @yield('solde')
                        @elseif(isset($totalCommissions))
                            {{ number_format($totalCommissions, 2, ',', ' ') }} Ar
                        @else
                            Solde: {{ number_format($utilisateur->solde ?? 0, 2, ',', ' ') }} Ar
                        @endif
                    </span>
                </div>
            </div>
            
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
            // Mobile sidebar toggle
            var mobileMenuBtn = document.getElementById('mobile-menu-btn');
            var closeSidebarBtn = document.getElementById('close-sidebar-btn');
            var sidebar = document.getElementById('sidebar');
            var sidebarOverlay = document.getElementById('sidebar-overlay');

            function openSidebar() {
                sidebar.classList.add('open');
                sidebarOverlay.classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('open');
                document.body.style.overflow = '';
            }

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', openSidebar);
            }
            if (closeSidebarBtn) {
                closeSidebarBtn.addEventListener('click', closeSidebar);
            }
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
            }

            // Close sidebar on nav link click (mobile)
            sidebar.querySelectorAll('a').forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) {
                        closeSidebar();
                    }
                });
            });

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
                    closeSidebar();
                    document.querySelectorAll('.dropdown .dropdown-menu').forEach(function(m) {
                        if (!m.classList.contains('hidden')) m.classList.add('hidden');
                    });
                }
            });
        });
    </script>

</body>

</html>