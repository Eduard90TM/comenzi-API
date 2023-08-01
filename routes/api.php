<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Products

// varianta 1
// Route::get('/products', [ProductController::class, 'index']); /// reprezinta ruta de getALL

// avand in vedere ca avem o structura standard putem folosi apiResource, si vor fi generate toate rutele automat
Route::apiResource('/products', ProductController::class);
Route::apiResource('/orders', OrderController::class);

Route::prefix('cart')->group(function () {
    Route::post('add', [CartController::class, 'addToCart']);
    Route::put('update/{id}', [CartController::class, 'updateCartItem']);
    Route::delete('remove/{id}', [CartController::class, 'removeFromCart']);
    Route::get('user/{user_id}', [CartController::class, 'getUserCart']);
});
Route::put('profile/{id}', [UserController::class, 'updateProfile']);
