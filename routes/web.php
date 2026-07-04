<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductsImagesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->route('login');
});

/** Crear Vista de Home */
Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    

    /** Exportacion Excel */
    Route::get('/products/export', [ProductsController::class, 'export'])->name('products.export');

    /** Exportacion PDF */
    Route::get('/products/{id}/pdf', [ProductsController::class, 'pdf'])->name('products.pdf');

    /** CRUD de categorias */
    Route::resource('categories', CategoriesController::class);

     /** CRUD de productos */
    Route::resource('products', ProductsController::class);

     /** Ruta de ordenes */
    Route::resource('orders', OrderController::class);
    

    
    /** Gestionar categorias de un producto */
    Route::get('products/{id}/categories', [ProductCategoryController::class, 'edit'])->name('products.categories.edit');
    Route::post('products/{id}/categories', [ProductCategoryController::class, 'update'])->name('products.categories.update');

    /** Gestion de Crud subalterno para las imagenes de productos */
    Route::get('products/{id}/images', [ProductsImagesController::class, 'edit'])->name('products.images.edit');
    Route::post('products/{id}/images', [ProductsImagesController::class, 'store'])->name('products.images.store');

    Route::delete('images/{imageId}', [ProductsImagesController::class, 'destroy'])->name('products.images.destroy');
    
    Route::post('products/{productId}/images/{id}', [ProductsImagesController::class, 'override'])->name('products.images.override');

    


});

require __DIR__.'/auth.php';
