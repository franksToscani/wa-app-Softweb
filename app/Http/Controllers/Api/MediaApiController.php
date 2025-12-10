<?php

namespace App\Http\Controllers\Api;

use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class MediaApiController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/media",
     *   summary="Lista di tutti i media",
     *   description="Restituisce una lista paginata di media con supporto a filtri e ordinamenti",
     *   tags={"Media"},
     *   @OA\Parameter(
     *     name="filter[name]",
     *     in="query",
     *     description="Filtra per nome (ricerca parziale)",
     *     @OA\Schema(type="string", example="logo")
     *   ),
     *   @OA\Parameter(
     *     name="filter[file_name]",
     *     in="query",
     *     description="Filtra per nome file (ricerca parziale)",
     *     @OA\Schema(type="string", example="logo.png")
     *   ),
     *   @OA\Parameter(
     *     name="filter[mime_type]",
     *     in="query",
     *     description="Filtra per tipo MIME (match esatto)",
     *     @OA\Schema(type="string", example="image/png")
     *   ),
     *   @OA\Parameter(
     *     name="sort",
     *     in="query",
     *     description="Ordinamento: created_at, name, file_name, size (usa - per discendente)",
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
     *     description="Lista media",
     *     @OA\JsonContent(
     *       @OA\Property(property="data", type="array", @OA\Items(
     *         @OA\Property(property="id", type="integer"),
     *         @OA\Property(property="name", type="string"),
     *         @OA\Property(property="file_name", type="string"),
     *         @OA\Property(property="mime_type", type="string"),
     *         @OA\Property(property="size", type="integer"),
     *         @OA\Property(property="url", type="string"),
     *         @OA\Property(property="created_at", type="string", format="date-time")
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
        if (!\Illuminate\Support\Facades\Schema::hasTable('medias')) {
            return response()->json(['data' => []], 200);
        }

        $media = QueryBuilder::for(Media::class)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::partial('file_name'),
                AllowedFilter::exact('mime_type'),
            ])
            ->allowedSorts(['created_at', 'name', 'file_name', 'size'])
            ->defaultSort('-created_at')
            ->select(['id', 'name', 'file_name', 'mime_type', 'size', 'url', 'created_at'])
            ->paginate(20);

        return response()->json($media, 200);
    }

    /**
     * @OA\Get(
     *   path="/api/media/{id}",
     *   summary="Dettaglio di un singolo media",
     *   description="Restituisce i dati completi di un media specifico",
     *   tags={"Media"},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID del media",
     *     @OA\Schema(type="integer", example=1)
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Dettaglio media",
     *     @OA\JsonContent(
     *       @OA\Property(property="id", type="integer"),
     *       @OA\Property(property="name", type="string"),
     *       @OA\Property(property="file_name", type="string"),
     *       @OA\Property(property="file_path", type="string"),
     *       @OA\Property(property="mime_type", type="string"),
     *       @OA\Property(property="size", type="integer"),
     *       @OA\Property(property="url", type="string"),
     *       @OA\Property(property="created_at", type="string", format="date-time")
     *     )
     *   ),
     *   @OA\Response(response=404, description="Media non trovato")
     * )
     */
    public function show($id)
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('medias')) {
            return response()->json(['error' => 'Medias table missing'], 404);
        }

        $media = Media::find($id);
        if (!$media) {
            return response()->json(['error' => 'Media not found'], 404);
        }

        return response()->json($media, 200);
    }
}
