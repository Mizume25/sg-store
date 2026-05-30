<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ApiController::class, 'products']);

Route::get('/products/{id}', [ApiController::class, 'product']);

Route::get('/categories', [ApiController::class, 'categories']);

Route::get('/orders', [ApiController::class, 'orders']);


?>