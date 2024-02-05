<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/**
 * Route for authentication
 */
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

/**
 * Public routes
 */
Route::group(['prefix' => 'user'], function () {
    Route::get('/all', [UserController::class, 'getUsers']);
    Route::get('/{id}', [UserController::class, 'getUser'])->where(['id' => '[0-9]+']);
    Route::post('/crup/{id?}', [UserController::class, 'storeOrUpdate'])->where('id', '[0-9]*');;
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->where(['id' => '[0-9]+']);
});

/**
 * Authenticated routes
 */
Route::group(['middleware' => 'auth:api'], function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);

    // Admin routes
    Route::group(['middleware' => 'role:admin'], function () {
        Route::get('/admin', function () {
            return ["hello" => "admin"];
        });
    });

    // User routes
    Route::group(['middleware' => 'role:user'], function () {
        Route::get('/other', function () {
            return ["hello" => "user"];
        });
    });
});

