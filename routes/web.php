<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryProductsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'showWelcomePage'])->name('welcome');
Route::get('authorization', [LoginController::class, 'authorization'])->name('authorization');
Route::get('products/{title}-{id}', [ProductsController::class, 'showProduct'])->name('products.show');
Route::get('categories/{title}-{id}/products', [CategoryProductsController::class, 'showProducts'])->name('categories.products.show');


Auth::routes(['register'=>false,'reset'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
