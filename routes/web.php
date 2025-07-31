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
use App\Http\Controllers\OtherController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check()
        ? redirect('/dashboard')
        : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource controllers
    Route::resource('brand', BrandController::class);
    Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');

    Route::resource('category', CategoryController::class);
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    
    Route::resource('size', SizeController::class);
    Route::post('/size/store', [SizeController::class, 'store'])->name('size.store');

    Route::resource('color', ColorController::class);
    Route::post('/color/store', [ColorController::class, 'store'])->name('color.store');

    Route::resource('product', ProductController::class);
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

    Route::resource('order', OrderController::class);
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::get('/orders/{order}/details', [OrderController::class, 'getDetails']);

    Route::resource('product_detail', ProductDetailController::class);
    Route::post('/product_detail/store', [ProductDetailController::class, 'store'])->name('product_detail.store');

    Route::resource('order-detail', OrderDetailController::class);

    Route::resource('power', PowerController::class);
    Route::post('/power/store', [PowerController::class, 'store'])->name('power.store');

    Route::resource('other', OtherController::class);
    Route::post('/other/store', [OtherController::class, 'store'])->name('other.store');


});

require __DIR__.'/auth.php';
