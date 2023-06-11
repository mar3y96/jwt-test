<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;

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

// user route 
Route::controller(AuthController::class)->prefix('user')->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::group(['middleware' => 'auth'], function () {
        Route::get('profile', 'profile');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });
});
//routes for auth users 
Route::group(['middleware' => 'auth'], function () {
    Route::apiResource('products',ProductController::class);
});