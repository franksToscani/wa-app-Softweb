<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\admin\MediaController;

// Admin routes grouped with prefix, name and middleware. We use the middleware class directly
// so there's no need to register an alias in Kernel.php.
// (Temporary test routes removed.)

Route::prefix('admin')->name('admin.')->middleware(['auth','verified', \App\Http\Middleware\EnsureUserIsAdmin::class])->group(function () {
    // Resourceful routes for posts (index/create/store etc.)
    // Index route: list posts (needed by admin.posts.index referenced in JS)
    
    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    // Show single post
    Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
    // Endpoint to return dependent counts for a post (used by the delete confirmation UI)
    Route::get('posts/{post}/dependents', [PostController::class, 'dependents'])->name('posts.dependents');
    // Edit form
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    // Update
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    // Delete
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    
    // Media CRUD routes
    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::get('media/create', [MediaController::class, 'create'])->name('media.create');
    Route::post('media', [MediaController::class, 'store'])->name('media.store');
    Route::get('media/{media}', [MediaController::class, 'show'])->name('media.show');
    Route::get('media/{media}/edit', [MediaController::class, 'edit'])->name('media.edit');
    Route::put('media/{media}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
});