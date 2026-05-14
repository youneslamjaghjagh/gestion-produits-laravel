@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Catalogue des Produits</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('products.pdf') }}" class="btn btn-outline-danger">
                <i class="bi bi-file-pdf"></i> Exporter en PDF
            </a>
            <a href="{{ route('products.create') }}" class="btn btn-primary">+ Ajouter un produit</a>
        </div>
    </div>

    <form method="GET" action="{{ route('products.index') }}" class="row g-3 mb-4">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Rechercher par nom ou description..." value="{{ request('search') }}">
        </div>

        <div class="col-md-4">
            <select name="category_id" class="form-select">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-secondary w-100">Filtrer</button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-danger">X</a>
        </div>
    </form>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Total Produits</h6>
                    <h3>{{ $stats['total_products'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">En Rupture</h6>
                    <h3>{{ $stats['out_of_stock'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Valeur Stock</h6>
                    <h3>{{ number_format($stats['total_value'], 2, ',', ' ') }} €</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Prix Moyen</h6>
                    <h3>{{ number_format($stats['avg_price'], 2, ',', ' ') }} €</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th>Aperçu</th><th>#</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr class="{{ $product->stock == 0 ? 'table-danger' : '' }}">
                        <td>
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="Photo"
                                     style="width: 45px; height: 45px; object-fit: cover;" class="rounded border shadow-sm">
                            @else
                                <div class="bg-light rounded border d-flex align-items-center justify-content-center"
                                     style="width: 45px; height: 45px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'Sans catégorie' }}</td>
                        <td>{{ number_format($product->price, 2, ',', ' ') }} €</td>
                        <td>
                            @if($product->stock == 0)
                                <span class="badge bg-danger">Rupture</span>
                            @else
                                {{ $product->stock }}
                            @endif
                        </td>
                        <td>{{ $product->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-secondary">Voir</a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            Aucun produit ne correspond à votre recherche.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
