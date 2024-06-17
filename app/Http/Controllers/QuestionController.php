<?php

namespace App\Http\Controllers;

use ApiResponse;
use App\Models\Level;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;

class QuestionController extends Controller {

    //get  questions by level name
   public function index(Request $request){
      $request->validate([
         'name' => 'required|string',
      ]);
    $level = Level::where('name','=', $request->input('name'))->first();
    if ($level) {
    $id = $level->id;
    $questions = Question::where('level_id','=',$id)->get();
    if(count($questions) > 0 ) {
       return ApiResponse::apiResponse(200, "Questions retrieved successfully", $questions);
     } else {
       return ApiResponse::apiResponse(404, "No questions found for this level");
     }
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
   $id = Level::where('name', $validatedData['level'])->first()->id;
   $question = Question::create([
      'question'=>$validatedData['question'],
      'optionOne'=>$validatedData['optionOne'],
      'optionTwo'=>$validatedData['optionTwo'],
      'optionThree'=>$validatedData['optionThree'],
      'rightAnswer'=>$validatedData['rightAnswer'],
      'level_id'=>$id,
   ]);
   if($question) {
      return ApiResponse::apiResponse(201,  "Question created successfully", $question);
   } else {
      return ApiResponse::apiResponse(401, "Failed to create question");
   }
 }
}
