<?php

namespace App\Http\Controllers;

use ApiResponse;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RewardController extends Controller {


    public function claimDailyReward(Request $request) {
   
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'score' => 'required|integer'
        ]);

        $user = User::where('id', $request->input('user_id'))->first();
           if ($user && $user->canClaimDailyReward()) {
            $rewardAmount = $request->input('score'); 
            // Update the user's score
            $score = Score::where('user_id', $user->id)->first();
            $score->score += $rewardAmount;
            $score->save();

            // Update the last reward claimed timestamp (server-side)
            $user->last_reward_claimed_at = Carbon::now();
            $user->save();
            return ApiResponse::apiResponse(200, "Daily reward claimed!", $score);
        } else {
            return ApiResponse::apiResponse(200, "Daily reward already claimed.", null);
        }
    }

    
}
