<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'montant' => ['required', 'numeric', 'min:1000' , 'max:1000000'],
        ];
    }

    public function messages(): array
    {
        return [
            'montant.required' => 'Le montant du dépôt est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.min' => 'Le montant doit être supérieur à 1000.',
            'montant.max' => 'Le montant ne peut pas dépasser 1000000.',
        ];
    }
}
