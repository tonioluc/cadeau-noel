<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCadeauRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['required','string','max:100'],
            'description' => ['nullable','string'],
            'id_categorie_cadeau' => ['required','integer','exists:categorie_cadeau,id_categorie_cadeau'],
            'prix' => ['required','numeric','min:0.01'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg,gif,webp','max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom du cadeau est obligatoire.',
            'nom.max' => 'Le nom ne doit pas dépasser 100 caractères.',
            'id_categorie_cadeau.required' => 'La catégorie est obligatoire.',
            'id_categorie_cadeau.exists' => 'La catégorie sélectionnée est invalide.',
            'prix.required' => 'Le prix est obligatoire.',
            'prix.numeric' => 'Le prix doit être un nombre.',
            'prix.min' => 'Le prix doit être supérieur ou égal à 0.',
            'image.image' => "Le fichier doit être une image.",
            'image.mimes' => 'Formats autorisés: jpeg, png, jpg, gif, webp.',
            'image.max' => 'La taille maximale de l\'image est 4 Mo.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nom' => 'nom',
            'description' => 'description',
            'id_categorie_cadeau' => 'catégorie',
            'prix' => 'prix',
            'image' => 'image',
        ];
    }
}
