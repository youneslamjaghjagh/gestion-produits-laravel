<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\ProductController;

// Route pour afficher la liste des produits
Route::get('/products', [ProductController::class, 'index'])->name('products.index');


Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Nouvelles routes pour l'ajout
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
// Afficher le formulaire avec les données actuelles
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

// Enregistrer les modifications (on utilise PUT ou PATCH)
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');




// <-- CETTE LIGNE EST SUREMENT MANQUANTE

Route::get('/', function () {
    return redirect()->route('products.index');
});

// Vos routes existantes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
// Afficher les détails d'un produit spécifique
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
// Route pour supprimer un produit
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/download-pdf', [ProductController::class, 'downloadPDF'])->name('products.pdf');
