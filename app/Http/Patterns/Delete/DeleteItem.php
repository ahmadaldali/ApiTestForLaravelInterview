<?php


namespace App\Http\Patterns\Delete;

use App\Http\Patterns\IOperations;
use App\Items;

class DeleteItem implements IOperations
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
        return Items::deleteInstance($request->id);
    }


    public function getErrorMessage($msg)
    {
        \Illuminate\Support\Facades\Log::info('ERROR IN delete item.  '. $msg);
    }

    public function returnSuccessfulResponse()
    {
        return response(['message' => 'Deleted successfully'], 201);

    }

    public function returnFailedResponse()
    {
        return response(['error' => 'Deleted Failed']);
    }


}
