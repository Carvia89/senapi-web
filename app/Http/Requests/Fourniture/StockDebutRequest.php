<?php

namespace App\Http\Requests\Fourniture;

use Illuminate\Foundation\Http\FormRequest;

class StockDebutRequest extends FormRequest
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
            'option_id' => ['required', 'exists:options,id'],
            'classe_id' => ['required', 'exists:kelasis,id'],
            'stock_debut' => ['required', 'min:1']
        ];
    }
}
