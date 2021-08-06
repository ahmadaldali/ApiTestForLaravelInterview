<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Patterns\Add\AddItem;
use App\Http\Patterns\Delete\DeleteItem;
use App\Http\Patterns\Done\MakeItemDone;
use App\Http\Patterns\Operation;
use App\Http\Patterns\Update\UpdateItem;
use App\Items;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //get all items order by due_date / asc
        $items = clone Items::getAllOrder();
        //check if request ask about status (completed/in_completed)
        if ($request->has('done')) {
            $items = $items->where('done', $request->get('done'));
        }
        //response
        return response()->json($items, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //check from required fields
        $add = new AddItem([
            'title' => 'required|min:2|max:50',
            'body' => 'required|min:2|max:255',
            'media' => 'required|min:2|max:50',
        ]);
        $add_operation = new Operation($add, $request);
        return $add_operation->applyOperation();
    }

    /**
     * update resource using it's id.
     *
     * @param Request $request
     * @return void
     */
    public function updateItem(Request  $request)
    {
        $item = new UpdateItem([
            'id' => 'required',
        ]);
        $item_operation = new Operation($item, $request);
        return $item_operation->applyOperation();
    }


    /**
     * delete resource using it's id.
     *
     * @param Request $request
     * @return void
     */
    public function deleteItem(Request  $request)
    {
        $item = new DeleteItem([
            'id' => 'required',
        ]);
        $item_operation = new Operation($item, $request);
        return $item_operation->applyOperation();
    }

    /**
     * make item done
     *
     * @param Request $request
     * @return void
     */
    public function makeItemDone(Request  $request)
    {
        $item = new MakeItemDone([
            'id' => 'required',
        ]);
        $item_operation = new Operation($item, $request);
        return $item_operation->applyOperation();
    }
}
