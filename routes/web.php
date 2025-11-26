<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Welcome page route
Route::get('/', function () {
    $isAdmin = false;

    if (Auth::check()) {
        $userId = Auth::id();
        $isAdmin = DB::table('users_has_roles')
            ->join('roles', 'roles.id', '=', 'users_has_roles.roles_id')
            ->where('users_has_roles.users_id', $userId)
            ->whereRaw('LOWER(roles.nome) = ?', ['admin'])
            ->exists();
    }

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'isAdmin' => $isAdmin,
    ]);
});

// Home page route
Route::get('/home', function () {
    $isAdmin = false;

    if (Auth::check()) {
        $userId = Auth::id();
        $isAdmin = DB::table('users_has_roles')
            ->join('roles', 'roles.id', '=', 'users_has_roles.roles_id')
            ->where('users_has_roles.users_id', $userId)
            ->whereRaw('LOWER(roles.nome) = ?', ['admin'])
            ->exists();
    }

    // Fetch latest posts and products for the home page lists
    $posts = Post::orderByDesc('id')->limit(4)->get(['id', 'title', 'excerpt', 'created_at'])->toArray();
    $products = Product::orderByDesc('id')->limit(8)->get([
        'id',
        'sku as name',
        'regular_price as price',
        'create_at as created_at',
    ])->toArray();

    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'isAdmin' => $isAdmin,
        'posts' => $posts,
        'products' => $products,
    ]);
})->name('home');

// render dashboard with latest 5 posts and 6 products
Route::get('/dashboard', function () {
    // include 'content' so frontend can show a full post preview in a modal
    $posts = Post::orderByDesc('id')->limit(5)->get(['id', 'title', 'excerpt', 'content', 'created_at'])->toArray();
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

// Profile management routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Debug route to check database connection info 
Route::get('/_debug-db', function () {
    return [
        'default_connection' => config('database.default'),
        'database' => config('database.connections.' . config('database.default') . '.database'),
    ];
});

// Authentication routes
require __DIR__.'/auth.php';
