<?php

use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
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
Route::get('/', [DashboardController::class, 'dashboard'])->name('home');
Route::prefix('category')->name('category.')->group(function() {
    Route::get('/list', [CategoryController::class, 'index'])->name('list');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/create', [CategoryController::class, 'store'])->name('store');
    Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::post('edit/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
});
Route::prefix('brand')->name('brand.')->group(function() {
    Route::get('/list', [BrandController::class, 'index'])->name('list');
    Route::get('/create', [BrandController::class, 'create'])->name('create');
    Route::post('/create', [BrandController::class, 'store'])->name('store');
    Route::get('show/{id}', [BrandController::class, 'show'])->name('show');
    Route::get('edit/{id}', [BrandController::class, 'edit'])->name('edit');
    Route::put('edit/{id}', [BrandController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [BrandController::class, 'destroy'])->name('delete');
});
Route::prefix('product')->name('product.')->group(function(){
    Route::get('/list', [ProductController::class, 'index'])->name('list');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/create', [ProductController::class, 'store'])->name('store');
    Route::get('brands/{category_id}', [ProductController::class, 'getBrandsByCategory']);
});
