<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\ProductController;
use App\Http\Controllers\api\v1\ProductgroupController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(static function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::resource('categories', CategoryController::class)->only(['index', 'show']);
    Route::resource('productgroups', ProductgroupController::class)->only(['index', 'show']);
    Route::resource('products', ProductController::class)->only(['index', 'show']);
});

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::resource('categories', CategoryController::class)->only(['store', 'update']);
    Route::resource('productgroups', ProductgroupController::class)->only(['store', 'update']);

    Route::patch('products/{id}/set_category', [ProductController::class, 'set_category']);
    Route::patch('products/{id}/set_productgroup', [ProductController::class, 'set_productgroup']);
    Route::patch('products/{id}/remove_productgroup', [ProductController::class, 'remove_productgroup']);
    Route::patch('products/{id}/set_precios', [ProductController::class, 'set_precios']);
    Route::resource('products', ProductController::class)->only(['store', 'update']);
    

});
