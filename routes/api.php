<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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


Route::group(['prefix' => 'supplier'], function () {
    Route::get('/all', [SupplierController::class, 'getSuppliers']);
    Route::get('/{id}', [SupplierController::class, 'getSupplier'])->where(['id' => '[0-9]+']);
    Route::post('/crup/{id?}', [SupplierController::class, 'storeOrUpdate'])->where('id', '[0-9]*');;
    Route::delete('/delete/{id}', [SupplierController::class, 'destroy'])->where(['id' => '[0-9]+']);
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

