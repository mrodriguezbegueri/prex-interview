<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use function App\Helpers\parseGifsData;

class GifHelperTest extends TestCase
{
    public function test_parseGifsData_returns_single_gif()
    {
        $gifsData = [
            [
                'id' => 'WiXMlla4ZFR8Q',
                'title' => 'loop munching GIF',
                'type' => 'gif',
                'url' => 'https://giphy.com/gifs/loop-rabbit-WiXMlla4ZFR8Q',
                'embed_url' => 'https://giphy.com/embed/WiXMlla4ZFR8Q',
                "images" => [
                    "original" => [
                        "url" => "https://media1.giphy.com/media/WiXMlla4ZFR8Q/giphy.gif",
                    ],
                ],
                "otherProperty" => 'otherValue'
            ],
        ];

        $expectedResult = [
            'id' => 'WiXMlla4ZFR8Q',
            'title' => 'loop munching GIF',
            'type' => 'gif',
            'url' => 'https://giphy.com/gifs/loop-rabbit-WiXMlla4ZFR8Q',
            'embed_url' => 'https://giphy.com/embed/WiXMlla4ZFR8Q',
        ];

        $result = parseGifsData($gifsData);

        $this->assertEquals($expectedResult, $result);
    }

    public function test_parseGifsData_returns_multiple_gifs()
    {
        $gifsData = [
            [
                'id' => 'WiXMlla4ZFR8Q',
                'title' => 'loop munching GIF',
                'type' => 'gif',
                'url' => 'https://giphy.com/gifs/loop-rabbit-WiXMlla4ZFR8Q',
                'embed_url' => 'https://giphy.com/embed/WiXMlla4ZFR8Q',
                "images" => [
                    "original" => [
                        "url" => "https://media1.giphy.com/media/WiXMlla4ZFR8Q/giphy.gif",
                    ],
                ],
                "otherProperty" => 'otherValue1'
            ],
            [
                'id' => '6VRnE4sL9lTyg8ryl7',
                'title' => 'No Way Yes GIF by Peter Rabbit Movie',
                'type' => 'gif',
                'url' => 'https://giphy.com/gifs/PeterRabbitMovie-peter-rabbit-2-pr2-6VRnE4sL9lTyg8ryl7',
                'embed_url' => 'https://giphy.com/embed/6VRnE4sL9lTyg8ryl7',
                "images" => [
                    "original" => [
                        "url" => "https://media1.giphy.com/media/6VRnE4sL9lTyg8ryl7/giphy.gif",
                    ],
                ],
                "otherProperty" => 'otherValue2'
            ],
        ];

        $expectedResult = [
            [
                'id' => 'WiXMlla4ZFR8Q',
                'title' => 'loop munching GIF',
                'type' => 'gif',
                'url' => 'https://giphy.com/gifs/loop-rabbit-WiXMlla4ZFR8Q',
                'embed_url' => 'https://giphy.com/embed/WiXMlla4ZFR8Q',
            ],
            [
                'id' => '6VRnE4sL9lTyg8ryl7',
                'title' => 'No Way Yes GIF by Peter Rabbit Movie',
                'type' => 'gif',
                'url' => 'https://giphy.com/gifs/PeterRabbitMovie-peter-rabbit-2-pr2-6VRnE4sL9lTyg8ryl7',
                'embed_url' => 'https://giphy.com/embed/6VRnE4sL9lTyg8ryl7',
            ],
        ];

        $result = parseGifsData($gifsData);

        $this->assertEquals($expectedResult, $result);
    }

    public function test_parseGifsData_returns_empty_array_when_no_gifs()
    {
        $gifsData = [];

        $expectedResult = [];

        $result = parseGifsData($gifsData);

        $this->assertEquals($expectedResult, $result);
    }
}