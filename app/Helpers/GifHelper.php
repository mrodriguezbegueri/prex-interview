<?php

namespace App\Helpers;

function parseGifsData($gifsData = []) {
    $gifsDto = [];

    foreach ($gifsData as $gif) {
        $filteredGif = [
            'id' => $gif['id'],
            'title' => $gif['title'],
            'type' => $gif['type'],
            'url' => $gif['url'],
            'embed_url' => $gif['embed_url'],
        ];
    
        $gifsDto[] = $filteredGif;
    }

    if (count($gifsDto) === 1) {
        return $gifsDto[0];
    }

    return $gifsDto;
}
