<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateNombreEnfants extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'filles' => ['required', 'integer', 'min:0'],
            'garcons' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'filles.required' => 'Le nombre de filles est obligatoire.',
            'filles.integer'  => 'Le nombre de filles doit être un entier.',
            'filles.min'      => 'Le nombre de filles ne peut pas être négatif.',

            'garcons.required' => 'Le nombre de garçons est obligatoire.',
            'garcons.integer'  => 'Le nombre de garçons doit être un entier.',
            'garcons.min'      => 'Le nombre de garçons ne peut pas être négatif.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $filles = (int) $this->input('filles', 0);
            $garcons = (int) $this->input('garcons', 0);

            if (($filles + $garcons) <= 0) {
                $validator->errors()->add('global', "Le nombre d'enfant doit être supérieur à 0.");
            }
        });
    }
}
