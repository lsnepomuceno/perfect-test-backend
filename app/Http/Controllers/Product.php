<?php

namespace App\Http\Controllers;

use Illuminate\Http\{RedirectResponse, UploadedFile};
use App\Http\Requests\Product as RequestsProduct;
use App\Models\Products as ProductsModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class Product extends Controller
{
    public function create(): View
    {
        return view('crud_products', [
            'route' => 'product.store'
        ]);
    }

    public function store(RequestsProduct $request, ProductsModel $products): RedirectResponse
    {
        $p = $request->validated();

        if ($request->hasFile('image'))
            $p['image'] = $this->saveImage($request->file('image'));

        if (($products->create($p))->id) {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Produto cadastrado com sucesso.');
        }

        return back()
            ->withInput()
            ->with('error', 'Não foi possível cadastrar o produto.');
    }

    public function edit(ProductsModel $product) //: View|RedirectResponse # Union types PHP V8
    {
        if ($product->id) {
            return view('crud_products', [
                'product' => $product,
                'route' => 'product.update',
                'uuid' => $product->uuid
            ]);
        }

        return redirect()
            ->route('product.create')
            ->with('error', 'Não foi possível identificar o produto.');
    }

    public function update(RequestsProduct $request, ProductsModel $product): RedirectResponse
    {
        $p = $request->validated();

        if ($request->hasFile('image')) {
            if (Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            $p['image'] = $this->saveImage($request->file('image'));
        }

        if ($product->fill($p)->save()) {
            return redirect()
                ->route('dashboard')
                ->with('success', "Produto {$product->name} atualizado com sucesso.");
        }

        return back()
            ->withInput()
            ->with('error', "Erro ao atualizar o produto {$product->name}, tente novamente.");
    }

    public function destroy(ProductsModel $product)
    {
        if ($product->delete()) {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Produto removido com sucesso.');
        }

        return back()
            ->withInput()
            ->with('error', 'Não foi possível remover o produto.');
    }

    private function saveImage(UploadedFile $image): string
    {
        return $image->storeAs('products', $image->hashName());
    }
}
