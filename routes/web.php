<?php

use App\Http\Controllers\Dashboard\UrlController;
use App\Http\Controllers\Dashboard\CategoriesController;

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

Route::get('/{code?}', [UrlController::class, 'showUrl'])->name('showUrl');

Route::group([
    'prefix' => '/dashboard',
    'namespace' => 'Dashboard',
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
