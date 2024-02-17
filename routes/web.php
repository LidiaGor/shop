<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsGroupsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::redirect('/login', '/');
Route::post('/special-offers', [HomePageController::class, 'getSpecialOffers'])->name('home.special-offers');

Route::any('search', [ProductController::class, 'search'])->name('search.product');

Route::get('product--{product_slug}', [ProductController::class, 'show'])->name('product.show');

Route::post('group--{group_slug}/load', [ProductsGroupsController::class, 'loadMoreProducts'])
    ->name('products-groups.load');

Route::any('catalog/group--{group_slug}', [ProductsGroupsController::class, 'show'])
    ->name('products-groups.show');

Route::post('header-menu-groups', [ProductsGroupsController::class, 'headerMenuGroups'])
    ->name('products-groups.groups-menu-header');

Route::middleware('auth')->group(function () {
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart', [CartController::class, 'update'])->name('cart.update');
    Route::delete('cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('favorites', [FavoriteController::class, 'update'])->name('favorites.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';

