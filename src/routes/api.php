<?php

use Illuminate\Http\Request;

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

/**
 * Admin
 */

Route::prefix('/admin')->group(function () {
    Route::post('/login/', 'Admin\\Auth\\LoginController@login');

    Route::group([
        'prefix' => 'forms'
    ], function ($router) {
        Route::put('', 'Admin\\FormController@createForm')->name('forms.create');
    });
});

Route::middleware('auth:api')->prefix('/admin')->group(function () {
    Route::post('/logout', 'Admin\\Auth\\LoginController@logout');
});


/**
 * Web
 */

Route::prefix('/web')->group(function () {
    Route::post('/login/', 'Web\\Auth\\LoginController@login');
});

Route::middleware('auth:api')->prefix('/web')->group(function () {
    Route::post('/logout', 'Web\\Auth\\LoginController@logout');
});
