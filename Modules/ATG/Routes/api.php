<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\ATG\Http\Controllers\ItemController;

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

Route::middleware('auth:api')->get('/atg', function (Request $request) {
    return $request->user();
});

Route::prefix('items')
    ->name('items.')
    //->middleware(['auth:sanctum'])
    ->controller(ItemController::class)
    ->group(function () {
        Route::get('/', 'index')
            //->middleware('can:viewAny,'.City::class) Middleware is not using here
            ->name('index');
    });

Route::prefix('orders')
    ->name('orders.')
    //->middleware(['auth:sanctum'])
    ->controller(\Modules\ATG\Http\Controllers\OrderController::class)
    ->group(function () {
        Route::post('/', 'store')
            //->middleware('can:viewAny,'.City::class) Middleware is not using here
            ->name('create');
    });
