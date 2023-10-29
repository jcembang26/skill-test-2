<?php

use App\Http\Controllers\PageSlotController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\WidgetProductController;
use App\Http\Controllers\WidgetSettingsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', function () {
    return Inertia::render('Products');
})->middleware(['auth', 'verified'])->name('products');

Route::get('/products-details/{id}', function () {
    return Inertia::render('ProductDetails');
})->middleware(['auth', 'verified'])->name('product-details');

Route::get('/widgets', function () {
    return Inertia::render('Widgets');
})->middleware(['auth', 'verified'])->name('widgets');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // products
    Route::get('/get-products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/upsert', [ProductController::class, 'upsert'])->name('product.upsert');
    Route::get('/edit-product/{id}', [ProductController::class, 'edit'])->name('product.edit');

    // widget
    Route::get('/get-widgets', [WidgetController::class, 'index']);
    Route::get('/handle-widgets', [WidgetController::class, 'handleWidgets']);
    Route::get('/count-widget-product', [WidgetProductController::class, 'countProduct']);
    
    // widget settings
    Route::get('/get-widget-setting', [WidgetSettingsController::class, 'index']);
    Route::post('/upsert-widget-setting', [WidgetSettingsController::class, 'upsert']);

    //page slot
    Route::get('/get-slots', [PageSlotController::class, 'index']);
});

require __DIR__.'/auth.php';
