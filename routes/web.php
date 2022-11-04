<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogTypesController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', function () {
        return view('welcome');
    });
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/blog-type', [BlogTypesController::class, 'index'])->name('blog-type');
    Route::post('/blog-types/store', [BlogTypesController::class, 'store'])->name('blog-type.store');
    Route::post('/blog-types/edit/{id}', [BlogTypesController::class, 'edit'])->name('blog-type.edit');
    Route::post('/blog-types/delete/{id}', [BlogTypesController::class, 'destroy'])->name('blog-type.delete');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog');
    Route::post('/blog/store', [BlogController::class, 'store'])->name('blog.store');
    Route::post('/blog/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::post('/blog/delete/{id}', [BlogController::class, 'destroy'])->name('blog.delete');
});


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
