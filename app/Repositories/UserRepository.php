<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserRepository implements UserRepositoryInterface 
{
    public function getAllUser() 
    {   
        return User::all();
    }

    public function getUserId($userId) 
    {
        return User::findOrFail($userId);
    }

    public function deleteUser($userId) 
    {
        User::destroy($userId);
    }

    public function createUser(array $userDetails) 
    {
        $user = User::withTrashed()->where('email',$userDetails['email'])->orWhere('name',$userDetails['name'])->first();
        if(!$user){
            $token = Str::random(40);
            return User::create([
                'name' => $userDetails['name'],
                'email' => $userDetails['email'],
                'countryCode' => $userDetails['countryCode'],
                'contact_number' => $userDetails['contact_number'],
                'client_id' => $userDetails['client_id'],
                'remember_token' => $token
            ]);
        }else{
            return $user->restore();
        }
    }

    public function updateUser($userId, array $newDetails) 
    {
        return User::whereId($userId)->update($newDetails);
    }

    public function getFulfilledusers() 
    {
        return User::where('is_fulfilled', true);
    }
}
