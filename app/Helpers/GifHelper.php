<?php


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

    return $gifsDto;
}
