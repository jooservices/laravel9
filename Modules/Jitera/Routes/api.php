<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Jitera\Http\Controllers\UserController;

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

Route::middleware('auth:api')->get('/jitera', function (Request $request) {
    return $request->user();
});

Route::prefix('v1/users')
    ->name('jitera.users.')

    ->controller(UserController::class)
    ->group(function () {
        Route::post('/{user}', 'show')->name('show');
        Route::post('/{user}/follow', 'follow')->name('follow');
        Route::post('/{user}/unfollow', 'unfollow')->name('unfollow');
        Route::get('/{user}/followings', 'follows')->name('follows');
        Route::get('/{user}/followers', 'followers')->name('followers');
    });
