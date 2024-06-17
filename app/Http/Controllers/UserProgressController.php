<?php

namespace App\Http\Controllers;

use ApiResponse;
use App\Models\Level;
use App\Models\Score;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use App\Models\AnsweredQuestion;
use Illuminate\Support\Facades\Auth;

class UserProgressController extends Controller{



    public function saveProgress(Request $request){
    
        $request->validate([
            'level_id' => 'required|integer',
            'current_question_index' => 'required|integer',
            'correct_question_ids' => 'required|array',
            'is_level_completed' => 'required|boolean',
        ]);

        // Save progress for the level
        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'level_id' => $request->level_id,
            ],
            [
                'current_question_index' => $request->current_question_index,
                'is_level_completed' => $request->is_level_completed,
            ]
        );

        // Save answered questions
        foreach ($request->correct_question_ids as $questionId) {
            AnsweredQuestion::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'question_id' => $questionId,
                ]
            );
        }

        // Check if all questions in the level are answered correctly
        $levelQuestionsCount = Level::find($request->level_id)->questions()->count();
        $answeredQuestionsCount = AnsweredQuestion::where('user_id', Auth::id())
                                                  ->whereHas('question', function ($query) use ($request) {
                                                      $query->where('level_id', $request->level_id);
                                                  })->count();

        if ($answeredQuestionsCount == $levelQuestionsCount) {
            $progress->is_level_completed = true;
            $progress->save();
        }

        return response()->json($progress, 200);
    }

    public function getProgress(Request $request)
    {
        $request->validate([
            'level_id' => 'required|integer',
        ]);

        $progress = UserProgress::where('user_id', Auth::id())
                                ->where('level_id', $request->level_id)
                                ->first();

        $answeredQuestions = AnsweredQuestion::where('user_id', Auth::id())
                                             ->whereHas('question', function ($query) use ($request) {
                                                 $query->where('level_id', $request->level_id);
                                             })->pluck('question_id');

        return response()->json([
            'progress' => $progress,
            'answered_questions' => $answeredQuestions,
        ], 200);
    }
        
}

    

