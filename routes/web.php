<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
//商品一覧画面の表示
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
//商品登録画面の表示
Route::get('/productregister', [App\Http\Controllers\ProductsController::class, 'productregister'])->name('product.register');
//商品登録処理
Route::post('/productregister', [App\Http\Controllers\ProductsController::class,'store'])->name('products.store');
//商品の削除
Route::delete('/destroy/{product_id}', [App\Http\Controllers\ProductsController::class, 'destroy'])->name('destroy');
//詳細画面表示
Route::get('/show/{product_id}', [App\Http\Controllers\ProductsController::class, 'show'])->name('product.show');
//詳細編集画面表示
Route::get('/updateScreen/{product_id}', [App\Http\Controllers\ProductsController::class, 'edit'])->name('edit');
//商品情報の更新
Route::put('/updateScreen/{product_id}', [App\Http\Controllers\ProductsController::class, 'update'])->name('update');
//検索機能
Route::post('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
//ソート機能
Route::post('/sort', [App\Http\Controllers\HomeController::class, 'sort'])->name('sort');