<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetGifByIdTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_get_gif_by_id()
    {
        $response = $this->getJson('/api/giphy/gif/Fu3OjBQiCs3s0ZuLY3');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'gif',
            ]);
    }
}
