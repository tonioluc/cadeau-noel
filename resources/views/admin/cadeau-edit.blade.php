@extends('layouts.app')

@section('title', 'Modifier le Cadeau - ' . $cadeau->nom)

@section('sidebar')
    @include('partials.side-bar-admin')
@endsection

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-2xl mx-auto px-4">
        <!-- En-tête -->
        <div class="mb-8">
            <a href="{{ route('admin.cadeaux.index') }}" class="inline-flex items-center text-sauge hover:text-vert-foret transition-colors mb-4">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Retour à la liste
            </a>
            <h1 class="text-3xl font-bold text-anthracite font-mountains">
                <i class="fa-solid fa-pen-to-square text-rose-corail mr-3"></i>
                Modifier le Cadeau
            </h1>
            <p class="text-gray-600 mt-2">Modification de : <strong class="text-anthracite">{{ $cadeau->nom }}</strong></p>
        </div>

        <!-- Erreurs de validation -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center mb-2">
                    <i class="fa-solid fa-exclamation-triangle mr-3"></i>
                    <strong>Erreurs de validation</strong>
                </div>
                <ul class="list-disc list-inside ml-6">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-vert-clair/30">
            <form method="POST" action="{{ route('admin.cadeaux.update', $cadeau->id_cadeau) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nom -->
                <div class="mb-6">
                    <label for="nom" class="block text-anthracite font-semibold mb-2">
                        <i class="fa-solid fa-gift mr-2 text-sauge"></i>
                        Nom du cadeau <span class="text-rose-corail">*</span>
                    </label>
                    <input type="text" 
                           id="nom"
                           name="nom" 
                           value="{{ old('nom', $cadeau->nom) }}"
                           required
                           class="w-full px-4 py-3 rounded-xl border-2 border-vert-clair focus:border-sauge focus:ring-2 focus:ring-sauge/20 transition-all outline-none @error('nom') border-red-400 @enderror"
                           placeholder="Ex: Poupée Barbie, Voiture télécommandée...">
                    @error('nom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-anthracite font-semibold mb-2">
                        <i class="fa-solid fa-align-left mr-2 text-sauge"></i>
                        Description
                    </label>
                    <textarea id="description"
                              name="description" 
                              rows="4"
                              class="w-full px-4 py-3 rounded-xl border-2 border-vert-clair focus:border-sauge focus:ring-2 focus:ring-sauge/20 transition-all outline-none resize-none @error('description') border-red-400 @enderror"
                              placeholder="Description détaillée du cadeau...">{{ old('description', $cadeau->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catégorie -->
                <div class="mb-6">
                    <label for="id_categorie_cadeau" class="block text-anthracite font-semibold mb-2">
                        <i class="fa-solid fa-tag mr-2 text-sauge"></i>
                        Catégorie <span class="text-rose-corail">*</span>
                    </label>
                    <select id="id_categorie_cadeau"
                            name="id_categorie_cadeau" 
                            required
                            class="w-full px-4 py-3 rounded-xl border-2 border-vert-clair focus:border-sauge focus:ring-2 focus:ring-sauge/20 transition-all outline-none @error('id_categorie_cadeau') border-red-400 @enderror">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id_categorie_cadeau }}" {{ old('id_categorie_cadeau', $cadeau->id_categorie_cadeau) == $cat->id_categorie_cadeau ? 'selected' : '' }}>
                                {{ $cat->libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_categorie_cadeau')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prix -->
                <div class="mb-6">
                    <label for="prix" class="block text-anthracite font-semibold mb-2">
                        <i class="fa-solid fa-coins mr-2 text-sauge"></i>
                        Prix (Ar) <span class="text-rose-corail">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" 
                               id="prix"
                               name="prix" 
                               value="{{ old('prix', $cadeau->prix) }}"
                               step="0.01"
                               min="0"
                               required
                               class="w-full px-4 py-3 rounded-xl border-2 border-vert-clair focus:border-sauge focus:ring-2 focus:ring-sauge/20 transition-all outline-none pr-16 @error('prix') border-red-400 @enderror"
                               placeholder="0.00">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Ar</span>
                    </div>
                    @error('prix')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image actuelle -->
                <div class="mb-6">
                    <label class="block text-anthracite font-semibold mb-2">
                        <i class="fa-solid fa-image mr-2 text-sauge"></i>
                        Image actuelle
                    </label>
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        @if($cadeau->chemin_image)
                            <div class="flex items-center gap-4">
                                <img src="{{ asset($cadeau->chemin_image) }}" 
                                     alt="{{ $cadeau->nom }}" 
                                     class="h-24 w-24 object-cover rounded-lg shadow-md">
                                <div>
                                    <p class="text-sm text-gray-600">Image actuelle du cadeau</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ basename($cadeau->chemin_image) }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-4 text-gray-500">
                                <div class="h-24 w-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-image text-3xl text-gray-400"></i>
                                </div>
                                <p class="text-sm">Aucune image actuellement</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Nouvelle image -->
                <div class="mb-8">
                    <label for="image" class="block text-anthracite font-semibold mb-2">
                        <i class="fa-solid fa-upload mr-2 text-sauge"></i>
                        Nouvelle image (optionnel)
                    </label>
                    <div class="border-2 border-dashed border-vert-clair rounded-xl p-6 text-center hover:border-sauge transition-colors">
                        <input type="file" 
                               id="image"
                               name="image" 
                               accept="image/*"
                               class="hidden"
                               onchange="previewImage(this)">
                        <label for="image" class="cursor-pointer">
                            <div id="preview-container" class="hidden mb-4">
                                <img id="preview-image" src="" alt="Aperçu" class="max-h-40 mx-auto rounded-lg shadow-md">
                            </div>
                            <div id="upload-placeholder">
                                <i class="fa-solid fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <p class="text-gray-600">Cliquez pour changer l'image</p>
                                <p class="text-sm text-gray-400 mt-1">PNG, JPG, GIF jusqu'à 2MB</p>
                            </div>
                        </label>
                    </div>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.cadeaux.index') }}" 
                       class="px-6 py-3 rounded-xl border-2 border-gray-300 text-gray-600 hover:bg-gray-100 transition-all flex items-center">
                        <i class="fa-solid fa-times mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-sauge to-vert-foret text-white rounded-xl hover:shadow-lg transform hover:scale-105 transition-all flex items-center">
                        <i class="fa-solid fa-save mr-2"></i>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>

        <!-- Zone de danger -->
        <div class="mt-6 bg-red-50 rounded-xl p-6 border border-red-200">
            <h3 class="text-red-700 font-semibold flex items-center mb-3">
                <i class="fa-solid fa-exclamation-triangle mr-2"></i>
                Zone de danger
            </h3>
            <p class="text-red-600 text-sm mb-4">Cette action est irréversible. Le cadeau et son image seront définitivement supprimés.</p>
            <form action="{{ route('admin.cadeaux.destroy', $cadeau->id_cadeau) }}" 
                  method="POST"
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce cadeau ?');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center">
                    <i class="fa-solid fa-trash mr-2"></i>
                    Supprimer ce cadeau
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview-image');
    const previewContainer = document.getElementById('preview-container');
    const uploadPlaceholder = document.getElementById('upload-placeholder');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
            uploadPlaceholder.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection