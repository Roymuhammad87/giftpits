<?php

namespace App\Http\Controllers;

use ApiResponse;
use App\Models\Score;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProgressController extends Controller{

    public function saveProgress(Request $request)
    {
        $request->validate([
            'level_id' => 'required|integer',
            'current_question_index' => 'required|integer',
            'score' => 'required|integer',
            'is_level_completed' => 'required|boolean',
        ]);

        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'level_id' => $request->level_id,
            ],
            [
                'current_question_index' => $request->current_question_index,
                'completed' => $request->is_level_completed,
            ]
        );

        if (!$progress->completed) {
            $totalScore = Score::firstOrCreate(
                ['user_id' => Auth::id()],
                ['score' => 0]
            );

            $totalScore->score += $request->score;
            $totalScore->save();
        } elseif ($progress->wasRecentlyCreated) {
            // If progress was marked completed for the first time, reward score
            $totalScore = Score::firstOrCreate(
                ['user_id' => Auth::id()],
                ['score' => 0]
            );

            $totalScore->score += $request->score;
            $totalScore->save();
        }

        return ApiResponse::apiResponse(200, 'successfully rewarded', $progress);
    }

    public function getProgress(Request $request){
        $request->validate([
            'level_id' => 'required|integer',
        ]);

        $progress = UserProgress::where('user_id', Auth::id())
                                ->where('level_id', $request->level_id)
                                ->first();

                                return ApiResponse::apiResponse(200, 'successfully rewarded', $progress);
    }

    
}
