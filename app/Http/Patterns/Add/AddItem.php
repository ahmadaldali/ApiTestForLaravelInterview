<?php


namespace App\Http\Patterns\Add;

use App\Http\Patterns\IOperations;
use App\Items;
use Illuminate\Support\Facades\Log;

class AddItem implements IOperations
{
    private $rules;

    public function __construct($rules)
    {
        $this->rules = $rules;
    }

    public function getRule()
    {
        return $this->rules;
    }

    public function doOperation($request)
    {
        //collect item data
        $item_data = [];
        $item_data['title'] = $request['title'];
        $item_data['body'] = $request['body'];
        $item_data['media'] = $request['media'];
        $item_data['done'] = isset($request['done']) ? json_decode($request['done']) : false;
        $item_data['due_date'] = isset($request['due_date']) ? date($request['due_date']) : null;

        //decode reminders array
        $reminders_data = isset($request['reminders']) ? json_decode($request->reminders) : [];

        //create a new item by call my create method
        return Items::addNewInstance($item_data, $reminders_data);
    }


    public function getErrorMessage($msg)
    {
        \Illuminate\Support\Facades\Log::info('ERROR IN ADD item.  ' . $msg);
    }

    public function returnSuccessfulResponse()
    {
        return response(['message' => 'Created successfully'], 201);
    }

    public function returnFailedResponse()
    {
        return response(['error' => 'Created Failed']);
    }
}
