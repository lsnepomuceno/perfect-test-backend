<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class SaleCustomer extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'customer' => 'required|uuid|exists:App\Models\Customers,uuid'
        ];

        if ($this->filled('cpf') || $this->filled('name')) {
            $rules = (new Customer)->rules();
        }

        return (new Sale)->rules() +
            $rules;
    }

    public function attributes(): array
    {
        return (new Sale)->attributes() +
            (new Customer)->attributes() +
            [
                'customer' => 'cliente'
            ];
    }

    public function messages(): array
    {
        return [
            'customer.required' => 'Selecione um cliente ou utilize os campos abaixo para realizar um novo cadastro.'
        ];
    }
}
