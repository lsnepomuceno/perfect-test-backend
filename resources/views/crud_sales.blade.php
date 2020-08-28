@extends('layout')

@section('content')
    <h1>Adicionar / Editar Venda</h1>
    <div class='card'>
        <div class='card-body'>
            @isset($uuid)
                <form action="{{ route('sale.destroy', $uuid) }}" method="POST">
                    @csrf
                    @isset($uuid)
                        @method('DELETE')
                    @endisset
                    <button class='btn btn-danger ml-5 btn-delete float-right mb-3' type="submit">Deletar</button>
                </form>
            @endisset
            @if(session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form method="POST" action="{{ route($route, $uuid ?? '') }}" class="needs-validation" novalidate>
                @isset($uuid)
                    @method('PUT')
                @endisset
                @csrf
                <h5>Informações do cliente</h5>
                <h5>Selecione um cliente</h5>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Cliente</div>
                        </div>
                        <select class="form-control @error('customer') is-invalid @enderror" id="customer" name="customer">
                        <option selected disabled value="">Escolha...</option>
                        @forelse($customers as $customer)
                            <option value="{{ $customer->uuid }}"
                            @if(in_array($customer->uuid, [old('customer'), $sale->customer->uuid ?? ''])) selected @endif
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
                <h5>Ou cadastre um novo</h5>
                <div class="form-group">
                    <label for="name">Nome do cliente</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                        value="{{ old('name') ?? $sale->name ?? '' }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $errors->first('name')  }}
                        </div>
                    @enderror           
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                        value="{{ old('email') ?? $sale->email ?? '' }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $errors->first('email')  }}
                        </div>
                    @enderror                        
                </div>
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf" name="cpf" 
                        value="{{ old('cpf') ?? $sale->cpf ?? '' }}" placeholder="999.999.999-99">
                    @error('cpf')
                        <div class="invalid-feedback">
                            {{ $errors->first('cpf')  }}
                        </div>
                    @enderror
                </div>
                <h5 class='mt-5'>Informações da venda</h5>
                <div class="form-group">
                    <label for="product">Produto</label>
                    <select name="product" id="product" class="form-control @error('product') is-invalid @enderror" required>
                        <option selected disabled value="">Escolha...</option>
                        @forelse($products as $product)
                            <option value="{{ $product->uuid }}"
                            @if(in_array($product->uuid, [old('product'), $sale->product->uuid ?? ''])) selected @endif
                            >{{ $product->name }} - R$ {{ number_format($product->price, 2, ',', '.') }}</option>
                        @empty
                            <option selected disabled>Nenhum produto cadastrado</option>
                        @endforelse
                    </select>
                    @error('product')
                        <div class="invalid-feedback">
                            {{ $errors->first('product')  }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="sold_at">Data</label>
                    <input type="text" class="form-control single_date_picker @error('sold_at') is-invalid @enderror" 
                        name="sold_at" id="sold_at" value="{{ old('sold_at') ?? $sale->sold_at ?? '' }}" required>
                    @error('sold_at')
                        <div class="invalid-feedback">
                            {{ $errors->first('sold_at')  }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="quantity">Quantidade</label>
                    <input type="text" class="form-control @error('quantity') is-invalid @enderror" 
                        id="quantity" name="quantity" value="{{ old('quantity') ?? $sale->quantity ?? '' }}" placeholder="1 a 10" required>
                    @error('quantity')
                        <div class="invalid-feedback">
                            {{ $errors->first('quantity')  }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="discount">Desconto</label>
                    <input type="number" class="form-control @error('discount') is-invalid @enderror" 
                        id="discount" name="discount" value="{{ old('discount') ?? $sale->discount ?? '' }}" placeholder="100,00 ou menor">
                    @error('discount')
                        <div class="invalid-feedback">
                            {{ $errors->first('discount')  }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option selected disabled value="">Escolha...</option>
                        @forelse($status as $st)
                            <option value="{{ $st->uuid }}"
                            @if(in_array($st->uuid, [old('status'), $sale->status->uuid ?? ''])) selected @endif
                            >{{ $st->description }}</option>
                        @empty
                            <option selected disabled>Nenhum status cadastrado</option>
                        @endforelse
                    </select>
                    @error('status')
                        <div class="invalid-feedback">
                            {{ $errors->first('status')  }}
                        </div>
                    @enderror
                </div>
                <a href="{{ route('dashboard') }}" class='btn btn-primary'>Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
@endsection
