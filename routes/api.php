<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Routes cho Category
Route::get('/categories', [CategoryController::class, 'index'])->name('indexCategory');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('showCategory');

// Routes cho Brand
Route::get('/brands', [BrandController::class, 'index'])->name('indexBrand');
Route::get('/brands/{id}', [BrandController::class, 'show'])->name('showBrand');