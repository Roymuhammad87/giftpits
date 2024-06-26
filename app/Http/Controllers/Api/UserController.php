<?php

namespace App\Http\Controllers\Api;

use ApiResponse;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return ApiResponse::apiResponse(200, "", $users);
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
    public function show(string $id)
    {
        //
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
    public function update(UpdateUserRequest $request){
    
        $validateData = $request->validated();
        $user = User::findOrFail($validateData['id']);
        if($user->id == Auth::id()){
            $user->username = $validateData['username']?:$user->username;
            $user->email = $validateData['email']?:$user->email;
            $user->save();
            $data = [
                'id' => $user->id,
                'username' =>$user->username,
                'email' =>$user->email,

            ];
            return ApiResponse::apiResponse(200,
             'User info updated successsfully',
             $data);
        } else {
            return ApiResponse::apiResponse(403, "You are not authorized to update this user");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request ,int $id){

        $user = User::findOrFail($id);
        $userProfile = UserProfile::where('user_id', $id)->first();
        if ($userProfile->image && File::exists('uploads/users/' . $userProfile->image)) {
            File::delete('uploads/users/' . $userProfile->image);
            }
        if($user){
            $request->user()->currentAccessToken()->delete();
            $user->delete();
            return ApiResponse::apiResponse(200, "Account deleted successfully", []);
        } else {
            return ApiResponse::apiResponse(404, "Account not found", []);
        }
    }
}
