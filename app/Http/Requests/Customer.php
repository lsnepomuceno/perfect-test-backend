<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Customer extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->customer ? ",{$this->customer->id}" : '';
        return [
            'name'   => 'required|string|max:64',
            'email'  => "nullable|string|max:128|unique:App\Models\Customers,email{$id}",
            'cpf'    => "required|string|max:14|unique:App\Models\Customers,cpf{$id}"
        ];
    }

    public function attributes(): array
    {
        return [
            'name'   => 'nome',
            'email'  => 'e-mail',
            'cpf'    => 'CPF'
        ];
    }
}
