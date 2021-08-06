<?php


namespace App\Http\Patterns\Done;

use App\Http\Patterns\IOperations;
use App\Items;

class MakeItemDone implements IOperations
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
        return Items::makeDone($request->id);
    }


    public function getErrorMessage($msg)
    {
        \Illuminate\Support\Facades\Log::info('ERROR IN update item.  ' . $msg);
    }

    public function returnSuccessfulResponse()
    {
        return response(['message' => 'Item is completed now'], 201);
    }

    public function returnFailedResponse()
    {
        return response(['error' => 'set Item completed Failed']);
    }
}
