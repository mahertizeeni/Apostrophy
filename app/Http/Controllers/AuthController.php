<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    // Register a new user
    public function register(RegisterRequest $request)
    {  
        $user = User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>$request->password,
        'role_id'=>2
                          ]);    

        $token = JWTAuth::fromUser($user);
        return ApiResponse::success(201 , ['user' => $user, 'token' => $token],'User registered successfully');
    }

    // Login to exist user
    public function login(Request $request)
    { 
         $data = $request->validate([
        'email' => 'required|string',
        'password' => 'required|string',
                                 ]);

        $user = User::where('email', $data['email'])->first();
        if(!$user) {
            return ApiResponse::error(401, null,'user not found');
                   }
         if (!Hash::check($data['password'], $user->password)) {
        return ApiResponse::error(401, null, 'Invalid credentials');
          }
      $user->load('role');
      $token = JWTAuth::fromUser($user);
     return ApiResponse::success(200, ['user' =>
         [
              'id' => $user->id,
              'name' => $user->name,
              'email' => $user->email,
              'role' => $user->role->name,
          ]
       , 'token' => $token],'User logged in successfully');

    }

    // Logout user
    public function logout()
    {
        try{      
      $token = JWTAuth::getToken();
      if(!$token)
      {
        return ApiResponse::error(401, null, 'Token not provided');
      }
      JWTAuth::invalidate($token);
      return ApiResponse::success(200, null, 'Successfully logged out');
    }
    catch(\Exception $e) {
        Log::error('Logout error: '.$e->getMessage());
        return ApiResponse::error(500, null,'Failed to logout, please try again');
    }
   }

}