<?php

use App\Http\Controllers\Dashboard\UrlController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\HomeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('/{code?}', [HomeController::class, 'showUrl'])->name('showUrl');
Route::group([
    'prefix' => '/dashboard',
    'namespace' => 'Dashboard',
    // 'middleware' => ['auth'],
], function () {
    Route::resource(
        'categories',
        'CategoriesController'
    );
    Route::resource(
        'urls',
        'UrlController'
    );
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
