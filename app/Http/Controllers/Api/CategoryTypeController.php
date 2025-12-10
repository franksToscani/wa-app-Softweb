<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryTypeController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/category-types",
     *   summary="Crea un nuovo tipo di categoria",
     *   description="Endpoint per creare un nuovo tipo di categoria",
     *   tags={"CategoryTypes"},
     *   @OA\RequestBody(
     *     required=true,
     *     description="Dati del tipo categoria",
     *     @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string", example="Tipo A")
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Tipo categoria creato",
     *     @OA\JsonContent(
     *       @OA\Property(property="id", type="integer"),
     *       @OA\Property(property="name", type="string")
     *     )
     *   ),
     *   @OA\Response(response=422, description="Validazione fallita")
     * )
     */
    public function store(Request $request)
    {
// Logic to store a new category type
    }
}
