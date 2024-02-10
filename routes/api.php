<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryWithArticleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeliveryController;
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
    Route::post('/crup/{id?}', [UserController::class, 'storeOrUpdateUser'])->where('id', '[0-9]*');;
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->where(['id' => '[0-9]+']);
});


Route::prefix('supplier')->group(function () {
    Route::get('/all', [SupplierController::class, 'getSuppliers']);
    Route::get('/{id}', [SupplierController::class, 'getSupplier'])->where(['id' => '[0-9]+']);
    Route::post('/crup/{id?}', [SupplierController::class, 'storeOrUpdateSupplier'])->where('id', '[0-9]*');;
    Route::delete('/delete/{id}', [SupplierController::class, 'destroy'])->where(['id' => '[0-9]+']);
});

Route::prefix('category')->group(function () {
    Route::get('/all', [CategoryController::class, 'getCategories']);
    Route::get('/article', [CategoryWithArticleController::class, 'categoryWithArticle']);
    Route::get('/article/{id}', [CategoryWithArticleController::class, 'categoryWithArticleById']);
    Route::get('/{id}', [CategoryController::class, 'getCategory'])->where(['id' => '[0-9]+']);
    Route::post('/crup/{id?}', [CategoryController::class, 'storeOrUpdateCategory'])->where('id', '[0-9]*');
    Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->where(['id' => '[0-9]+']);
});

Route::prefix('article')->group(function () {
    Route::get('/all', [ArticleController::class, 'getArticles']);
    Route::get('/{id}', [ArticleController::class, 'getArticle']);
    Route::post('/crup/{id?}', [ArticleController::class, 'storeOrUpdateArticle'])->where('id', '[0-9]*');
    Route::delete('/delete/{id}', [ArticleController::class, 'destroy'])->where(['id' => '[0-9]+']);
});

Route::prefix('customer')->group(function () {
    Route::get('/all', [CustomerController::class, 'getCustomers']);
    Route::get('/{id}', [CustomerController::class, 'getCustomer']);
    Route::post('/crup/{id?}', [CustomerController::class, 'storeOrUpdateCustomer'])->where('id', '[0-9]*');
    Route::delete('/delete/{id}', [CustomerController::class, 'destroy'])->where(['id' => '[0-9]+']);
});




Route::prefix('delivery')->group(function () {
    Route::get('/all', [DeliveryController::class, 'getDeliveries']);
    Route::get('/{id}', [DeliveryController::class, 'getDelivery']);
    Route::post('/crup/{id?}', [DeliveryController::class, 'storeOrUpdateDelivery'])->where('id', '[0-9]*');
    Route::delete('/delete/{id}', [DeliveryController::class, 'destroy'])->where(['id' => '[0-9]+']);
});



/**
 * Authenticated routes
 */
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
});

