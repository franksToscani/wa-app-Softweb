<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryTypeController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\MediaApiController;


/**
 *  middleware per protegere le route api gradite via laravel sanctum
 */

Route::middleware('auth:sanctum')->group(function () {

    // Tutte le rotte qui sotto richiedono l'header Bearer Token
    // token: 2|0EuWmCBSJxB0odzvOIXd9oB7eIauNLzujfCX79wr57674e52

// Posts API
Route::get('/posts', [PostApiController::class, 'index']);
Route::get('/posts/{id}', [PostApiController::class, 'show']);
//posts by category
Route::get('/categories/{categoryId}/posts', [PostApiController::class, 'byCategory']);


// Media API
Route::get('/media', [MediaApiController::class, 'index']);
Route::get('/media/{id}', [MediaApiController::class, 'show']);

});

