<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();


Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/product/list', 'index')->name('product-list');
    Route::get('/product/add', 'create')->name('product-create');
    Route::post('/product/save', 'save')->name('product-save');
    Route::get('/product/edit/{id}', 'edit')->name('product-edit');
    Route::get('/product/delete/{id}', 'destroy')->name('product-delete');
});

// Route::get('/product/list', [App\Http\Controllers\ProductController::class, 'index'])->name('product-list');
// Route::get('/product/add', [App\Http\Controllers\ProductController::class, 'create'])->name('product-create');
// Route::get('/product/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('product-edit');
// Route::get('/product/delete/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('product-delete');
// Route::post('/product/save', [App\Http\Controllers\ProductController::class, 'save'])->name('product-save');