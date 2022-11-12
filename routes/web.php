<?php

use App\Http\Controllers\BlogAuthorController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogPageController;
use App\Http\Controllers\BlogTypesController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryToLookController;
use App\Http\Controllers\HowItWorksController;
use App\Http\Controllers\InHouseServiceController;
use App\Http\Controllers\MainBannerController;
use App\Http\Controllers\MiddleBannerController;
use App\Http\Controllers\PopularVanuesController;
use App\Http\Controllers\RealWeddingAuthorController;
use App\Http\Controllers\RealWeddingCategoriesController;
use App\Http\Controllers\RealWeddingPageController;
use App\Http\Controllers\RealWeddingPostController;
use App\Http\Controllers\RealWeddingStorieseController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WeddingCategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    //home page main banner routes
    Route::get('main-banner', [MainBannerController::class, 'index'])->name('main-banner');
    Route::post('main-banner/store', [MainBannerController::class, 'store'])->name('main-banner.store');
    Route::post('main-banner/edit/{id}', [MainBannerController::class, 'edit'])->name('main-banner.edit');
    Route::post('main-banner/delete/{id}', [MainBannerController::class, 'destroy'])->name('main-banner.delete');

    //home page how it works routes
    Route::get('how-it-works', [HowItWorksController::class, 'index'])->name('how-it-works');
    Route::post('how-it-works/store', [HowItWorksController::class, 'store'])->name('how-it-works.store');
    Route::post('how-it-works/edit/{id}', [HowItWorksController::class, 'edit'])->name('how-it-works.edit');
    Route::post('how-it-works/delete/{id}', [HowItWorksController::class, 'destroy'])->name('how-it-works.delete');

    //home page popular vanues routes
    Route::get('popular-vanues', [PopularVanuesController::class, 'index'])->name('popular-vanues');
    Route::post('popular-vanues/store', [PopularVanuesController::class, 'store'])->name('popular-vanues.store');
    Route::post('popular-vanues/edit/{id}', [PopularVanuesController::class, 'edit'])->name('popular-vanues.edit');
    Route::post('popular-vanues/delete/{id}', [PopularVanuesController::class, 'destroy'])->name('popular-vanues.delete');

    //Wedding category
    Route::get('/Wedding-category', [WeddingCategoryController::class, 'index'])->name('Wedding-category');
    Route::post('/Wedding-category/store', [WeddingCategoryController::class, 'store'])->name('Wedding-category.store');
    Route::post('/Wedding-category/edit/{id}', [WeddingCategoryController::class, 'edit'])->name('Wedding-category.edit');
    Route::post('/Wedding-category/delete/{id}', [WeddingCategoryController::class, 'destroy'])->name('Wedding-category.delete');

    //inhouse services
    Route::get('/inhouse-service', [InHouseServiceController::class, 'index'])->name('inhouse-service');
    Route::post('/inhouse-service/store', [InHouseServiceController::class, 'store'])->name('inhouse-service.store');
    Route::post('/inhouse-service/edit/{id}', [InHouseServiceController::class, 'edit'])->name('inhouse-service.edit');
    Route::post('/inhouse-service/delete/{id}', [InHouseServiceController::class, 'destroy'])->name('inhouse-service.delete');

    //real Wedding section
    Route::get('/real-wedding', [RealWeddingStorieseController::class, 'index'])->name('real-wedding');
    Route::post('/real-wedding/store', [RealWeddingStorieseController::class, 'store'])->name('real-wedding.store');
    Route::post('/real-wedding/edit/{id}', [RealWeddingStorieseController::class, 'edit'])->name('real-wedding.edit');
    Route::post('/real-wedding/delete/{id}', [RealWeddingStorieseController::class, 'destroy'])->name('real-wedding.delete');

    //Gallery to look section
    Route::get('/gallery-to-look', [GalleryToLookController::class, 'index'])->name('gallery-to-look');
    Route::post('/gallery-to-look/store', [GalleryToLookController::class, 'store'])->name('gallery-to-look.store');
    Route::post('/gallery-to-look/edit/{id}', [GalleryToLookController::class, 'edit'])->name('gallery-to-look.edit');
    Route::post('/gallery-to-look/delete/{id}', [GalleryToLookController::class, 'destroy'])->name('gallery-to-look.delete');

    //middle banner section
    Route::get('/middle-banner', [MiddleBannerController::class, 'index'])->name('middle-banner');
    Route::post('/middle-banner/store', [MiddleBannerController::class, 'store'])->name('middle-banner.store');
    Route::post('/middle-banner/edit/{id}', [MiddleBannerController::class, 'edit'])->name('middle-banner.edit');
    Route::post('/middle-banner/delete/{id}', [MiddleBannerController::class, 'destroy'])->name('middle-banner.delete');

    //blog page routes
    Route::get('blog-page', [BlogPageController::class, 'index'])->name('blog-page');
    Route::post('blog-page/store', [BlogPageController::class, 'store'])->name('blog-page.store');

    //blog routes
    Route::get('/blog', [BlogController::class, 'index'])->name('blog');
    Route::get('/blog/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::post('/blog/delete/{id}', [BlogController::class, 'destroy'])->name('blog.delete');
    Route::get('/blog/validation', [BlogController::class, 'validation'])->name('blog.validation');
    Route::post('/blog/get-slug', [BlogController::class, 'slugGenerator'])->name('blog.get-slug');
    Route::get('blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('blog/save', [BlogController::class, 'save'])->name('blog.save');

    //blog author route
    Route::get('/blog-author', [BlogAuthorController::class, 'index'])->name('blog-author');
    Route::post('/blog-author/store', [BlogAuthorController::class, 'store'])->name('blog-author.store');
    Route::post('/blog-author/edit/{id}', [BlogAuthorController::class, 'edit'])->name('blog-author.edit');
    Route::post('/blog-author/delete/{id}', [BlogAuthorController::class, 'destroy'])->name('blog-author.delete');

    //blog types/category routes
    Route::get('/blog-type', [BlogTypesController::class, 'index'])->name('blog-type');
    Route::post('/blog-types/store', [BlogTypesController::class, 'store'])->name('blog-type.store');
    Route::post('/blog-types/edit/{id}', [BlogTypesController::class, 'edit'])->name('blog-type.edit');
    Route::post('/blog-types/delete/{id}', [BlogTypesController::class, 'destroy'])->name('blog-type.delete');

    //Real Wedding routes
    Route::get('real-wedding', [RealWeddingPostController::class, 'index'])->name('real-wedding');
    Route::get('real-wedding/edit/{id}', [RealWeddingPostController::class, 'edit'])->name('real-wedding.edit');
    Route::post('real-wedding/delete/{id}', [RealWeddingPostController::class, 'destroy'])->name('real-wedding.delete');
    Route::get('real-wedding/validation', [RealWeddingPostController::class, 'validation'])->name('real-wedding.validation');
    Route::post('real-wedding/get-slug', [RealWeddingPostController::class, 'slugGenerator'])->name('real-wedding.get-slug');
    Route::get('real-wedding/create', [RealWeddingPostController::class, 'create'])->name('real-wedding.create');
    Route::post('real-wedding/save', [RealWeddingPostController::class, 'save'])->name('real-wedding.save');

    //Real Wedding author route
    Route::get('/real-wedding-author', [RealWeddingAuthorController::class, 'index'])->name('real-wedding-author');
    Route::post('/real-wedding-author/store', [RealWeddingAuthorController::class, 'store'])->name('real-wedding-author.store');
    Route::post('/real-wedding-author/edit/{id}', [RealWeddingAuthorController::class, 'edit'])->name('real-wedding-author.edit');
    Route::post('/real-wedding-author/delete/{id}', [RealWeddingAuthorController::class, 'destroy'])->name('real-wedding-author.delete');

    //Real Wedding types/category routes
    Route::get('real-wedding-types', [RealWeddingCategoriesController::class, 'index'])->name('real-wedding-category');
    Route::post('real-wedding-types/store', [RealWeddingCategoriesController::class, 'store'])->name('real-wedding-category.store');
    Route::post('real-wedding-types/edit/{id}', [RealWeddingCategoriesController::class, 'edit'])->name('real-wedding-category.edit');
    Route::post('real-wedding-types/delete/{id}', [RealWeddingCategoriesController::class, 'destroy'])->name('real-wedding-category.delete');

    //blog page routes
    Route::get('real-wedding-page', [RealWeddingPageController::class, 'index'])->name('real-wedding-page');
    Route::post('real-wedding-page/store', [RealWeddingPageController::class, 'store'])->name('real-wedding-page.store');

    //city route
    Route::get('/city', [CityController::class, 'index'])->name('city');
    Route::post('/city/store', [CityController::class, 'store'])->name('city.store');
    Route::post('/city/edit/{id}', [CityController::class, 'edit'])->name('city.edit');
    Route::post('/city/delete/{id}', [CityController::class, 'destroy'])->name('city.delete');

    //city route
    Route::get('/vendors', [VendorController::class, 'index'])->name('vendor');
    Route::post('/vendors/store', [VendorController::class, 'store'])->name('vendor.store');
    Route::post('/vendors/edit/{id}', [VendorController::class, 'edit'])->name('vendor.edit');
    Route::post('/vendors/delete/{id}', [VendorController::class, 'destroy'])->name('vendor.delete');
});


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
