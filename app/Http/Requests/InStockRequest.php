<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InStockRequest extends FormRequest
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

            'date_entree' => ['required', 'date'],
            'article_id' => ['required', 'exists:articles,id'],
            'unite_id' => ['required', 'exists:unit_articles,id'],
            'quantite' => ['required', 'integer'],
            'fournisseur_id' => ['required', 'exists:fournisseurs,id'],
            'num_facture' => ['required', 'string'],
            'ref_bon_CMD' => ['required', 'string'],

        ];
    }
}
