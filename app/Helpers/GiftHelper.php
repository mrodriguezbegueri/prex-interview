<?php

function parseGiftsData($giftsData = []) {
    $giftsDto = [];

    foreach ($giftsData as $gift) {
        $filteredGift = [
            'id' => $gift['id'],
            'title' => $gift['title'],
            'type' => $gift['type'],
            'url' => $gift['url'],
            'embed_url' => $gift['embed_url'],
        ];
    
        $giftsDto[] = $filteredGift;
    }

    return $giftsDto;
}