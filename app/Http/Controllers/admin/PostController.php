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
        // Return a list of posts for the SPA index page. If the posts table does not
        // exist yet (tests or fresh DB), return an empty array so the SPA can handle it.
        $posts = [];
        if (Schema::hasTable('posts')) {
            $posts = DB::table('posts')
                ->select('id', 'title', 'excerpt', 'created_at')
                ->orderBy('created_at', 'desc')
                ->limit(100)
                ->get();
        }

        return Inertia::render('admin/posts/Index', [
            'posts' => $posts,
        ]);
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

        // Render the Inertia SPA page so the PrimeVue SFC is mounted client-side.
        return Inertia::render('admin/posts/Create', [
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
            'tags' => 'nullable',
            'cover_image' => 'nullable|image|max:5120', // 5MB
        ]);

        // Normalize published_at (datetime-local) into SQL datetime
        $published = $request->input('published_at');
        $publishedAt = null;
        if ($published) {
            try {
                $publishedAt = \Illuminate\Support\Carbon::createFromFormat('Y-m-d\\TH:i', $published)->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                $ts = strtotime($published);
                if ($ts !== false) $publishedAt = date('Y-m-d H:i:s', $ts);
            }
        }

        $now = now();

        // Handle cover image upload if present. If a `medias` table exists, insert a
        // medias record and reference it; otherwise store the file and leave media_id null.
        $mediaId = $request->input('media_id') ?: null;
        if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()) {
            $file = $request->file('cover_image');
            $path = $file->store('posts', 'public');
            $fileName = $file->getClientOriginalName();

            if (Schema::hasTable('medias')) {
                $mediaId = DB::table('medias')->insertGetId([
                    'file_name' => $fileName,
                    'file_path' => $path,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // Tags: accept array or string; store as comma separated string if array
        $tags = $request->input('tags');
        if (is_array($tags)) {
            $tags = implode(',', $tags);
        }

        $insert = [
            'posts_types_id' => $request->input('posts_types_id') ?: null,
            'title' => $request->input('title'),
            'content' => $request->input('content') ?: null,
            'excerpt' => $request->input('excerpt') ?: null,
            'template' => $request->input('template') ?: null,
            'is_highlighted' => $request->has('is_highlighted') ? 1 : 0,
            'comments_enabled' => $request->has('comments_enabled') ? 1 : 1,
            'views_count' => $request->input('views_count') !== null ? (int) $request->input('views_count') : null,
            'published_at' => $publishedAt,
            'created_at' => $now,
            'updated_at' => $now,
            'users_id' => $request->input('users_id') ?: (auth()->check() ? auth()->id() : null),
            'posts_status_id' => $request->input('posts_status_id') ?: null,
            'media_id' => $mediaId,
            'categories_id' => $request->input('category_id') ?: null,
            'parent_id' => $request->input('parent_id') ?: null,
            'tags' => $tags,
        ];

        $id = DB::table('posts')->insertGetId($insert);

        return redirect()->route('admin.posts.index')->with('success', "Post creato (ID: {$id}).");
    }           
}
