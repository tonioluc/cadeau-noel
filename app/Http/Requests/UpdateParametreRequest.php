<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateParametreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $code = strtoupper((string) $this->route('code'));

        $rules = [
            'valeur' => ['required'],
        ];

        // Règles spécifiques pour le code COMM (commission en pourcentage)
        if ($code === 'COMM') {
            $rules['valeur'][] = 'numeric';
            $rules['valeur'][] = 'min:0';
            $rules['valeur'][] = 'max:100';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'valeur.required' => 'La valeur du paramètre est obligatoire.',
            'valeur.numeric'  => 'La valeur du paramètre doit être un nombre.',
            'valeur.min'      => 'La valeur du paramètre doit être au moins :min.',
            'valeur.max'      => 'La valeur du paramètre ne peut pas dépasser :max.',
        ];
    }

    public function attributes(): array
    {
        return [
            'valeur' => 'valeur du paramètre',
        ];
    }
}
