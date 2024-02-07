<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

/**
 * Routes pour l'authentification
 */
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

/**
 * Routes publiques
 */
Route::prefix('user')->group(function () {
    Route::get('/all', [UserController::class, 'getUsers']);
    Route::get('/{id}', [UserController::class, 'getUser'])->where(['id' => '[0-9]+']);
    Route::post('/crup/{id?}', [UserController::class, 'storeOrUpdate'])->where('id', '[0-9]*');;
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->where(['id' => '[0-9]+']);
});

Route::prefix('supplier')->group(function () {
    Route::get('/all', [SupplierController::class, 'getSuppliers']);
    Route::get('/{id}', [SupplierController::class, 'getSupplier'])->where(['id' => '[0-9]+']);
    Route::post('/crup/{id?}', [SupplierController::class, 'storeOrUpdateSupplier'])->where('id', '[0-9]*');;
    Route::delete('/delete/{id}', [SupplierController::class, 'destroy'])->where(['id' => '[0-9]+']);
});

Route::prefix('articles')->group(function () {
    Route::get('/', [ArticleController::class, 'getArticles']);
    Route::get('/category', [ArticleController::class, 'getArticlesWithCategory']);
});

/**
 * Authenticated routes
 */
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
});

