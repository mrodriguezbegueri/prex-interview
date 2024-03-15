<?php


namespace Tests\Unit;

use App\Models\User;
use App\Models\UserGif;
use App\Services\GIPHYApiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GifControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $giphyApiService;
    protected $gifController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->giphyApiService = $this->mock(GIPHYApiService::class);

        $user = User::factory()->create();
        $this->actingAs($user, 'api');
    }

    public function test_index_method_returns_correct_response()
    {
        $query = $this->faker->word;
        $limit = $this->faker->numberBetween(1, 10);
        $offset = $this->faker->numberBetween(0, 10);

        $gifsData = [];

        $this->giphyApiService->shouldReceive('getGifs')
            ->once()
            ->with($query, $limit, $offset)
            ->andReturn($gifsData);

        $response = $this->get(route('gifs') . "?query=$query&limit=$limit&offset=$offset");


        $response->assertJson([
            'message' => 'Successfully retrieved gifs!',
            'data' => $gifsData,
        ])->assertStatus(200);
    }

    public function test_show_method_returns_correct_response()
    {
        $gifId = $this->faker->uuid;

        $gifData = [
            "id" => "WiXMlla4ZFR8Q",
            "title" => "loop munching GIF",
            "type" => "gif",
            "url" => "https://giphy.com/gifs/loop-rabbit-WiXMlla4ZFR8Q",
            "embed_url" => "https://giphy.com/embed/WiXMlla4ZFR8Q"
        ];

        $this->giphyApiService->shouldReceive('getGif')
            ->once()
            ->with($gifId)
            ->andReturn($gifData);

        $response = $this->get(route('gif', ['gifId' => $gifId]));

        $response->assertJson([
            'message' => 'Successfully retrieved gif!',
            'data' => $gifData,
        ])->assertStatus(200);
    }

    public function test_show_method_returns_404_when_gif_not_found()
    {
        $gifId = $this->faker->uuid;

        $this->giphyApiService->shouldReceive('getGif')
            ->once()
            ->with($gifId)
            ->andReturn(null);

        $response = $this->get(route('gif', ['gifId' => $gifId]));


        $response->assertJson([
            'message' => 'Gif not found!',
        ])->assertStatus(404);
    }

    public function test_create_method_returns_correct_response()
    {
        $gifId = $this->faker->uuid;
        $alias = $this->faker->word;

        $gif = [
            "id" => "6VRnE4sL9lTyg8ryl7",
            "title" => "No Way Yes GIF by Peter Rabbit Movie",
            "type" => "gif",
            "url" => "https://giphy.com/gifs/PeterRabbitMovie-peter-rabbit-2-pr2-6VRnE4sL9lTyg8ryl7",
            "embed_url" => "https://giphy.com/embed/6VRnE4sL9lTyg8ryl7"
        ];

        $this->giphyApiService->shouldReceive('getGif')
            ->once()
            ->with($gifId)
            ->andReturn($gif);

        $userGif = UserGif::factory()->make([
            'external_id' => $gif['id'],
            'user_id' => auth()->id(),
            'name' => $gif['title'],
            'url' => $gif['url']
        ]);

        $response = $this->post(route('createGif'), [
            'gif_id' => $gifId,
            'alias' => $alias,
        ]);

        $response->assertJson([
            'message' => 'Successfully created gif!',
            'data' => $userGif->toArray(),
        ])->assertStatus(201);
    }
}
