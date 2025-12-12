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
    // token: 1|3xslXATnFWHt8vFvvnuNrlgx720yX0APwZ8t5Tmfa2552aea

// Posts API
Route::get('/posts', [PostApiController::class, 'index']);
Route::get('/categories/{categoryId}/posts', [PostApiController::class, 'byCategory']);
Route::get('/posts/{id}', [PostApiController::class, 'show']);

// Media API
Route::get('/media', [MediaApiController::class, 'index']);
Route::get('/media/{id}', [MediaApiController::class, 'show']);

});

