<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchGifsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_can_search_gifs()
    {
        $response = $this->getJson('/api/giphy/gifs?query=funny');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'gifs',
                'pagination' => [
                    'total_count',
                    'count',
                    'offset'
                ]
            ]);
    }
}
