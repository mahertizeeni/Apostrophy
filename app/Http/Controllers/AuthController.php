<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {  $user = User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>$request->password,
        'role'=>'user'
    ]);    

    $token = JWTAuth::fromUser($user);
    return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request)
    {  $data = $request->validate([
        'email' => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $data['email'])->first();
    if(!$user) {
        return response()->json(['error' => 'user not found'], 401);
    }
    if (!Hash::check($data['password'], $user->password)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }
    $token = JWTAuth::fromUser($user);
    return response()->json(['user' =>
    [
    'id' => $user->id,
    'name' => $user->name,
    'email' => $user->email,
    'role' => $user->role,
    ]
    , 'token' => $token], 200);

    }
}
