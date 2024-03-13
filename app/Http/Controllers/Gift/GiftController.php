<?php

namespace App\Http\Controllers\Gift;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GiftController extends Controller
{
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

        $gyphyApiUrl= env('GIPHY_API_URL');
        $gyphyApiKey = env('GIPHY_DEV_API_KEY');
        
        $response = Http::get($gyphyApiUrl . '/gifs/search', [
            'api_key' => $gyphyApiKey,
            'q' => $request->query('query'),
            'limit' => $request->query('limit'),
            'offset' => $request->query('offset'),
        
        ]);
        
        $giftsData = $response->json();
        $giftsParseData = parseGiftsData($giftsData['data']);

        return response()->json([
            'message' => 'Successfully retrieved gifts!',
            'data' => $giftsParseData
        ], 200);
    }

    public function show($giftId)
    {
        
        $validator = Validator::make(['gift_id' => $giftId], [
            'gift_id' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Invalid gift ID',
                'details' => $validator->errors()
            ], 400);
        }

        $gyphyApiUrl= env('GIPHY_API_URL');
        $gyphyApiKey = env('GIPHY_DEV_API_KEY');
        
        $response = Http::get($gyphyApiUrl . '/gifs/' . $giftId, [
            'api_key' => $gyphyApiKey
        ]);
        
        $giftData = $response->json();
        $giftParseData = parseGiftsData([$giftData['data']]);

        return response()->json([
            'message' => 'Successfully retrieved gift!',
            'data' => $giftParseData
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gift_id' => 'required|string',
            'alias' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }


        return response()->json([
            'message' => 'Successfully created gift!',
            'data' => []
        ], 201);
    }
}
