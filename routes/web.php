<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DSRController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    //DSR route
    Route::get('/dsr', [DSRController::class, 'index'])->name('dsr');
    Route::post('/dsr/store', [DSRController::class, 'store'])->name('dsr.store');
    Route::post('/dsr/edit/{id}', [DSRController::class, 'edit'])->name('dsr.edit');
    Route::post('/dsr/delete/{id}', [DSRController::class, 'destroy'])->name('dsr.delete');

    //Market route
    Route::get('/market', [MarketController::class, 'index'])->name('market');
    Route::post('/market/store', [MarketController::class, 'store'])->name('market.store');
    Route::post('/market/edit/{id}', [MarketController::class, 'edit'])->name('market.edit');
    Route::post('/market/delete/{id}', [MarketController::class, 'destroy'])->name('market.delete');

    //Market route
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::post('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');
    //Sales route
    Route::get('/sales', [SalesController::class, 'index'])->name('sales');
    Route::get('/sales/create', [SalesController::class, 'create'])->name('sales.create');
    Route::post('/sales/store', [SalesController::class, 'store'])->name('sales.store');
    Route::post('/sales/edit/{id}', [SalesController::class, 'edit'])->name('sales.edit');
    Route::post('/sales/delete/{id}', [SalesController::class, 'destroy'])->name('sales.delete');
});


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


Route::get('run-artisan', function () {
    $command = $_GET["command"];
    if (isset($command)) {
        Artisan::call($command);
        return redirect()->back();
    } else {
        return redirect()->back();
    }
});
