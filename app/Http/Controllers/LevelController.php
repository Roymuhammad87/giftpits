<?php

namespace App\Http\Controllers;

use ApiResponse;
use App\Models\Level;
use App\Models\Score;
use App\Models\Question;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use App\Models\AnsweredQuestion;
use App\Http\Requests\LevelRequest;

class LevelController extends Controller{

   //get all levels

   public function index() {
    $data = Level::all();

    if(count($data) > 0) {
        return ApiResponse::apiResponse(200, "Levels retrieved successfully", $data);
    } else {
        return ApiResponse::apiResponse(404, "No Levels found");
    }
   }

 //insert new level
  public function store(LevelRequest $request) {

    $validatedData = $request->validated();

    $file = $request->image;
    if($file){
        $name = uniqid().'-'.$file->extension();
        $path = 'uploads/levels/';
        $file->move($path, $name);
        $image  =  $path.$name;
    }

    $level = Level::create([
        'name' => $validatedData['name'],
        'image'=>$image
    ]);

    if($level) {
        return ApiResponse::apiResponse(201, "Level created successfully", $level);
    } else {
        return ApiResponse::apiResponse(400, "Failed to create level");
    }
   }  

   //Get all completed levels for the user
  
  public function getCompletedLevels(Request $request) {
     
     $request->validate([
        'user_id' => 'required|integer|exists:users,id'
     ]);

     $completedLevels = UserProgress::where('user_id', $request->input('user_id'))->get();
     $data = [];
     foreach($completedLevels as $completedLevel) {
        $data[] = [
            'id' => $completedLevel->id,
            'user_id'=>$completedLevel->user_id,
            'level_id'=>$completedLevel->level_id,
            'is_level_completed'=>($completedLevel->is_level_completed) == 1? true : false,

        ];
     }
     
     if(count($data) > 0 ) {
       return ApiResponse::apiResponse(200, "Completed levels", $data);
    } else {
    return ApiResponse::apiResponse(404, "No completed levels found");
    }
  }

  //insert answered questions


         
   //change the level to completed after user answers to all questions

   public function markLevelCompleted(Request $request) {

     $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'level_id' => 'required|integer|exists:levels,id',
        'is_level_completed' => 'required|boolean'
       
        ]);

        $userProgress = UserProgress::create([
            'user_id' => $request->input('user_id'),
            'level_id' => $request->input('level_id'),
            'is_level_completed' =>$request->input('is_level_completed'),

        ]);
      

        if($userProgress) {
            return ApiResponse::apiResponse(201, "Level marked as completed successfully", $userProgress);
        
        } else {
            return ApiResponse::apiResponse(400, "Failed to mark level as completed");
        }
   }
  }


