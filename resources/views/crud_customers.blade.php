@extends('layout')

@section('title', isset($uuid) ? "Editar cliente - {$customer->name}" : 'Novo cliente')

@section('content')
<h1>Adicionar / Editar Cliente</h1>
<div class='card'>
    <div class='card-body'>
        @isset($uuid)
            <form action="{{ route('customer.destroy', $uuid) }}" method="POST">
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
            <div class="form-group">
                <label for="name">Nome do cliente</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                    value="{{ old('name') ?? $customer->name ?? '' }}" required>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $errors->first('name')  }}
                    </div>
                @enderror           
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                    value="{{ old('email') ?? $customer->email ?? '' }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $errors->first('email')  }}
                    </div>
                @enderror                        
            </div>
            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf" name="cpf" required 
                    value="{{ old('cpf') ?? $customer->cpf ?? '' }}" placeholder="999.999.999-99">
                @error('cpf')
                    <div class="invalid-feedback">
                        {{ $errors->first('cpf')  }}
                    </div>
                @enderror
            </div>
            <a href="{{ route('dashboard') }}" class='btn btn-primary'>Voltar</a>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>
@endsection