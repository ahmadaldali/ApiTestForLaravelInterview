<?php

use API\ItemsController;
use App\Http\Controllers\API\AuthController as APIAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//login
Route::post('login', [APIAuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {

    //get current user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    //logout
    Route::post('logout', [APIAuthController::class, 'logout']);

    //items route
    Route::apiResource('items', ItemsController::class);

    //my update & delete functions to access to item by its id
    Route::put('item', 'API\ItemsController@updateItem');
    Route::delete('item', 'API\ItemsController@deleteItem');

    //make item done
    Route::put('make_item_done', 'API\ItemsController@makeItemDone');
});
