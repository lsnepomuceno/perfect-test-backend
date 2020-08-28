<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Sale extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product'     => 'required|uuid|exists:App\Models\Products,uuid',
            'status'      => 'required|uuid|exists:App\Models\StatusSales,uuid',
            'discount'    => 'nullable|numeric|max:100',
            'quantity'    => 'required|numeric|min:1|max:10',
            'sold_at'     => 'required|date_format:d/m/Y'
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id'  => 'produto',
            'status_id'   => 'status',
            'discount'    => 'desconto',
            'quantity'    => 'quantidade',
            'sold_at'     => 'data'
        ];
    }
}
