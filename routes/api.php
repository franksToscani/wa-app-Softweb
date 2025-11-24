<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryTypeController;

Route::post('/category-types', [CategoryTypeController::class, 'store']);
