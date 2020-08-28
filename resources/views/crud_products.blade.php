@extends('layout')

@section('title', isset($uuid) ? "Editar produto - {$product->name}" : 'Novo produto')

@section('content')
<h1>Adicionar / Editar Produto</h1>
<div class='card'>
    <div class='card-body'>
        @isset($uuid)
            <form action="{{ route('product.destroy', $uuid) }}" method="POST">
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
        <form method="POST" action="{{ route($route, $uuid ?? '') }}" class="needs-validation" novalidate enctype="multipart/form-data">
            @isset($uuid)
                @method('PUT')
            @endisset
            @csrf
            <div class="form-group">
                @if(isset($uuid) && $product->image)
                    <img id="productThumb" src="{{ $product->image_b64 }}" title="{{ $product->name }}" alt="{{ $product->name }}" 
                        class="img-thumbnail rounded mx-auto d-block img-fluid" style="max-width: 100%px;">
                @else
                <img id="productThumb" class="img-thumbnail rounded mx-auto d-block img-fluid" style="max-width: 100%px;">
                @endif
            </div>
            <div class="form-group mb-4">
                <label for="name">Imagem do produto</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" 
                        id="image" name="image" accept=".png, .jpeg, .jpg, .bpm, .gif" >
                    <label class="custom-file-label" for="image">Selecionar Arquivo</label>
                </div>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $errors->first('name')  }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="name">Nome do produto</label>
                <input type="text" autofocus value="{{ old('name') ?? $product->name ?? '' }}" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $errors->first('name')  }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea type="text" rows='5' class="form-control @error('description') is-invalid @enderror" 
                    id="description" name="description" required>{{ old('description') ?? $product->description ?? '' }}</textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $errors->first('description')  }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">Preço</label>
                <input type="tel" value="{{ old('price') ?? $product->price ?? '' }}" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="100,00 ou maior" required>
                @error('price')
                    <div class="invalid-feedback">
                        {{ $errors->first('price')  }}
                    </div>
                @enderror
            </div>
            <a href="{{ route('dashboard') }}" class='btn btn-primary'>Voltar</a>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>
@endsection