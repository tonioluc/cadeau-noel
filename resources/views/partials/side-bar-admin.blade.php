<nav class="space-y-2">
    <a href="{{ route('admin.accueil') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-vert-clair/20 transition-colors group {{ request()->routeIs('admin.accueil') ? 'bg-rose-corail text-white' : 'text-white/80' }}">
        <i class="fas fa-gauge-high text-xl {{ request()->routeIs('admin.accueil') ? 'text-white' : 'text-rose-corail' }}"></i>
        <span class="font-sans font-medium group-hover:text-white">Dashboard</span>
    </a>
    
    <a href="{{ route('admin.cadeaux.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-vert-clair/20 transition-colors group {{ request()->routeIs('admin.cadeaux.*') ? 'bg-rose-corail text-white' : 'text-white/80' }}">
        <i class="fas fa-gift text-xl {{ request()->routeIs('admin.cadeaux.*') ? 'text-white' : 'text-rose-corail' }}"></i>
        <span class="font-sans font-medium group-hover:text-white">Gestion Cadeaux</span>
    </a>
    
    <a href="{{ route('depot.en-attente.list') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-vert-clair/20 transition-colors group {{ request()->routeIs('depot.en-attente.*') || request()->routeIs('depot.valider') ? 'bg-rose-corail text-white' : 'text-white/80' }}">
        <i class="fas fa-clipboard-check text-xl {{ request()->routeIs('depot.en-attente.*') || request()->routeIs('depot.valider') ? 'text-white' : 'text-rose-corail' }}"></i>
        <span class="font-sans font-medium group-hover:text-white">Validation Dépôts</span>
    </a>
    
    <a href="{{ route('admin.parametres.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-vert-clair/20 transition-colors group {{ request()->routeIs('admin.parametres.*') ? 'bg-rose-corail text-white' : 'text-white/80' }}">
        <i class="fas fa-sliders text-xl {{ request()->routeIs('admin.parametres.*') ? 'text-white' : 'text-rose-corail' }}"></i>
        <span class="font-sans font-medium group-hover:text-white">Gestion Paramètres</span>
    </a>

    <a href="{{ route('admin.depots.historique') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-vert-clair/20 transition-colors group {{ request()->routeIs('admin.depots.historique') ? 'bg-rose-corail text-white' : 'text-white/80' }}">
        <i class="fas fa-history text-xl {{ request()->routeIs('admin.depots.historique') ? 'text-white' : 'text-rose-corail' }}"></i>
        <span class="font-sans font-medium group-hover:text-white">Historique Dépôts</span>
    </a>
    <a href="{{ route('admin.choix.historique') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-vert-clair/20 transition-colors group {{ request()->routeIs('admin.choix.historique') ? 'bg-rose-corail text-white' : 'text-white/80' }}">
        <i class="fas fa-box-open text-xl {{ request()->routeIs('admin.choix.historique') ? 'text-white' : 'text-rose-corail' }}"></i>
        <span class="font-sans font-medium group-hover:text-white">Historique Choix</span>
    </a>
</nav>
