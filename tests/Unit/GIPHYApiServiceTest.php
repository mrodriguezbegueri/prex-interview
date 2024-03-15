<?php

namespace Tests\Unit;

use App\Services\GIPHYApiService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GIPHYApiServiceTest extends TestCase
{

    public function test_getGifs_returns_gifs_data()
    {
        $query = 'cats';
        $limit = 5;
        $offset = 0;
        $gifsData =  [
            [
                "id" => "3o72EX5QZ9N9d51dqo",
                "title" => "Dj Cats GIF by Product Hunt",
                "type" => "gif",
                "url" => "https://giphy.com/gifs/producthunt-cats-music-streaming-3o72EX5QZ9N9d51dqo",
                "embed_url" => "https://giphy.com/embed/3o72EX5QZ9N9d51dqo"
            ],
        ];

        Http::fake([
            'api.giphy.com/v1/gifs/search*' => Http::response([
                'data' => $gifsData
            ], 200)
        ]);

        $giphyApiService = new GIPHYApiService();

        $result = $giphyApiService->getGifs($query, $limit, $offset);

        $this->assertEquals($gifsData, $result);
    }

    public function test_getGif_returns_gif_data()
    {
        $gifId = 'cfuL5gqFDreXxkWQ4o';
        $gifData = [
            [
                "id" => "cfuL5gqFDreXxkWQ4o",
                "title" => "On My Way Goodbye GIF by Bubble Punk",
                "type" => "gif",
                "url" => "https://giphy.com/gifs/cat-cool-cats-cfuL5gqFDreXxkWQ4o",
                "embed_url" => "https://giphy.com/embed/cfuL5gqFDreXxkWQ4o"
            ],
        ];

        Http::fake([
            '*' => Http::response(['data' => $gifData], 200)
        ]);

        $giphyApiService = new GIPHYApiService();

        $result = $giphyApiService->getGif($gifId);

        $this->assertEquals($gifData, $result);
    }
}
