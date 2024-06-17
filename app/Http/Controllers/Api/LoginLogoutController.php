<?php

namespace App\Http\Controllers\Api;

use ApiResponse;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LoginLogoutController extends Controller{

    public function login(LoginRequest $request){
    

        $loginData = $request->validated();
        if (Auth::guard('web')->attempt([
            'email' => $loginData['email'],
            'password' => $loginData['password'] ]))
        {

            // $user = auth()->user();
            $user = Auth::guard('web')->user();
            $currentUser = User::where('email', '=', $user->email)->first();
            $token = $currentUser->createToken('auth_token')->plainTextToken;
            $data = [
                'id'=>$currentUser->id,
                'name' => $currentUser->username,
                'email' => $currentUser->email,
                'token' => $token
            ];
            return ApiResponse::apiResponse(200, 'Logged in suuccessfully', $data);
        } else {
            return ApiResponse::apiResponse(401, 'Invalid credentials',['error'=>'Invalid credentials']);
        }
    }


    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();
        return ApiResponse::apiResponse(200, 'Logged out successfully');
    }


    public function verifyEmailAddress($email) {
        $user = User::where('email', '=', $email)->first();
        if($user) {

            $token = Str::random(40);
            $domain = URL::to('/');
            $url = $domain.'/verify-email?token='.$token;

            $data['url'] = $url;
            $data['email'] = $user->email;
            $data['title'] = "Email Verification" ;
            $data['body'] = "Please verify your email address";

            Mail::send('users.verifyEmail', ['data'=>$data], function ($message) use ($data) {
             
                $message->to($data['email'])->subject($data['title']);
            });

            $user->remember_token = $token;
            $user->save();
            return ApiResponse::apiResponse(200, 'Verification Email was sent to your email address');
        } else {
            return ApiResponse::apiResponse(404, 'Email address is not available');
        }
    }


    public function emailVerification(Request $request) {
        $token = $request->token;
        $user = User::where('remember_token', '=', $token)->first();
        if($user) {
            $user->email_verified_at = Carbon::now();
            $user->remember_token ='';
            $user->save();
            return ApiResponse::apiResponse(200, 'Email address verified successfully');
        } else {
            return ApiResponse::apiResponse(404, 'Invalid verification Email');
        }
    }
}
