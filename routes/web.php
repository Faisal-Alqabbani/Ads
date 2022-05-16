<?php
// composer require barryvdh/laravel-debugbar  --dev 

use App\Http\Controllers\AdsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SendMailController;
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

Route::get('/', [Adscontroller::class, 'getCommonAds']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('ads', AdsController::class);
Route::get('userAds', [AdsController::class, 'UserAds'])->name('userAds');
Route::get('{id}/{slug}', [AdsController::class, 'AdsByCategory'])->name('ads.category');
Route::post('/search', [AdsController::class, 'search']);
Route::post('ads/{id}/favorite', [FavoriteController::class, 'store'])->middleware('auth');; 
Route::get('userFav', [AdsController::class, 'userFavorite'])->middleware('auth');
Route::post('comments/store', [CommentController::class, 'store'])->name('comments.store');
Route::post('comments/reply', [CommentController::class, 'reply'])->name('comments.reply');
Route::post('/send', [SendMailController::class, 'sendMail']);