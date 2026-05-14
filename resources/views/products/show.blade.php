@extends('layouts.app')

@section('content')
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h2>Détails du produit : {{ $product->name }}</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour au catalogue
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="img-fluid rounded border shadow-sm" style="max-height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded border d-flex align-items-center justify-content-center h-100" style="min-height: 250px;">
                            <span class="text-muted"><i class="bi bi-image fs-1"></i><br>Aucune image</span>
                        </div>
                    @endif
                </div>

                <div class="col-md-8">
                    <h3 class="text-primary">{{ number_format($product->price, 2, ',', ' ') }} €</h3>

                    <div class="mt-4">
                        <p><strong>Catégorie :</strong> <span class="badge bg-secondary">{{ $product->category->name ?? 'Non classé' }}</span></p>

                        <p><strong>État du stock :</strong>
                            @if($product->stock == 0)
                                <span class="badge bg-danger fs-6">Rupture de stock</span>
                            @else
                                <span class="badge bg-success fs-6">{{ $product->stock }} unités en stock</span>
                            @endif
                        </p>

                        <p><strong>Ajouté le :</strong> {{ $product->created_at->format('d/m/Y à H:i') }}</p>
                        <p><strong>Dernière mise à jour :</strong> {{ $product->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>

                    <div class="mt-4">
                        <h5>Description</h5>
                        <div class="p-3 bg-light rounded border">
                            {!! nl2br(e($product->description)) ?: '<em class="text-muted">Aucune description fournie.</em>' !!}
                        </div>
                    </div>

                    <div class="mt-5 d-flex gap-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Modifier ce produit
                        </a>

                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
