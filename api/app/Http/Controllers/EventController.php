<?php

namespace App\Http\Controllers;

use App\Enums\EventActions;
use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Models\Event;
use App\Models\Item;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('events')->simplePaginate(10);
    }

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Event::with('items')->findOrFail($id);
    }


    /**
     * @param EventUpdateRequest $request
     * @param $id
     * @return string
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


    public function vote(EventUpdateRequest $request, $id)
    {
        $payload = $request->all();
        $event = Event::findOrFail($id);
        $record = $event->items()->where('id', $payload['item_id']);
        if(empty($record)){
            response('Item is not In this event', 422);
        }
        try {
            DB::beginTransaction();
            if($payload['action'] === EventActions::Add) {
                $event->items()->newPivotStatement()->where('id', $payload['item_id'])->increment('vote_count');
            } else {
                $event->items()->newPivotStatement()->where('id', $payload['item_id'])->decrement('vote_count');
            }
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
        response('Vote updated', 200);
    }
}
