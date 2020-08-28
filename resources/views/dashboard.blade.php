@extends('layout')

@section('title', 'Dashboard de vendas')

@section('content')
    <h1>Dashboard de vendas</h1>
    <div class='card mt-3'>
        <div class='card-body'>
            @if(session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <h5 class="card-title mb-5">Tabela de vendas
                <a href="{{ route('sale.create') }}" class='btn btn-secondary float-right btn-sm rounded-pill'><i class='fa fa-plus'></i>  Nova venda</a></h5>
            <form method="POST" action="{{ route('dashboard') }}">
                @csrf
                <div class="form-row align-items-center">
                    <div class="col-sm-5 my-1">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Cliente</div>
                            </div>
                            <select class="form-control @error('customer') is-invalid @enderror" id="customer" name="customer">
                                <option selected value="">Todos os clientes</option>
                                @forelse($customers as $customer)
                                    <option value="{{ $customer->uuid }}"
                                    @if(in_array($customer->uuid, [old('customer'), $customerUuid ?? ''])) selected @endif
                                    >{{ $customer->name }} - {{ $customer->cpf }}</option>
                                @empty
                                    <option selected disabled>Nenhum cliente cadastrado</option>
                                @endforelse
                            </select>
                            @error('customer')
                                <div class="invalid-feedback">
                                    {{ $errors->first('customer')  }}
                                </div>
                            @enderror 
                        </div>
                    </div>
                    <div class="col-sm-6 my-1">
                        <label class="sr-only" for="inlineFormInputGroupUsername">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Período</div>
                            </div>
                            <input type="text" class="form-control date_range" id="interval" name="interval" value="{{ old('interval') ?? $interval ?? '' }}">
                        </div>
                    </div>
                    <div class="col-sm-1 my-1">
                        <button type="submit" class="btn btn-primary" style='padding: 14.5px 16px;'>
                            <i class='fa fa-search'></i></button>
                    </div>
                </div>
            </form>
            <table class='table'>
                <thead>
                    <tr>
                        @if (!$customerUuid)
                            <th scope="col">
                                Cliente
                            </th>
                        @endif
                        <th scope="col">
                            Produto
                        </th>
                        <th scope="col">
                            Data
                        </th>
                        <th scope="col">
                            Qtd.
                        </th>
                        <th scope="col">
                            Vlr. Unit.
                        </th>
                        <th scope="col">
                            Desconto
                        </th>
                        <th scope="col">
                            Total
                        </th>
                        <th scope="col">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            @if (!$customerUuid)
                                <td>{{ $sale->customer->name }}</td>
                            @endif
                            <td>{{ $sale->product->name }}</td>
                            <td>{{ $sale->sold_at }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>R$ {{ number_format($sale->value, 2, ',', '.') }}</td>
                            <td>{{ $sale->discount ? number_format($sale->discount, 2, ',', '.') . '%' : '-' }}</td>
                            <td>R$ {{ number_format($sale->total_value, 2, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('sale.edit', $sale->uuid) }}" class='btn btn-primary'>Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="@if (!$customerUuid) 8 @else 7 @endif">Nenhuma venda registrada.</td>
                        </tr>
                    @endforelse
                </tbody>                
            </table>
            <h5 class="card-title float-right">Valor total: 
                <a class='btn btn-primary ml-2 disabled'>  R$ {{ $total }}</a>
            </h5>
        </div>
    </div>

    <div class='card mt-3'>
        <div class='card-body'>
            <h5 class="card-title mb-5">Produtos
                <a href="{{ route('product.create') }}" class='btn btn-secondary float-right btn-sm rounded-pill'><i class='fa fa-plus'></i>  Novo produto</a></h5>
            <table class='table'>
                <thead>
                    <tr>
                        <th scope="col">
                            Imagem
                        </th>
                        <th scope="col">
                            Nome
                        </th>
                        <th scope="col">
                            Valor
                        </th>
                        <th scope="col">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <img src="{{ $product->image_b64 }}" title="{{ $product->name }}" alt="{{ $product->name }}" 
                                    class="img-thumbnail rounded mx-auto d-block img-fluid" style="max-width: 200px;">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('product.edit', $product->uuid) }}" class='btn btn-primary'>Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum produto cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class='card mt-3'>
        <div class='card-body'>
            <h5 class="card-title mb-5">Clientes
                <a href="{{ route('customer.create') }}" class='btn btn-secondary float-right btn-sm rounded-pill'><i class='fa fa-plus'></i>  Novo cliente</a></h5>
            <table class='table'>
                <thead>
                    <tr>
                        <th scope="col">
                            Nome
                        </th>
                        <th scope="col">
                            E-mail
                        </th>
                        <th scope="col">
                            CPF
                        </th>
                        <th scope="col">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->cpf }}</td>
                            <td>
                                <a href="{{ route('customer.edit', $customer->uuid) }}" class='btn btn-primary'>Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Nenhum cliente cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
