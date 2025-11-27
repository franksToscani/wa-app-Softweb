<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\PostController;

// Admin routes grouped with prefix, name and middleware. We use the middleware class directly
// so there's no need to register an alias in Kernel.php.
// (Temporary test routes removed.)

Route::prefix('admin')->name('admin.')->middleware(['auth','verified', \App\Http\Middleware\EnsureUserIsAdmin::class])->group(function () {
    // Resourceful routes for posts (index/create/store etc.)
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
});