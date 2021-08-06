<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * login function
     *
     * @param Request $request
     */
    public function login(Request $request)
    {
        //check if this user is exit or no
        $user = User::findUserByEmailAndPassword(
            $request->email,
            $request->password
        );

        //if exist
        if ($user) {
            //return user with token
            $accessToken =  $user->createToken('authToken')->accessToken;
            return response(['user' => $user, 'access_token' => $accessToken ,'message' => 'Logged In Successfully']);
        }
        //failed login
        return response(['message' => 'This User does not exist, check your details'], 400);
    }

    public function logout (Request $request) {

        Log::info($request->user());
        //revoke token
         $token = $request->user()->token();
         $token->revoke();
         $response = ['message' => 'You have been successfully logged out!'];
         return response($response, 200);

     }

}
