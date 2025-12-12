<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Schema;

class PostApiController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/posts",
     *   summary="Lista di tutti i post",
     *   description="Restituisce una lista paginata di post con supporto a filtri e ordinamenti",
     *   tags={"Posts"},
     *   @OA\Parameter(
     *     name="filter[title]",
     *     in="query",
     *     description="Filtra per titolo (ricerca parziale)",
     *     @OA\Schema(type="string", example="news")
     *   ),
     *   @OA\Parameter(
     *     name="filter[excerpt]",
     *     in="query",
     *     description="Filtra per estratto (ricerca parziale)",
     *     @OA\Schema(type="string", example="aggiornamento")
     *   ),
     *   @OA\Parameter(
     *     name="sort",
     *     in="query",
     *     description="Ordinamento: created_at, title (usa - per discendente)",
     *     @OA\Schema(type="string", example="-created_at")
     *   ),
     *   @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Numero pagina (default 1)",
     *     @OA\Schema(type="integer", example=1)
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Lista post",
     *     @OA\JsonContent(
     *       @OA\Property(property="data", type="array", @OA\Items(
     *         @OA\Property(property="id", type="integer"),
     *         @OA\Property(property="title", type="string"),
     *         @OA\Property(property="excerpt", type="string"),
     *         @OA\Property(property="created_at", type="string", format="date-time"),
     *         @OA\Property(property="published_at", type="string", format="date-time")
     *       )),
     *       @OA\Property(property="meta", type="object",
     *         @OA\Property(property="total", type="integer"),
     *         @OA\Property(property="per_page", type="integer"),
     *         @OA\Property(property="current_page", type="integer")
     *       ),
     *       @OA\Property(property="links", type="object")
     *     )
     *   )
     * )
     */
    public function index(Request $request)
    {
        if (!Schema::hasTable('posts')) {
            return response()->json(['data' => []], 200);
        }

        $posts = QueryBuilder::for(Post::class)
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::partial('excerpt'),
            ])
            ->allowedSorts(['created_at', 'title'])
            ->defaultSort('-created_at')
            ->select(['id', 'title', 'excerpt', 'created_at', 'published_at'])
            ->paginate(20);

        return response()->json($posts, 200);
    }

    /**
     * @OA\Get(
     *   path="/api/posts/{id}",
     *   summary="Dettaglio di un singolo post",
     *   description="Restituisce i dati completi di un post specifico",
     *   tags={"Posts"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID del post",
     *     @OA\Schema(type="integer", example=1)
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Dettaglio post",
     *     @OA\JsonContent(
     *       @OA\Property(property="id", type="integer"),
     *       @OA\Property(property="title", type="string"),
     *       @OA\Property(property="content", type="string"),
     *       @OA\Property(property="excerpt", type="string"),
     *       @OA\Property(property="created_at", type="string", format="date-time"),
     *       @OA\Property(property="published_at", type="string", format="date-time")
     *     )
     *   ),
     *   @OA\Response(response=404, description="Post non trovato")
     * )
     */
    public function show($id)
    {
        if (!Schema::hasTable('posts')) {
            return response()->json(['error' => 'Posts table missing'], 404);
        }

        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        return response()->json($post, 200);
    }

    /**
     * @OA\Get(
     *   path="/api/categories/{categoryId}/posts",
     *   summary="Lista di post per categoria",
     *   description="Restituisce i post associati a una categoria specifica",
     *   tags={"Posts"},
     *   @OA\Parameter(
     *     name="categoryId",
     *     in="path",
     *     required=true,
     *     description="ID della categoria",
     *     @OA\Schema(type="integer", example=3)
     *   ),
     *   @OA\Parameter(
     *     name="filter[title]",
     *     in="query",
     *     description="Filtra per titolo (ricerca parziale)",
     *     @OA\Schema(type="string", example="news")
     *   ),
     *   @OA\Parameter(
     *     name="filter[excerpt]",
     *     in="query",
     *     description="Filtra per estratto (ricerca parziale)",
     *     @OA\Schema(type="string", example="aggiornamento")
     *   ),
     *   @OA\Parameter(
     *     name="sort",
     *     in="query",
     *     description="Ordinamento: created_at, title (usa - per discendente)",
     *     @OA\Schema(type="string", example="-created_at")
     *   ),
     *   @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Numero pagina (default 1)",
     *     @OA\Schema(type="integer", example=1)
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Lista post per categoria"
     *   ),
     *   @OA\Response(response=404, description="Nessun post o tabella mancante")
     * )
     */
    public function byCategory(int $categoryId)
    {
        if (!Schema::hasTable('posts')) {
            return response()->json(['error' => 'Posts table missing'], 404);
        }

        $posts = QueryBuilder::for(Post::class)
            ->where('categories_id', $categoryId)
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::partial('excerpt'),
            ])
            ->allowedSorts(['created_at', 'title'])
            ->defaultSort('-created_at')
            ->select(['id', 'title', 'excerpt', 'created_at', 'published_at', 'categories_id'])
            ->paginate(20);

        return response()->json($posts, 200);
    }
}
