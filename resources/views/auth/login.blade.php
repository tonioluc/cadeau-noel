@extends('layouts.auth')

@section('title', 'Connexion')
@section('icon', 'gift')
@section('heading', 'Connexion')
@section('subheading', 'Bienvenue sur votre plateforme de cadeaux')

@section('form')
<form method="POST" action="<?php echo e(route('login.store')); ?>" class="space-y-6">
    <?php echo csrf_field(); ?>
    
    <div>
        <label for="nom" class="block text-vert-foret font-medium mb-2 font-sans">
            <i class="fas fa-user mr-2"></i>Nom d'utilisateur
        </label>
        <input 
            type="text" 
            id="nom" 
            name="nom" 
            value="<?php echo e(old('nom', 'admin')); ?>" 
            required
            class="w-full px-4 py-3 rounded-lg border-2 border-vert-clair focus:border-rose-corail focus:outline-none transition-colors font-sans"
            placeholder="Entrez votre nom d'utilisateur"
        >
    </div>

    <div>
        <label for="mot_de_passe" class="block text-vert-foret font-medium mb-2 font-sans">
            <i class="fas fa-lock mr-2"></i>Mot de passe
        </label>
        <input 
            type="password" 
            id="mot_de_passe" 
            name="mot_de_passe" 
            value="admin"
            required
            class="w-full px-4 py-3 rounded-lg border-2 border-vert-clair focus:border-rose-corail focus:outline-none transition-colors font-sans"
            placeholder="Entrez votre mot de passe"
        >
    </div>

    <?php if($errors->has('credentials')): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <p class="text-red-700 font-sans"><?php echo e($errors->first('credentials')); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <div>
        <button 
            type="submit"
            class="w-full bg-rose-corail hover:bg-[#e07b7d] text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg font-sans"
        >
            <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
        </button>
    </div>
</form>
@endsection

@section('footer-link')
<p class="text-vert-foret font-sans">
    Pas de compte ? 
    <a href="<?php echo e(route('register.show')); ?>" class="text-rose-corail hover:underline font-semibold">
        Créer un compte <i class="fas fa-arrow-right ml-1"></i>
    </a>
</p>
@endsection
