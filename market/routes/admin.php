<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ParamController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductParentController;
use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', "middleware" => ['auth', IsAdminMiddleware::class]], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('params', controller: ParamController::class);
    Route::resource('categories', controller: CategoryController::class);
    // Route::get('product-parents', [ProductParentController::class, 'index'])->name('product_parents.index');
    Route::resource('product-parents', ProductParentController::class)->parameters(['product-parents' => 'productParents']);
});
