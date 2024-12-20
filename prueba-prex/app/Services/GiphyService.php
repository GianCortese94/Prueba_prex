<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class GiphyService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('GIPHY_API_KEY');
        $this->baseUrl = env('GIPHY_BASE_URL');
    }

    /**
     * Obtener GIFs de la API de Giphy
     *
     * @param string $query
     * @param int $limit
     * @return array
     */
    public function getGifs(string $query, int $limit = 25, int $offset = 0): array
    {
        $searchUrl = $this->baseUrl . '/v1/gifs/search';

        try {
            $response = Http::get($searchUrl, [
                'api_key' => $this->apiKey,
                'q' => $query,
                'limit' => $limit,
                'offset' => $offset,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception("Error in the request: " . $response->status() . " - " . $response->body());
        } catch (\Exception $e) {
            \Log::error("Error querying Giphy API: " . $e->getMessage());
            return [
                'error' => 'The request could not be completed. Please try again later.',
                'details' => $e->getMessage(),
            ];
        }
    }

    /**
     * Obtener GIF por ID de la API de Giphy
     *
     * @param string $gifId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGifById(string $gifId): array
    {
        $url = $this->baseUrl . '/v1/gifs/' . $gifId;

        try {
            $response = Http::get($url, [
                'api_key' => $this->apiKey,
            ]);

            if ($response->successful()) {
                return $response->json()['data'];
            }

            throw new \Exception('Failed to fetch GIF data. Status code: ' . $response->status());

        } catch (RequestException $e) {
            return response()->json(['error' => 'Network error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
