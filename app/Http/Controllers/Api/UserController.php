<?php

namespace App\Http\Controllers\Api;

use ApiResponse;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
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
        $user = User::where('id', '=', $validateData['id'])->first();
        
        //check if the id of authenticated user is the same in validated data
        if($user->id == $validateData['id']){
           $user->username = $validateData['username']?:$user->username;
           $user->email = $validateData['email']?:$user->email;
            if($request->has('image')){
                $file = $request->file('image');
                $fileName = uniqid() . '-' . Str::slug($user->username, '-') . '.' . $file->extension();
                $filePath = 'uploads/users/';
                $file->move($filePath, $fileName);
                $image  =  $filePath . $fileName;
            }
            $user->image = $image?:"";
            dd($user);
             if($user->save()){
                return ApiResponse::apiResponse(200, "Updated successfully", $user);
              } else {
              return ApiResponse::apiResponse(400, "Failed to update", null);
              }
        } else {
            return ApiResponse::apiResponse(401, "unauthenticated", []);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request ,int $id){

        $user = User::findOrFail($id);
        if($user){
            $request->user()->currentAccessToken()->delete();
            $user->delete();
            return ApiResponse::apiResponse(200, "Account deleted successfully", []);
        } else {
            return ApiResponse::apiResponse(404, "Account not found", []);
        }
    }
}
