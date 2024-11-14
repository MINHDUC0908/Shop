<?php

use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VariantController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\UserController;
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
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::post('edit/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [ProductController::class, 'destroy'])->name('destroy');
    Route::get('show/{id}', [ProductController::class, 'show'])->name('show');
});
Route::resource('variants', VariantController::class);
Route::group(['middleware' => ['guest']], function(){
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);  
});
Route::group(['middleware' => ['auth', 'role:Admin']], function () {
    Route::resource('user', UserController::class);
});
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('phan-vai-tro/{id}', [UserController::class, 'phanvaitro'])->name('phan-vai-tro');
Route::post('storeRole/{id}', [UserController::class, 'storeRole'])->name('storeRole');
Route::get('phan-quyen/{id}', [UserController::class, 'phanquyen'])->name('phan-quyen');
Route::post('storePermission/{id}', [UserController::class, 'storePermission'])->name('storePermission');
Route::get('add-role', [UserController::class, 'createRole'])->name('add-quyen');
Route::post('storeRoles', [UserController::class, 'storeRoles'])->name('storeRoles');
Route::get('add-permissions', [UserController::class, 'createPermission'])->name('add-permission');
Route::post('Permissions', [UserController::class, 'Permissions'])->name('Permission');