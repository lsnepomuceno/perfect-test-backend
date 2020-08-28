<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Fluent;
use App\Http\Requests\{
    Sale as RequestsSale,
    SaleCustomer as RequestsSaleCustomer
};
use App\Models\{
    Sales as SalesModel,
    Products as ProductsModel,
    StatusSales as StatusModel,
    Customers as CustomersModel
};
use Illuminate\Http\Request;
use Illuminate\View\View;

class Sales extends Controller
{
    public function create(): View
    {
        return view('crud_sales', [
            'route' => 'sale.store',
            'products' => ProductsModel::all(),
            'status' => StatusModel::all(),
            'customers' => CustomersModel::all()
        ]);
    }

    public function store(RequestsSaleCustomer $request, SalesModel $sale): RedirectResponse
    {
        $customer = $this->getCustomerid($request);

        if ($customer) {
            $s = new Fluent($request->only(['discount', 'quantity', 'sold_at']));
            $s->product_id = (new ProductsModel)->findIdByUuid($request->product);
            $s->status_id = (new StatusModel())->findIdByUuid($request->status);
            $s->customer_id = $customer;

            if (($sale->create($s->toArray()))->id)
                return redirect()
                    ->route('dashboard')
                    ->with('success', 'Venda cadastrada com sucesso.');
        }

        return back()
            ->withInput()
            ->with('error', 'Não foi possível cadastrar a venda.');
    }

    public function edit(SalesModel $sale) //: View|RedirectResponse # Union types PHP V8
    {
        if ($sale->id) {
            return view('crud_sales', [
                'route' => 'sale.update',
                'uuid' => $sale->uuid,
                'sale' => $sale,
                'products' => ProductsModel::all(),
                'status' => StatusModel::all(),
                'customers' => CustomersModel::all()
            ]);
        }

        return redirect()
            ->route('sale.create')
            ->with('error', 'Não foi possível identificar a venda.');
    }

    public function update(RequestsSaleCustomer $request, SalesModel $sale): RedirectResponse
    {
        $customer = $this->getCustomerid($request);

        if ($customer) {
            $s = new Fluent($request->only(['discount', 'quantity', 'sold_at']));
            $s->product_id = (new ProductsModel)->findIdByUuid($request->product);
            $s->status_id = (new StatusModel())->findIdByUuid($request->status);
            $s->customer_id = $customer;

            if ($sale->fill($s->toArray())->save())
                return redirect()
                    ->route('dashboard')
                    ->with('success', 'Venda atualizada com sucesso.');
        }

        return back()
            ->withInput()
            ->with('error', 'Não foi possível atualizar a venda.');
    }

    public function destroy(SalesModel $sale)
    {
        if ($sale->delete()) {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Venda removida com sucesso.');
        }

        return back()
            ->withInput()
            ->with('error', 'Não foi possível remover a venda.');
    }

    private function getCustomerid(Request $request): int
    {
        return $request->filled('customer')
            ? (new CustomersModel)->findIdByUuid($request->customer)
            : (CustomersModel::create($request->only(['name', 'email', 'cpf'])))->id;
    }
}
