<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Product extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'price' => isset($this->price) ? str_replace(',', '.', $this->price) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:128',
            'description' => 'required|string|max:255',
            'price'       => 'required|numeric|min:100|max:9999999999.99',
            'image'       => 'nullable|file|image'
        ];
    }

    public function attributes(): array
    {
        return [
            'name'        => 'nome',
            'description' => 'decrição',
            'price'       => 'preço'
        ];
    }
}
