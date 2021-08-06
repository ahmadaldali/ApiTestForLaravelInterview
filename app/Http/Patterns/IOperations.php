<?php


namespace App\Http\Patterns;


interface IOperations
{
   public function getRule();
   public function doOperation($request);
   public function getErrorMessage($msg);
   public function returnSuccessfulResponse();
   public function returnFailedResponse();

}
