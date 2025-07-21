<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\PowerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource controllers
    Route::resource('brand', BrandController::class);
    Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');

    Route::resource('category', CategoryController::class);
    Route::resource('size', SizeController::class);
    Route::resource('color', ColorController::class);
    Route::resource('product', ProductController::class);
    Route::resource('order', OrderController::class);
    Route::resource('product-detail', ProductDetailController::class);
    Route::resource('order-detail', OrderDetailController::class);
    Route::resource('power', PowerController::class);

});

require __DIR__.'/auth.php';
