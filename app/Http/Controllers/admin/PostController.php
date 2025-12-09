<?php

namespace App\Http\Controllers\admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class PostController extends Controller
{
    /*     
    * Display a listing of the posts.
     */

    public function index(Request $request)
    {
        if (!Schema::hasTable('posts')) {
            return Inertia::render('Admin/Posts/Index', ['posts' => []]);
        }

        $posts = QueryBuilder::for(Post::class)
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::partial('excerpt'),
            ])
            ->allowedSorts(['created_at', 'title'])
            ->defaultSort('-created_at')
            ->select(['id', 'title', 'excerpt', 'created_at'])
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Posts/Index', [
            'posts' => $posts,
        ]);
    }

    /*     
    * Show the form for creating a new post.
     */
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

        return Inertia::render('Admin/Posts/Create', [
            'categories' => $categories,
            'postsTypes' => $postsTypes,
            'postsStatus' => $postsStatus,
            'parents' => $parents,
            'users' => $users,
            'medias' => $medias,
        ]);
    }

    /*     
    * Display the specified post.
     */
    public function show($id)
    {
        if (!Schema::hasTable('posts')) {
            return redirect()->route('admin.posts.index')->with('error', 'Posts table missing.');
        }

        $post = DB::table('posts')->where('id', $id)->first();
        if (!$post) {
            return redirect()->route('admin.posts.index')->with('error', 'Post non trovato.');
        }

        return Inertia::render('Admin/Posts/Show', [
            'post' => $post,
        ]);
    }

    public function edit($id)
    {
        if (!Schema::hasTable('posts')) {
            return redirect()->route('admin.posts.index')->with('error', 'Posts table missing.');
        }

        $post = DB::table('posts')->where('id', $id)->first();
        if (!$post) {
            return redirect()->route('admin.posts.index')->with('error', 'Post non trovato.');
        }
            // le mie query per i campi select nel form di edit
        $categories = Schema::hasTable('categories') ? DB::table('categories')->select('id', 'name')->orderBy('name')->get() : [];
        $postsTypes = Schema::hasTable('posts_types') ? DB::table('posts_types')->select('id', 'name')->orderBy('name')->get() : [];
        $postsStatus = Schema::hasTable('posts_status') ? DB::table('posts_status')->select('id', 'name')->orderBy('name')->get() : [];
        $parents = Schema::hasTable('posts') ? DB::table('posts')->select('id', 'title')->orderBy('title')->get() : [];
        $users = [];
        if (Schema::hasTable('users')) {
            if (Schema::hasColumn('users', 'name')) {
                $users = DB::table('users')->select('id', 'name')->orderBy('name')->get();
            } elseif (Schema::hasColumn('users', 'username')) {
                $users = DB::table('users')->select('id', DB::raw('username as name'))->orderBy('username')->get();
            } else {
                $users = DB::table('users')->select('id', DB::raw('email as name'))->orderBy('email')->get();
            }
        }
        $medias = Schema::hasTable('medias') ? DB::table('medias')->select('id', 'file_name')->orderBy('file_name')->get() : [];

        return Inertia::render('Admin/Posts/Edit', [
            'post' => $post,
            'categories' => $categories,
            'postsTypes' => $postsTypes,
            'postsStatus' => $postsStatus,
            'parents' => $parents,
            'users' => $users,
            'medias' => $medias,
        ]);
    }


    /*     
        * Update the specified post in storage.
     */
    public function update(Request $request, $id)
    {
        if (!Schema::hasTable('posts')) {
            return redirect()->route('admin.posts.index')->with('error', 'Posts table missing.');
        }

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
            'cover_image' => 'nullable|image|max:5120',
        ]);

        $post = DB::table('posts')->where('id', $id)->first();
        if (!$post) {
            return redirect()->route('admin.posts.index')->with('error', 'Post non trovato.');
        }

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

        // Handle cover image upload if present
        $mediaId = $request->input('media_id') ?: $post->media_id ?? null;
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
        // Handle tags input (array to comma-separated string)
        $tags = $request->input('tags');
        if (is_array($tags)) {
            $tags = implode(',', $tags);
        }

        $update = [
            'posts_types_id' => $request->input('posts_types_id') ?: null,
            'title' => $request->input('title'),
            'content' => $request->input('content') ?: null,
            'excerpt' => $request->input('excerpt') ?: null,
            'template' => $request->input('template') ?: null,
            'is_highlighted' => $request->has('is_highlighted') ? 1 : 0,
            'comments_enabled' => $request->has('comments_enabled') ? 1 : 1,
            'views_count' => $request->input('views_count') !== null ? (int) $request->input('views_count') : null,
            'published_at' => $publishedAt,
            'users_id' => $request->input('users_id') ?: (Auth::check() ? Auth::id() : null),
            'posts_status_id' => $request->input('posts_status_id') ?: null,
            'media_id' => $mediaId,
            'categories_id' => $request->input('category_id') ?: null,
            'parent_id' => $request->input('parent_id') ?: null,
            'tags' => $tags,
        ];

        DB::table('posts')->where('id', $id)->update($update);

        return redirect()->route('admin.posts.index')->with('success', "Post aggiornato (ID: {$id}).");
    }

    /*     
        * Remove the specified post from storage.
        * dependecy check included. 
        * on delete cascade.    
     */
    public function destroy(Request $request, $id)
    {
        if (!Schema::hasTable('posts')) {
            return redirect()->route('admin.posts.index')->with('error', 'Posts table missing.');
        }

        $exists = DB::table('posts')->where('id', $id)->exists();
        if (!$exists) {
            return redirect()->route('admin.posts.index')->with('error', 'Post non trovato.');
        }

        // Prevent deleting a post that is referenced by other tables (foreign key constraints)
        // e.g. products.posts_id -> posts.id. Provide a friendly error instead of an unhandled exception.
        try {
            // If force flag present, bypass dependency check and allow delete (DB has ON DELETE CASCADE)
            $force = $request->input('force') ? true : false;

            if (!$force && Schema::hasTable('products')) {
                $dependentCount = DB::table('products')->where('posts_id', $id)->count();
                if ($dependentCount > 0) {
                    return redirect()->route('admin.posts.index')->with('error', "Impossibile eliminare il post: ci sono {$dependentCount} record dipendenti nella tabella products. Usa 'Elimina' con conferma per forzare la cancellazione.");
                }
            }

            DB::table('posts')->where('id', $id)->delete();

            return redirect()->route('admin.posts.index')->with('success', 'Post eliminato.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Fallback: return a readable message for FK constraint failures
            return redirect()->route('admin.posts.index')->with('error', 'Impossibile eliminare il post a causa di vincoli di integrità referenziale. Rimuovi le dipendenze e riprova.');
        }
    }

    /**
     * Return dependent counts for a post (JSON).
     */
    public function dependents($id)
    {
        $counts = [];
        if (Schema::hasTable('products')) {
            $counts['products'] = DB::table('products')->where('posts_id', $id)->count();
        } else {
            $counts['products'] = 0;
        }

        return response()->json($counts);
    }

    /**
     * Store a newly created post in storage.
     */
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
        // Handle cover image upload if present
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
        // Handle tags input (array to comma-separated string)
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
            'users_id' => $request->input('users_id') ?: (Auth::check() ? Auth::id() : null),
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

