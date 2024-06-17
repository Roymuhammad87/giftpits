<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller{

    public function forgetPassword(Request $request) {

        $resetData = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $resetData['email'])->first();
       
        if ($user) {
            $token = Str::random(40);
            $domain = URL::to('/');
            $url = $domain . '/reset-password?token=' . $token;
            $resetData['url'] = $url;
            $resetData['title'] = "Password Rest";
            $resetData['email'] = $user->email;
            $resetData['body'] ="Please click on the below link to reset password";

            Mail::send('users.forgetPasswordEmail',['data'=>$resetData], function($message) use ($resetData){
                $message->to($resetData['email'])->subject($resetData['title']);
        
            });
            
            PasswordReset::updateOrCreate(
                ['email'=>$request->email],
                [
                    'token'=>$token,
                    'created_at'=>now()
                ]
            );
            return response()->json([
                'message' => 'Password reset link sent on your email.',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Email not found.',
                'status' => 404
            ]);
        }
    }

    public function resetPasswordLoad(Request $request) {
        $data = PasswordReset::where('token','=', $request->token)->get();
        if ($data->isEmpty()) {
            return "No matching records found for the provided token.";
        }
        $email = $data[0]->email;
        $user = User::where('email','=', $email)->first();
        if ($user == null) {
            return "No matching records found for the provided token.";
        }
        return view('users.resetPasswordForm', compact('user'));
    }

    public function resetPassword(Request $request, $id){
        $user = User::FindOrFail($id);
        $validatedData =$request->validate([
            'password'=>'required|min:6'
        ]);
        if($validatedData){
            $user->password = bcrypt($request->password);
            $user->save();
            PasswordReset::where('email', $user->email)->delete();
          return view('users.passwordChanged', compact('user'));
        } else {
            return view('users.resetPasswordForm', compact('user'));

        }

    }
        

}
