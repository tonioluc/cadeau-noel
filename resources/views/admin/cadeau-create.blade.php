@extends('layouts.app')

@section('title', 'Ajouter un Cadeau')

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
                <i class="fa-solid fa-plus-circle text-rose-corail mr-3"></i>
                Ajouter un Cadeau
            </h1>
            <p class="text-gray-600 mt-2">Créez un nouveau cadeau dans le catalogue</p>
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
            <form method="POST" action="{{ route('admin.cadeaux.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Nom -->
                <div class="mb-6">
                    <label for="nom" class="block text-anthracite font-semibold mb-2">
                        <i class="fa-solid fa-gift mr-2 text-sauge"></i>
                        Nom du cadeau <span class="text-rose-corail">*</span>
                    </label>
                    <input type="text" 
                           id="nom"
                           name="nom" 
                           value="{{ old('nom') }}"
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
                              placeholder="Description détaillée du cadeau...">{{ old('description') }}</textarea>
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
                        <option value="">-- Sélectionner une catégorie --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id_categorie_cadeau }}" {{ old('id_categorie_cadeau') == $cat->id_categorie_cadeau ? 'selected' : '' }}>
                                @if($cat->libelle == 'Fille')
                                    <i class="fa-solid fa-venus"></i> 
                                @elseif($cat->libelle == 'Garçon')
                                    <i class="fa-solid fa-mars"></i>
                                @else
                                    <i class="fa-solid fa-genderless"></i>
                                @endif
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
                               value="{{ old('prix') }}"
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

                <!-- Image -->
                <div class="mb-8">
                    <label for="image" class="block text-anthracite font-semibold mb-2">
                        <i class="fa-solid fa-image mr-2 text-sauge"></i>
                        Image (optionnel)
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
                                <p class="text-gray-600">Cliquez pour sélectionner une image</p>
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
                        <i class="fa-solid fa-plus mr-2"></i>
                        Créer le cadeau
                    </button>
                </div>
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