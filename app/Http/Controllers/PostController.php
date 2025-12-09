<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Post;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{
    /**
     * Display the specified post (public route).
     */
    public function show($id)
    {
        if (!Schema::hasTable('posts')) {
            return redirect()->route('welcome')->with('error', 'Posts table missing.');
        }

        $post = QueryBuilder::for(Post::class)
            ->where('id', $id)
            ->first();
        
        if (!$post) {
            return redirect()->route('welcome')->with('error', 'Post non trovato.');
        }

        // Check if user is admin for conditional rendering
        $isAdmin = false;
        if (Auth::check()) {
            $userId = Auth::id();
            $isAdmin = DB::table('users_has_roles')
                ->join('roles', 'roles.id', '=', 'users_has_roles.roles_id')
                ->where('users_has_roles.users_id', $userId)
                ->whereRaw('LOWER(roles.nome) = ?', ['admin'])
                ->exists();
        }

        return Inertia::render('Posts/Show', [
            'post' => $post,
            'isAdmin' => $isAdmin,
        ]);
    }
}
