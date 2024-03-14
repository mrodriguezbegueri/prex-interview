<?php

namespace App\Http\Controllers\Gif;

use App\Http\Controllers\Controller;
use App\Models\UserGif;
use App\Services\GIPHYApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GifController extends Controller
{
    protected $giphyApiService;

    public function __construct(GIPHYApiService $giphyApiService)
    {
        $this->giphyApiService = $giphyApiService;
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required|string|min:1|max:50',
            'limit' => 'string|numeric',
            'offset' => 'string|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }
        
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
            return response()->json([
                'error' => 'Invalid gift ID',
                'details' => $validator->errors()
            ], 400);
        }
        
        $gifData = $this->giphyApiService->getGif($gifId);
        $gifParseData = parseGifsData([$gifData]);

        return response()->json([
            'message' => 'Successfully retrieved gift!',
            'data' => $gifParseData
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gif_id' => 'required|string',
            'alias' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

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
