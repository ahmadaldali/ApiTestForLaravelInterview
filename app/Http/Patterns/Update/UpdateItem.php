<?php


namespace App\Http\Patterns\Update;

use App\Http\Patterns\IOperations;
use App\Items;
use Illuminate\Support\Facades\Log;

class UpdateItem implements IOperations
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
        return Items::updateInstance($request);
    }


    public function getErrorMessage($msg)
    {
        \Illuminate\Support\Facades\Log::info('ERROR IN update item.  '. $msg);
    }

    public function returnSuccessfulResponse()
    {
        return response(['message' => 'Updated successfully'], 201);

    }

    public function returnFailedResponse()
    {
        return response(['error' => 'Updated Failed']);
    }


}
