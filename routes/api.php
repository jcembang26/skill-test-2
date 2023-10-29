<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// products
Route::post('/products', [ProductController::class, 'store'])->name('products.store');