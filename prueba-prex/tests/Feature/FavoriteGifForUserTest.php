<?php

namespace Tests\Feature;

use App\Models\GifFavorite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoriteGifForUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_add_a_gif_to_favorites()
    {
        $user = User::factory()->create();

        $data = [
            'user_id' => $user->id,
            'gif_id' => "123abc",
            'alias' => 'Funny Gif'
        ];


        $response = $this->postJson('/api/gif/favorite', $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'GIF added to favorites successfully',
                'favorite' => [
                    'user_id' => $user->id,
                    'gif_id' => $data['gif_id'],
                    'alias' => $data['alias'],
                ]
            ]);

        $this->assertDatabaseHas('gif_favorites', [
            'user_id' => $user->id,
            'gif_id' => $data['gif_id'],
            'alias' => $data['alias'],
        ]);
    }

    /** @test */
    public function it_cannot_add_the_same_gif_to_favorites_twice()
    {
        $user = User::factory()->create();

        GifFavorite::create([
            'user_id' => $user->id,
            'gif_id' => "123abc",
            'alias' => 'Funny Gif'
        ]);

        $data = [
            'user_id' => $user->id,
            'gif_id' => "123abc",
            'alias' => 'Funny Gif Again'
        ];

        $response = $this->postJson('/api/gif/favorite', $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'GIF already favorited'
            ]);
    }
}
