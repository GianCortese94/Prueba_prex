<?php

namespace App\Http\Controllers;

use App\Http\Requests\GiphySearchRequest;
use App\Http\Resources\GiphySearchResource;
use App\Services\GiphyService;
use Illuminate\Http\JsonResponse;

class GiphyController extends Controller
{
    protected GiphyService $giphyService;

    public function __construct(GiphyService $giphyService)
    {
        $this->giphyService = $giphyService;
    }

    /**
     * Buscar gifs por una frase o término.
     *
     * @param GiphySearchRequest $request
     * @return JsonResponse
     */
    public function search(GiphySearchRequest $request): JsonResponse
    {
        $query = $request->input('query', 'funny');
        $limit = $request->input('limit', 5);
        $offset = $request->input('offset', 0);

        $response = $this->giphyService->getGifs($query, $limit, $offset);

        if (isset($response['data'])) {
            $gifs = collect($response['data'])->map(function ($gif) {
                return new GiphySearchResource((object) $gif);
            });

            $message = count($gifs) > 0 ? 'GIFs fetched successfully' : 'No GIFs found for the given query.';

            $pagination = $response['pagination'];

            return response()->json([
                'message' => $message,
                'gifs' => $gifs,
                'pagination' => [
                    'total_count' => $pagination['total_count'],
                    'count' => $pagination['count'],
                    'offset' => $pagination['offset'],
                ]
            ]);
        }

        return response()->json(['error' => 'No results found'], 404);
    }

    /**
     * Obtener información de un gift específico.
     *
     * @param string $id //en el documento se pedía que sea numeric, pero los ids son alfanumericos
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $gif = $this->giphyService->getGifById($id);

        if (!empty($gif)) {
            return response()->json([
                'message' => 'GIF fetched successfully',
                'gif' => $gif
            ]);
        }

        return response()->json(['error' => 'GIF not found'], 404);
    }
}
