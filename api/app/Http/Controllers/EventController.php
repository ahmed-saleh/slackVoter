<?php

namespace App\Http\Controllers;

use App\Enums\EventActions;
use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Models\Event;
use App\Models\Item;
use Exception;
use Illuminate\Support\Facades\DB;


class EventController extends Controller
{

    /**
     * List Events with pagination
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function index()
    {
        return DB::table('events')->simplePaginate(10);
    }

    /**
     * Store an Event
     *
     * @param EventCreateRequest $request
     * @return mixed|string
     */
    public function store(EventCreateRequest $request)
    {
        $data = $request->all();
        try {
            DB::beginTransaction();

            $event = new Event($data);
            $event->save();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
        return $event->id;
    }


    /**
     * Get single Event with its relative information
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static|static[]
     */
    public function show($id)
    {
        return Event::with('items')->findOrFail($id);
    }


    /**
     * Add items or remove them from an Event
     *
     * @param EventUpdateRequest $request
     * @param $id
     * @return string
     * //TODO: add an update function to Update other relative information about the event
     */
    public function update(EventUpdateRequest $request, $id)
    {
        $payload = $request->all();
        //TODO: handle this API and the correct error messages
        $event = Event::findOrFail($id);
        $item = Item::findOrFail($payload['item_id']);
        try {
            DB::beginTransaction();
            if($payload['action'] === EventActions::Add) {
                $event->items()->attach($item);
            } else {
                $event->items()->detach($item);
            }
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
        return $event;
    }

    /**
     * Cast or remove a Vote for an item for an Event
     *
     * @param EventUpdateRequest $request
     * @param $id
     * @return string
     */
    public function vote(EventUpdateRequest $request, $id)
    {
        $payload = $request->all();
        $event = Event::findOrFail($id);
        $record = $event->items()->where('item_id', $payload['item_id'])->first();
        if(empty($record)){
            return response('Item is not In this event', 422);
        }
        try {
            DB::beginTransaction();
            if($payload['action'] === EventActions::Add) {
                $event->items()->newPivotStatement()->where('item_id', $payload['item_id'])->increment('vote_count');
            } else {
                $event->items()->newPivotStatement()->where('item_id', $payload['item_id'])->decrement('vote_count');
            }
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
        return response('Vote updated', 200);
    }
}
