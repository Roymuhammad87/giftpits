<?php

namespace App\Http\Controllers;

use ApiResponse;
use App\Models\Level;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;

class QuestionController extends Controller {

    //get  questions by level name
   public function index(string $name){
    $level = Level::where('name',$name)->first();
    $id = $level->id;
    $questions = Question::where('level_id',$id)->get();
    if(count($questions) > 0 ) {
       return ApiResponse::apiResponse(200, "Questions retrieved successfully", $questions);
    } else {
       return ApiResponse::apiResponse(404, "No questions found for this category");
    }
 }

 //function for getting all questions
 public function getAllQuestions(){
    $questions = Question::all();
    if(count($questions) > 0 ) {
       return ApiResponse::apiResponse(200, "All questions retrieved successfully", $questions);
       } else {
          return ApiResponse::apiResponse(404, "No questions found");
          }
    }     

 //store new question
 public function store(QuestionRequest $request) {

   $validatedData  = $request->validated();
   //store data in database
   $question = Question::create([
      'question'=>$validatedData['question'],
      'optionOne'=>$validatedData['optionOne'],
      'optionTwo'=>$validatedData['optionTwo'],
      'optionThree'=>$validatedData['optionThree'],
      'rightAnswer'=>$validatedData['rightAnswer'],
      'level_id'=>Level::where('name', $validatedData['level'])->first()->id,
   ]);

   if($question) {
      return ApiResponse::apiResponse(201,  "Question created successfully", $question);
   } else {
      return ApiResponse::apiResponse(401, "Failed to create question");
   }
 }
}
