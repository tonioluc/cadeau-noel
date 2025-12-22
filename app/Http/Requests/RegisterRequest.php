<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:100', 'unique:utilisateur,nom'],
            'mot_de_passe' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => "Le nom d'utilisateur est obligatoire.",
            'nom.string' => "Le nom d'utilisateur doit être une chaîne de caractères.",
            'nom.max' => "Le nom d'utilisateur ne doit pas dépasser 100 caractères.",
            'nom.unique' => "Ce nom d'utilisateur existe déjà.",

            'mot_de_passe.required' => 'Le mot de passe est obligatoire.',
            'mot_de_passe.string' => 'Le mot de passe doit être une chaîne de caractères.',
        ];
    }
}
