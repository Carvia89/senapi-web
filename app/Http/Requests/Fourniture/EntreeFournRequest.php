<?php

namespace App\Http\Requests\Fourniture;

use Illuminate\Foundation\Http\FormRequest;

class EntreeFournRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fournisseur_id' => ['required', 'exists:fournisseurs,id'],
            'option_id' => ['required', 'exists:options,id'],
            'classe_id' => ['required', 'exists:kelasis,id'],
            'quantiteRecu' => ['required', 'min:1'],
            'date_entree' => ['required'],
            'description' => ['nullable', 'min:5'],
            'reception' => ['required', 'min:5']
        ];
    }
}
