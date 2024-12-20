<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGifFavoriteRequest;
use App\Models\GifFavorite;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class GifFavoriteController extends Controller
{
    /**
     * Almacena un GIF como favorito para un usuario.
     *
     * Se solicitaba guardar un gif para un usuario
     * Si fuera favoritos para el usuario logueado
     * se podrían crear varios registros y se tomaria el user id del usuario logueado
     *
     * @param StoreGifFavoriteRequest $request
     * @return JsonResponse
     */
    public function store(StoreGifFavoriteRequest $request): JsonResponse
    {
        $user = User::find($request->user_id);

        $existingFavorite = GifFavorite::where('user_id', $user->id)
            ->where('gif_id', $request->gif_id)
            ->first();

        if ($existingFavorite) {
            return response()->json(['message' => 'GIF already favorited'], 200);
        }

        $favorite = GifFavorite::create([
            'user_id' => $user->id,
            'gif_id' => $request->gif_id,
            'alias' => $request->alias,
        ]);

        return response()->json([
            'message' => 'GIF added to favorites successfully',
            'favorite' => $favorite
        ], 201);
    }
}
