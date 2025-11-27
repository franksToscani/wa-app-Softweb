<?php

namespace App\Http\Controllers\admin;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Basic validation for the main fields. We accept many nullable fields because
        // the schema allows nulls for several columns.
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'template' => 'nullable|string|max:255',
            'posts_types_id' => 'nullable|integer',
            'posts_status_id' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'parent_id' => 'nullable|integer',
            'users_id' => 'nullable|integer',
            'media_id' => 'nullable|integer',
            'views_count' => 'nullable|integer',
            'published_at' => 'nullable|string',
            'is_published' => 'nullable',
            'tags' => 'nullable|string',
        ]);

        $published = $request->input('published_at');
        $publishedAt = null;
        if ($published) {
            try {
                // Expecting datetime-local input like "YYYY-MM-DDTHH:MM"; normalize it.
                $publishedAt = \Illuminate\Support\Carbon::createFromFormat('Y-m-d\\TH:i', $published)->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                // fallback: try native strtotime
                $ts = strtotime($published);
                if ($ts !== false) $publishedAt = date('Y-m-d H:i:s', $ts);
            }
        }

        $now = now();

        $insert = [
            'posts_types_id' => $request->input('posts_types_id') ?: null,
            'title' => $request->input('title'),
            'content' => $request->input('content') ?: null,
            'excerpt' => $request->input('excerpt') ?: null,
            'template' => $request->input('template') ?: null,
            'is_highlighted' => $request->has('is_highlighted') ? 1 : 0,
            // Comments enabled defaulting to 1 if not provided
            'comments_enabled' => $request->has('comments_enabled') ? 1 : 1,
            'views_count' => $request->input('views_count') !== null ? (int) $request->input('views_count') : null,
            'published_at' => $publishedAt,
            'created_at' => $now,
            'updated_at' => $now,
            'users_id' => $request->input('users_id') ?: (auth()->check() ? auth()->id() : null),
            'posts_status_id' => $request->input('posts_status_id') ?: null,
            'media_id' => $request->input('media_id') ?: null,
            'categories_id' => $request->input('category_id') ?: null,
            'parent_id' => $request->input('parent_id') ?: null,
        ];

        $id = \Illuminate\Support\Facades\DB::table('posts')->insertGetId($insert);

        // Note: tags, medias, and other relations are not fully handled here. This
        // inserts a basic post record so the new HTML form is end-to-end functional.

        return redirect()->route('dashboard')->with('success', "Post creato (ID: {$id}).");
    }

    // Other methods (create, store, etc.) can be added here as needed.

    //create method - render server-side Blade form (populate selects)
    public function create()
    {
        $categories = [];
        $postsTypes = [];
        $postsStatus = [];
        $parents = [];
        $users = [];
        $medias = [];

        if (Schema::hasTable('categories')) {
            $categories = DB::table('categories')->select('id', 'name')->orderBy('name')->get();
        }
        if (Schema::hasTable('posts_types')) {
            $postsTypes = DB::table('posts_types')->select('id', 'name')->orderBy('name')->get();
        }
        if (Schema::hasTable('posts_status')) {
            $postsStatus = DB::table('posts_status')->select('id', 'name')->orderBy('name')->get();
        }
        if (Schema::hasTable('posts')) {
            $parents = DB::table('posts')->select('id', 'title')->orderBy('title')->get();
        }
        if (Schema::hasTable('users')) {
            if (Schema::hasColumn('users', 'name')) {
                $users = DB::table('users')->select('id', 'name')->orderBy('name')->get();
            } elseif (Schema::hasColumn('users', 'username')) {
                $users = DB::table('users')->select('id', DB::raw('username as name'))->orderBy('username')->get();
            } else {
                $users = DB::table('users')->select('id', DB::raw('email as name'))->orderBy('email')->get();
            }
        }
        if (Schema::hasTable('medias')) {
            $medias = DB::table('medias')->select('id', 'file_name')->orderBy('file_name')->get();
        }

        return view('admin.posts.create', [
            'categories' => $categories,
            'postsTypes' => $postsTypes,
            'postsStatus' => $postsStatus,
            'parents' => $parents,
            'users' => $users,
            'medias' => $medias,
        ]);
    }

    //store method
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'template' => 'nullable|string|max:255',
            'posts_types_id' => 'nullable|integer',
            'posts_status_id' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'parent_id' => 'nullable|integer',
            'users_id' => 'nullable|integer',
            'media_id' => 'nullable|integer',
            'views_count' => 'nullable|integer',
            'published_at' => 'nullable|string',
            'is_published' => 'nullable',
            'tags' => 'nullable|string',
        ]);
        // For now, redirect to the dashboard as a placeholder outcome.
        return redirect()->route('dashboard')->with('success', 'Post creato (placeholder).');
    }           
}
