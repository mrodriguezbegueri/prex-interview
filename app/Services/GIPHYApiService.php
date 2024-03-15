<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GIPHYApiService
{
    protected $apiBaseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiBaseUrl = env('GIPHY_API_URL');
        $this->apiKey = env('GIPHY_DEV_API_KEY');
    }

    public function getGifs($query, $limit = 5, $offset = 0)
    {
        $getGifsResponse = Http::get($this->apiBaseUrl . '/gifs/search', [
            'api_key' => $this->apiKey,
            'q' => $query,
            'limit' => $limit,
            'offset' => $offset,
        
        ]);

        $gifsData = $getGifsResponse->json();
        
        return $gifsData['data'];
    }

    public function getGif($gifId)
    {
        $getGifResponse = Http::get($this->apiBaseUrl . '/gifs/' . $gifId, [
            'api_key' => $this->apiKey
        ]);
        
        $gifData = $getGifResponse->json();

        return $gifData['data'];
    }

}
