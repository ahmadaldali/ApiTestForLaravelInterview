<?php


namespace App\Http\Patterns;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Operation
{
    private $implementation;
    private $request;

    public function __construct($implementation, $request)
    {
        $this->implementation = $implementation;
        $this->request = $request;
    }

    public function applyOperation()
    {
        //start transaction
        DB::beginTransaction();
        try {
            //validate passed data from view
            $validator = Validator::make($this->request->all(), $this->implementation->getRule());

            //here validation failed
            if ($validator->fails()) {
                $errors = "";
                foreach ($validator->getMessageBag()->getMessages() as $key => $error_messages) {
                    foreach ($error_messages as  $error_message) {
                        $errors = $errors . $error_message . "\n";
                    }
                }

                //return faild msg
                $this->implementation->getErrorMessage($errors);
                return $this->implementation->returnFailedResponse();

            } else {

                //validation ok, so check from response of function / true or false
                if ($this->implementation->doOperation($this->request)) {
                    //commit change - everything is ok
                    DB::commit();
                    //return successful msg
                    return $this->implementation->returnSuccessfulResponse();
                }

                //if reach here so function return false so return failed msg
                DB::rollBack();
                return $this->implementation->returnFailedResponse();
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->implementation->getErrorMessage($exception->getMessage());
            return $this->implementation->returnFailedResponse();
        }
    }

}
