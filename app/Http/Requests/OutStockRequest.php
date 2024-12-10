<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutStockRequest extends FormRequest
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
            'bureau_id' => ['required', 'exists:bureaus,id'],
            'article_id' => ['required', 'exists:articles,id'],
            'quantiteLivree' => ['required', 'min:1'],
            'reception' => ['required', 'string'],
            'date_sortie' => ['required', 'date'],
        ];
    }
}
