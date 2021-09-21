<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemCreateRequest;
use App\Models\Item;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{

    /**
     * Get single Item
     *
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function index()
    {
        return DB::table('items')->simplePaginate(10);
    }

    /**
     * Create new Item
     *
     * @param ItemCreateRequest $request
     * @return mixed|string
     */
    public function store(ItemCreateRequest $request)
    {
        $data = $request->all();
        try {
            DB::beginTransaction();

            $item = new Item($data);
            $item->save();

            DB::commit();
            return $item->id;
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }

    /**
     * Show a single Item
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return Item::findOrFail($id);
    }

}
