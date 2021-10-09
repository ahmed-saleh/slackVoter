<?php

namespace Tests\Feature;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class EventVoteTest extends TestCase
{
    use DatabaseMigrations;

    public function testEvent()
    {
        $user = User::factory(1)->create()[0];
        $newToken = $user->createToken('leToken');
        [$id, $token] = explode('|', $newToken->plainTextToken);
        $items = Item::factory(2)->create();
        $newItem = Item::factory(1)->create();
        $event = Event::factory(1)->create()[0];

        foreach ($items as $singleItem) {
            $event->items()->save($singleItem);
        }

        $response = $this->get('/api/event/1', ['Authorization'=> "Bearer $token"]);
        $res = $response->json();
        $this->assertEquals(2, count($res['items']));

        $response = $this->put('/api/event/1/vote', ['item_id' => 1, 'action' => 'add']);
        $response->assertStatus(200);

        $response = $this->get('/api/event/1');
        $res = $response->json();
        $this->assertEquals(1, $res['items'][0]['pivot']['vote_count']);
        $this->assertEquals(0, $res['items'][1]['pivot']['vote_count']);


        $response = $this->put('/api/event/1/vote', ['item_id' => 1, 'action' => 'remove']);
        $response->assertStatus(200);

        $response = $this->put('/api/event/1/vote', ['item_id' => $newItem[0]['id'], 'action' => 'remove']);
        $response->assertStatus(422);

        $response = $this->get('/api/event/1');
        $res = $response->json();
        $this->assertEquals(0, $res['items'][0]['pivot']['vote_count']);
        $this->assertEquals(0, $res['items'][1]['pivot']['vote_count']);


        # Testing the oder of items, if it is based on vote count
        $response = $this->put('/api/event/1/vote', ['item_id' => 2, 'action' => 'add']);
        $response->assertStatus(200);

        $response = $this->get('/api/event/1');
        $res = $response->json();
        $this->assertEquals(1, $res['items'][0]['pivot']['vote_count']);
        $this->assertEquals(2, $res['items'][0]['id']);
        $this->assertEquals(0, $res['items'][1]['pivot']['vote_count']);
    }
}
