<?php

namespace App\Http\Controllers\Gif;

use App\Http\Controllers\Controller;
use App\Models\UserGif;
use App\Services\GIPHYApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GifController extends Controller
{
    protected $giphyApiService;

    public function __construct(GIPHYApiService $giphyApiService)
    {
        $this->giphyApiService = $giphyApiService;
    }

    public function index(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:1|max:50',
            'limit' => 'string|numeric',
            'offset' => 'string|numeric',
        ]);

        $gifsData = $this->giphyApiService->getGifs(
            $request->query('query'),
            $request->query('limit'),
            $request->query('offset')
        );

        $gifsParseData = parseGifsData($gifsData);

        return response()->json([
            'message' => 'Successfully retrieved gifs!',
            'data' => $gifsParseData
        ], 200);
    }

    public function show($gifId)
    {
        $validator = Validator::make(['gif_id' => $gifId], [
            'gif_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $gifData = $this->giphyApiService->getGif($gifId);

        if (empty($gifData)) {
            return response()->json([
                'message' => 'Gif not found!',
            ], 404);
        }


        $gifParseData = parseGifsData([$gifData]);

        return response()->json([
            'message' => 'Successfully retrieved gift!',
            'data' => $gifParseData
        ], 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'gif_id' => 'required|string',
            'alias' => 'required|string'
        ]);

        $gif = $this->giphyApiService->getGif($request->gif_id);

        $userGift = UserGif::create([
            'external_id' => $gif['id'],
            'user_id' => Auth::id(),
            'name' => $gif['title'],
            'url' => $gif['url']
        ]);

        return response()->json([
            'message' => 'Successfully created gift!',
            'data' => $userGift
        ], 201);
    }
}
