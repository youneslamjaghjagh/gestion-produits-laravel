@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <h2>Modifier le produit : {{ $product->name }}</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nom du produit</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Catégorie</label>
                        <select class="form-select" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Prix (€)</label>
                        <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', $product->price) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Stock</label>
                        <input type="number" class="form-control" name="stock" value="{{ old('stock', $product->stock) }}" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Mettre à jour</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection
