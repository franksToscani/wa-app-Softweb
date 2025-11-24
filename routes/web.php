<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\Product;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $posts = Post::orderByDesc('id')->limit(5)->get(['id', 'title', 'excerpt', 'created_at'])->toArray();
    $products = Product::orderByDesc('id')->limit(6)->get([
        'id',
        'sku as name',
        'regular_price as price',
        // products table uses `create_at` (singular) in the schema; alias it to created_at
        'create_at as created_at',
    ])->toArray();

    return Inertia::render('Dashboard', [
        'posts' => $posts,
        'products' => $products,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/_debug-db', function () {
    return [
        'default_connection' => config('database.default'),
        'database' => config('database.connections.' . config('database.default') . '.database'),
    ];
});
require __DIR__.'/auth.php';
