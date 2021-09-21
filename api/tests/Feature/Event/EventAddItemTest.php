<?php

namespace Tests\Feature;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\Item;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class EventAddItemTest extends TestCase
{
    use DatabaseMigrations;

    public function testEvent()
    {
        $items = Item::factory(10)->create();
        $event = Event::factory(1)->create()[0];

        $response = $this->putJson('/api/event/1', ['item_id' => 4, 'action' => 'add']);
        $response->assertStatus(200);

        $response = $this->putJson('/api/event/1', ['item_id' => 2, 'action' => 'add']);
        $response->assertStatus(200);

        $response = $this->get('/api/event/1');
        $response->assertStatus(200);
        $res = $response->json();
        $this->assertEquals('4',$res['items'][0]['id']);
        $this->assertEquals(2, count($res['items']));

        $response = $this->putJson('/api/event/1', ['item_id' => 2, 'action' => 'remove']);
        $response->assertStatus(200);
        $response = $this->get('/api/event/1');
        $res = $response->json();
        $this->assertEquals(1, count($res['items']));
    }
}
