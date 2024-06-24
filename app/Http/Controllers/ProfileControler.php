<?php

namespace App\Http\Controllers;

use ApiResponse;
use App\Http\Requests\UpdateUserProfile;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProfileControler extends Controller{

    //update user profile
    public function updateUserProfile(UpdateUserProfile $request){
        $validatedData = $request->validated();
        $userProfile = UserProfile::where('user_id', $validatedData['user_id'])->first();
        if($userProfile == null) {
            if($request->has('image')){
                $image = $request->file('image');
                $imageName = uniqid().'.'.$image->getClientOriginalExtension();
                $image->move('uploads/users/', $imageName);
            }
            $userProfile = new UserProfile();
            $userProfile->user_id = $validatedData['user_id'];
            $userProfile->image = $imageName;
            $userProfile->save();
            
            return ApiResponse::apiResponse(201, "profile created successfuully", $userProfile);
            
        } else {
            //delete the existed image
           
        if ($userProfile->image && File::exists('uploads/users/' . $userProfile->image)) {
            File::delete('uploads/users/' . $userProfile->image);
        }
        if ($request->has('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/users/', $imageName);
        } else {
            $imageName = $userProfile->image;
        }
           $userProfile->update([
            'user_id' => $validatedData['user_id'],
            'image' => $imageName,
           ]);
           if($userProfile){
            $userProfile->image = 'uploads/users/'.$userProfile->image;
           }

           return ApiResponse::apiResponse(200, "profile updated successfuully", $userProfile);
        }
    
    }


    //get user profile 

    public function getUserProfile(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $userProfile = UserProfile::where('user_id', $request->input('user_id'))->first();
        if($userProfile){
            $userProfile->image = 'uploads/users/'.$userProfile->image;
            return ApiResponse::apiResponse(200, "User profile rretrieved successfully", $userProfile);
        } else {
            return ApiResponse::apiResponse(404, "User profile not found");
        }
        
    }
}
