<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShoppingcartController;
use App\Http\Controllers\CreditCardController;

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

Route::get('/', [WebController::class, 'index'])->name('home');

Auth::routes(['verify' => true]);

// 確認用メール再送信
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::controller(UserController::class)->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('mypage', 'mypage')->name('mypage');
        Route::get('mypage/edit', 'edit')->name('mypage.edit');
        Route::patch('mypage/update', 'update')->name('mypage.update');
        Route::get('mypage/edit_password', 'edit_password')->name('mypage.edit_password');
        Route::patch('mypage/update_password', 'update_password')->name('mypage.update_password');
        Route::get('mypage/favorite', 'favorite')->name('mypage.favorite');
        Route::get('mypage/orders', 'orders')->name('mypage.orders');
        Route::get('mypage/show_order/{order_code}', 'show_order')->name('mypage.show_order');
        Route::patch('mypage/deleted', 'deleted')->name('mypage.deleted');
    });

Route::controller(ProductController::class)->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('products', 'index')->name('products.index');
        Route::get('products/create', 'create')->name('products.create');
        Route::post('products/store', 'store')->name('products.store');
        Route::get('products/{product}', 'show')->name('products.show');
        Route::get('products/{product}/edit', 'edit')->name('products.edit');
        Route::patch('products/{product}/update', 'update')->name('products.update');
        Route::delete('products/{product}/destroy', 'destroy')->name('products.destroy');
        Route::get('products/{product}/toggle_favorite', 'toggle_favorite')->name('products.toggle_favorite');
    });

Route::post('reviews/store', [ReviewController::class, 'store'])
    ->name('reviews.store')
    ->middleware(['auth', 'verified']);

Route::controller(ShoppingcartController::class)->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('shoppingcarts', 'index')->name('shoppingcarts.index');
        Route::post('shoppingcarts/store', 'store')->name('shoppingcarts.store');
        Route::post('shoppingcarts/buy', 'buy')->name('shoppingcarts.buy');
    });

Route::controller(CreditCardController::class)->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('credit_card', 'index')->name('credit_card.index');
        Route::post('credit_card/store', 'store')->name('credit_card.store');
        Route::delete('credit_card/{credit}/destroy', 'destroy')->name('credit_card.destroy');
    });

