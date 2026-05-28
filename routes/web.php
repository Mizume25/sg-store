<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductsImagesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->route('login');
});

/** Crear Vista de Home */
Route::get('/dashboard', [CatalogController::class, 'home'])->middleware(['auth', 'verified'])->name('dashboard');

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /** Apis */
    Route::get('categories/json', [CategoriesController::class, 'apiCategories'])->name('categories.json');

    /** Uso de resources para gestionar el CRUD completo de categories*/
    Route::resource('categories', CategoriesController::class);

    /** Uso de resources para gestionar el CRUD completo de productos */
    Route::resource('products', ProductsController::class);

    /** Gestion de Crud subalterno para las imagenes de productos */
    Route::get('products/{id}/images', [ProductsImagesController::class, 'edit'])->name('products.images.edit');

    Route::post('products/{id}/images', [ProductsImagesController::class, 'store'])->name('products.images.store');

    Route::delete('images/{imageId}', [ProductsImagesController::class, 'destroy'])->name('products.images.destroy');

    Route::post('products/{productId}/images/{id}', [ProductsImagesController::class, 'override'])->name('products.images.override');



});

require __DIR__.'/auth.php';
