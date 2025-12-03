<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\Rules\Password;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{

   use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    // List all users
    public function index()
    {
      $authUser = JWTAuth::user();
       if (!$authUser)
        {
            return ApiResponse::error(401, null, 'Token not provided');
        }
     $this->authorize('viewAny', $authUser);

    $users = User::with('role')->where('role_id', 2)->get();
      
      return ApiResponse::success(200, $users, 'Users retrieved successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    // Show a specific user
    public function show(string $id)
    {
      
       $authUser = JWTAuth::user();
       if (!$authUser)
        {
            return ApiResponse::error(401, null, 'Token not provided');
        }

      $selectedUser = User::find($id);
      abort_if(!$selectedUser, 404,'User not found');
      $this->authorize('view', $selectedUser);
      return ApiResponse::success(200, $selectedUser, 'User retrieved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    //  Update a specific user
    public function update(Request $request, string $id)
    {
     $authUser = JWTAuth::user();
     abort_if(!$authUser, 401, 'Token not provided');

     $selectedUser = User::find($id);
     abort_if(!$selectedUser, 404, 'User not found');

     $this->authorize('update', $selectedUser);

     $data = $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,' . $selectedUser->id,
        'password' => ['sometimes','confirmed',Password::min(8)->letters()->mixedCase()->numbers()]
     ]);



     $selectedUser->update($data);

     $newToken = null;
     if ($authUser->id === $selectedUser->id) {
         $newToken = JWTAuth::fromUser($selectedUser);
     }

     return ApiResponse::success(200, [
        'user' => $selectedUser,
        'token' => $newToken
     ], 'User updated successfully');
    }




    /**
     * Remove the specified resource from storage.
     */
    // Delete a specific user
    public function destroy(string $id)
    {
      $authUser = JWTAuth::user();
      abort_if(!$authUser, 401, 'Token not provided');

      $selectedUser = User::find($id);

      abort_if(!$selectedUser, 404, 'User not found');

    
      $this->authorize('delete', $selectedUser);

      $selectedUser->delete();
  
      return ApiResponse::success(200, null, 'User deleted successfully');
    }
  }
