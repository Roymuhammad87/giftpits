<?php

namespace App\Http\Controllers;

use ApiResponse;
use App\Models\Level;
use App\Models\Score;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use App\Models\AnsweredQuestion;
use App\Models\Question;
use App\Models\User;
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

        return ApiResponse::apiResponse(200, "successfully saved progress", $progress);
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

       $data = [
        'progress' => $progress,
        'answered_questions' => $answeredQuestions,
       ];
        return ApiResponse::apiResponse(200,
         "successfully saved progress",
         $data);
    }

    //Store answered questtions
    
    public function store(Request $request) {
        $request ->validate([
            'user_id'=>'required|integer|exists:users,id',
            'question_id' => 'required|integer|exists:questions,id',
            'score'=>'required|integer',
            'correct_answers_ids'=>'required|array'
        ]);
        $answeredQuestion = AnsweredQuestion::create([
             'user_id'=> $request->input('user_id'),
             'question_id'=>$request->input('question_id'),
        ]);
        $score = Score::where('user_id', $request->input('user_id'))->first();
        $score->update([
            'score'=>$score->score + $request->input('score'),
        ]);
       $question = Question::where('id', $request->input('question_id'))->first();
       $level = $question->level;
       $levelQuestionsCount = Question::where('level_id', $level->id)->get();

       $progress = UserProgress::updateOrCreate(
        [
            'user_id' => $request->input('user_id'),
            'level_id' => $level->id,
        ],
        [
            'current_question_index' => $request->input('question_id'),
            'is_level_completed' => false
        ]
    );
       if(count($levelQuestionsCount) == count($request->input('correct_answers_ids'))){

        $progress->update([
            'is_level_completed'=>true,
            ]);
         }

        if($answeredQuestion) {
            return ApiResponse::apiResponse(201, 'inserted successfully',
            $answeredQuestion);
        } else {
            return ApiResponse::apiResponse(400, 'insertion failed');
        }
    
    }

    public function getAnsweredQuestions(Request $request) {
        $request ->validate([
            'user_id'=>'required|integer|exists:users,id',
        ]);

        $answeredQuestions = AnsweredQuestion::where('user_id', $request->input('user_id'))->get();
        $ids = array();
        foreach($answeredQuestions as $answeredQuestion) {
            array_push($ids, $answeredQuestion->question_id);
            }
        if(count($answeredQuestions) > 0) {
            return ApiResponse::apiResponse(200, 'successfully retrieved',
            $ids);
        } else {
            return ApiResponse::apiResponse(404, 'no data found');
        }
    }

    public function isLevelCompleted(Request $request) {
        $request ->validate([
            'user_id'=>'required|integer|exists:users,id',
            'level_name'=>'required|string|exists:levels,name',
            ]);
            $levelId = Level::where('name', $request->input('level_name'))->first()->id;
            $progress = UserProgress::where('user_id', $request->input('user_id'))->where
            ('level_id', $levelId)->first();
            if($progress) {
                if($progress->is_level_completed) {
                return ApiResponse::apiResponse(200, 'level is completed', 
                true);
                } else {
                    return ApiResponse::apiResponse(200, 'level is not completed',
                    false);
                    }
            } else {
                return ApiResponse::apiResponse(200, 'user did not enter this level yet',
            false);
            }
            

    }
        
}

    

