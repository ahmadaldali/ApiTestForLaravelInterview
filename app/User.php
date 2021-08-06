<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;



class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * find user
     *
     * @param [type] $email
     * @param [type] $password
     */
    public static function findUserByEmailAndPassword($email, $password)
    {
        //check from user is exist or no

        //password is hashing so we can compare with hashed value (can't do revers hashing)
        //so, firstly check if entered email is exist
        $user = User::where('email', $email)->first();
        if ($user) {
            //if email is exist, then do hashing on entered password and compare
            if (Hash::check($password, $user->password)) {
                //matching then return user
                return $user;
            }
        }
        //if we reach here, this mean either email or password is not correct so return null
        return null;
    }

}
