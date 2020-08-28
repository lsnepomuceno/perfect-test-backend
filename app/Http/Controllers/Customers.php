<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer as RequestsCustomer;
use App\Models\Customers as CustomersModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class Customers extends Controller
{
    public function create(): View
    {
        return view('crud_customers', [
            'route' => 'customer.store'
        ]);
    }

    public function store(RequestsCustomer $request, CustomersModel $customer): RedirectResponse
    {
        if (($customer->create($request->validated()))->id) {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Cliente cadastrado com sucesso.');
        }

        return back()
            ->withInput()
            ->with('error', 'Não foi possível cadastrar o cliente.');
    }

    public function edit(CustomersModel $customer) //: View|RedirectResponse # Union types PHP V8
    {
        if ($customer->id) {
            return view('crud_customers', [
                'route' => 'customer.update',
                'uuid' => $customer->uuid,
                'customer' => $customer
            ]);
        }

        return redirect()
            ->route('customer.create')
            ->with('error', 'Não foi possível identificar o cliente.');
    }

    public function update(RequestsCustomer $request, CustomersModel $customer): RedirectResponse
    {
        if ($customer->fill($request->validated())->save()) {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Cliente atualizado com sucesso.');
        }

        return back()
            ->withInput()
            ->with('error', 'Não foi possível atualizar o cliente.');
    }

    public function destroy(CustomersModel $customer)
    {
        if ($customer->delete()) {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Cliente removido com sucesso.');
        }

        return back()
            ->withInput()
            ->with('error', 'Não foi possível remover o cliente.');
    }
}
