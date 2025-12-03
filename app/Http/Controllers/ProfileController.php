<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProfileController extends Controller
{
 use AuthorizesRequests;
 // User profile details
    public function show()
    {
        $user = JWTAuth::user();
        abort_if(!$user, 401, 'Unauthorized');
        $this->authorize('view', $user);
        return ApiResponse::success(200 , $user , 'User retrieved successfully');
    }
    // Update user profile 
    public function update(Request $request)
    {
        $user = JWTAuth::user();
        abort_if(!$user, 401, 'Unauthorized');
        $this->authorize('update', $user);
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
             'password' => ['sometimes','confirmed',Password::min(8)->letters()->mixedCase()->numbers()],

        ]);
        $user->update($request->only(['name', 'email', 'password']));
        $newToken = JWTAuth::fromUser($user);
        return ApiResponse::success(200, [
            'user' => $user,
            'token' => $newToken
        ], 'Profile updated successfully');    
    }

    public function destroy()
    {
        $user = JWTAuth::user();
        abort_if(!$user, 401, 'Unauthorized');
        $this->authorize('delete', $user);
        $user->delete();
        return ApiResponse::success(200, null, 'Profile deleted successfully');
    }
}