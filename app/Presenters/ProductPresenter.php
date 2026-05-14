<?php

namespace App\Presenters;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductPresenter
{
    /**
     * Prépare les données pour la liste des produits avec filtres
     */
    public function getIndexData(array $filters = []): LengthAwarePaginator
    {
        // On commence la requête en chargeant la relation
        $query = Product::with('category')->latest();

        // Si l'utilisateur a tapé une recherche
        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%')
                ->orWhere('description', 'like', '%' . $filters['search'] . '%');
        }

        // Si l'utilisateur a sélectionné une catégorie spécifique
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // withQueryString() est crucial : cela garde la recherche dans l'URL quand on change de page !
        return $query->paginate(10)->withQueryString();
    }

    /**
     * Récupère toutes les catégories pour le menu déroulant
     */
    public function getCategories(): Collection
    {
        return Category::orderBy('name')->get();
    }
    /**
     * Sauvegarde un nouveau produit dans la base de données
     */
    public function saveProduct(array $data): Product
    {
        // Par défaut, le produit est actif
        $data['is_active'] = $data['is_active'] ?? true;

        return Product::create($data);
    }
    /**
     * Met à jour un produit existant
     */
    public function updateProduct(Product $product, array $data): bool
    {
        return $product->update($data);
    }
    /**
     * Supprime un produit (Soft Delete)
     */
    public function deleteProduct(Product $product): bool
    {
        return $product->delete();
    }
    /**
     * Récupère les statistiques pour le tableau de bord
     */
    public function getDashboardStats(): array
    {
        return [
            'total_products' => Product::count(),
            'out_of_stock'   => Product::where('stock', 0)->count(),
            'total_value'    => Product::sum(\DB::raw('price * stock')),
            'avg_price'      => Product::avg('price') ?: 0,
        ];
    }
}
