@extends('layouts.auth')

@section('title', 'Inscription')
@section('icon', 'user-plus')
@section('heading', 'Inscription')
@section('subheading', 'Rejoignez la magie de Noël')

@section('form')
<form method="POST" action="<?php echo e(route('register.store')); ?>" class="space-y-6">
    <?php echo csrf_field(); ?>
    
    <div>
        <label for="nom" class="block text-vert-foret font-medium mb-2 font-sans">
            <i class="fas fa-user mr-2"></i>Nom d'utilisateur
        </label>
        <input 
            type="text" 
            id="nom" 
            name="nom" 
            value="<?php echo e(old('nom')); ?>" 
            required
            class="w-full px-4 py-3 rounded-lg border-2 border-vert-clair focus:border-rose-corail focus:outline-none transition-colors font-sans"
            placeholder="Choisissez un nom d'utilisateur"
        >
        <?php $__errorArgs = ['nom']; $__bag = $errors->getBag('default'); if ($__bag->has($__errorArgs[0])) : if (isset($message)) { $__messageOriginal = $message; } $message = $__bag->first($__errorArgs[0]); ?>
            <div class="mt-2 bg-red-50 border-l-4 border-red-500 p-3 rounded">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2 text-sm"></i>
                    <p class="text-red-700 font-sans text-sm"><?php echo e($message); ?></p>
                </div>
            </div>
        <?php unset($message); if (isset($__messageOriginal)) { $message = $__messageOriginal; } endif; unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label for="mot_de_passe" class="block text-vert-foret font-medium mb-2 font-sans">
            <i class="fas fa-lock mr-2"></i>Mot de passe
        </label>
        <input 
            type="password" 
            id="mot_de_passe" 
            name="mot_de_passe" 
            required
            class="w-full px-4 py-3 rounded-lg border-2 border-vert-clair focus:border-rose-corail focus:outline-none transition-colors font-sans"
            placeholder="Créez un mot de passe sécurisé"
        >
        <?php $__errorArgs = ['mot_de_passe']; $__bag = $errors->getBag('default'); if ($__bag->has($__errorArgs[0])) : if (isset($message)) { $__messageOriginal = $message; } $message = $__bag->first($__errorArgs[0]); ?>
            <div class="mt-2 bg-red-50 border-l-4 border-red-500 p-3 rounded">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2 text-sm"></i>
                    <p class="text-red-700 font-sans text-sm"><?php echo e($message); ?></p>
                </div>
            </div>
        <?php unset($message); if (isset($__messageOriginal)) { $message = $__messageOriginal; } endif; unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <button 
            type="submit"
            class="w-full bg-rose-corail hover:bg-[#e07b7d] text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg font-sans"
        >
            <i class="fas fa-user-plus mr-2"></i>Créer le compte
        </button>
    </div>
</form>
@endsection

@section('footer-link')
<p class="text-vert-foret font-sans">
    Déjà un compte ? 
    <a href="<?php echo e(route('login.show')); ?>" class="text-rose-corail hover:underline font-semibold">
        Se connecter <i class="fas fa-arrow-right ml-1"></i>
    </a>
</p>
@endsection
