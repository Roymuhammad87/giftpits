<?php

namespace App\Http\Controllers\Api;

use ApiResponse;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)  {
  
        $userData = $request->validated();
        $user = User::create([
            'username'=>$userData['username'],
            'email'=>$userData['email'],
            'password'=>bcrypt($userData['password']),
        ]);
        // $token = $user->createToken('auth_token')->plainTextToken;
        $data = [
            'id'=>$user->id,
            'username'=>$user->username,
            'email'=>$user->email,
        ];
        if($user) {
            return ApiResponse::apiResponse(201, 'Account created successfully', $data);
        } else {
            return ApiResponse::apiResponse(422, 'Invalid credentials');
        }
    }
}
