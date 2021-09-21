<?php

namespace Tests\Feature;

use App\Enums\EventStatus;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class ItemTest extends TestCase
{
    use DatabaseMigrations;

    public function testItem()
    {
        $incorrectPayload = [];
        $correctPayload = [
            'name' => 'The Legend of Zelda: Ocarina of Time',
            'publisher' => 'Nintendo',
            'year' => '1998',
            'img_url' => 'https://upload.wikimedia.org/wikipedia/en/8/8e/The_Legend_of_Zelda_Ocarina_of_Time_box_art.png'
        ];

        $response = $this->postJson('/api/item', $incorrectPayload);
        $response->assertStatus(422);

        $response = $this->postJson('/api/item', $correctPayload);
        $response->assertStatus(200); //todo should be 201

        $response = $this->get('/api/item/1');
        $response->assertStatus(200);

        $response = $this->get('/api/item/2');
        $response->assertStatus(404);

        $response = $this->get('/api/item');
        $response->assertStatus(200);
        $this->assertEquals(1, count($response->json()['data'])); //assert only 1 record created

    }
}
