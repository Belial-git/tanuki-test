<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function (): void {
    Route::get('/', App\Http\Controllers\Api\V1\Product\AllController::class)
        ->name('all');
    Route::get('/{id}', App\Http\Controllers\Api\V1\Product\ByIdController::class)
        ->name('product');
    Route::post('/', App\Http\Controllers\Api\V1\Product\CreateController::class)
        ->name('createProduct');
    Route::patch('/{id}', App\Http\Controllers\Api\V1\Product\UpdateController::class)
        ->name('updateProduct');
    Route::delete('/{id}', App\Http\Controllers\Api\V1\Product\DeleteController::class)
        ->name('deleteProduct');
});

Route::prefix('baskets')->group(function (): void {
    Route::get('/', App\Http\Controllers\Api\V1\Basket\GetController::class)
        ->name('basket');
    Route::post('/', App\Http\Controllers\Api\V1\Basket\CreateController::class)
        ->name('createBasket');
    Route::patch('/{id}', App\Http\Controllers\Api\V1\Basket\UpdateController::class)
        ->name('updateBasket');
    Route::delete('/{id}', App\Http\Controllers\Api\V1\Basket\DeleteController::class)
        ->name('deleteBasket');
});

Route::prefix('orders')->group(function (): void {
    Route::get('/', App\Http\Controllers\Api\V1\Order\GetController::class)
        ->name('order');
    Route::post('/', App\Http\Controllers\Api\V1\Order\CreateController::class)
        ->name('createOrder');
    Route::delete('/{id}', App\Http\Controllers\Api\V1\Order\DeleteController::class)
        ->name('deleteBasket');
});
