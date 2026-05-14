<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Product;
use App\Presenters\ProductPresenter;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    protected ProductPresenter $presenter;

    public function __construct(ProductPresenter $presenter)
    {
        $this->presenter = $presenter;
    }

    /**
     * Liste des produits + Dashboard
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'category_id']);
        $products = $this->presenter->getIndexData($filters);
        $categories = $this->presenter->getCategories();

        // Stats pour le Dashboard
        $stats = $this->presenter->getDashboardStats();

        return view('products.index', compact('products', 'categories', 'stats'));
    }

    public function create(): View
    {
        $categories = $this->presenter->getCategories();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image_path'] = $this->presenter->handleImageUpload($request->file('image'));
        }

        $this->presenter->saveProduct($validatedData);

        return redirect()->route('products.index')->with('success', 'Produit ajouté avec succès !');
    }

    public function edit(Product $product): View
    {
        $categories = $this->presenter->getCategories();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image_path'] = $this->presenter->handleImageUpload($request->file('image'));
        }

        $this->presenter->updateProduct($product, $validatedData);

        return redirect()->route('products.index')->with('success', 'Produit mis à jour !');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->presenter->deleteProduct($product);
        return redirect()->route('products.index')->with('success', 'Produit supprimé.');
    }
    public function downloadPDF()
    {
        // On augmente temporairement le temps d'exécution (au cas où)
        set_time_limit(120);

        // On récupère SEULEMENT les 100 derniers produits au lieu des 4500
        $products = Product::with('category')
            ->latest()
            ->limit(500)
            ->get();

        $stats = $this->presenter->getDashboardStats();

        $pdf = Pdf::loadView('products.pdf', compact('products', 'stats'));

        return $pdf->download('inventaire-produits.pdf');
    }
    /**
     * Affiche les détails d'un seul produit
     */
    public function show(Product $product): View
    {
        // Pas besoin de passer par le Presenter ici, on a juste besoin d'afficher l'objet récupéré
        return view('products.show', compact('product'));
    }
}
