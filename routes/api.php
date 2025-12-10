<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryTypeController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\MediaApiController;

// Posts API
Route::get('/posts', [PostApiController::class, 'index']);
Route::get('/posts/{id}', [PostApiController::class, 'show']);

// Media API
Route::get('/media', [MediaApiController::class, 'index']);
Route::get('/media/{id}', [MediaApiController::class, 'show']);
