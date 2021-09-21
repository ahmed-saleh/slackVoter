<?php

namespace Tests\Feature;

use App\Enums\EventStatus;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class EventTest extends TestCase
{
    use DatabaseMigrations;

    public function testEvent()
    {
        $incorrectPayload = [];
        $correctPayload = [
            'name' => 'N64 new game hooray',
            'status'=> EventStatus::Active(), // 1
        ];

        $response = $this->postJson('/api/event', $incorrectPayload);
        $response->assertStatus(422);

        $response = $this->postJson('/api/event', $correctPayload);
        $response->assertStatus(200);

        $response = $this->get('/api/event/1');
        $response->assertStatus(200);

        $response = $this->get('/api/event/2');
        $response->assertStatus(404);

        $response = $this->get('/api/event');
        $response->assertStatus(200);
        $this->assertEquals(1, count($response->json()['data'])); //assert only 1 record created

    }
}
