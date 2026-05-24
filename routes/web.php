<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/',[AuthenticatedSessionController::class, 'create'])->name('auth.login');

/** Crear Vista de Home */
Route::get('/home', [CatalogController::class, 'home'])->middleware(['auth', 'verified'])->name('home');

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /** Uso de resources para gestionar el CRUD completo de categories*/
    Route::resource('categories', CategoriesController::class);


});

require __DIR__.'/auth.php';
