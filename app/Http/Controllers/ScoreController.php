<?php

namespace App\Http\Controllers;

use ApiResponse;
use App\Models\Score;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateScoreRequest;

class ScoreController extends Controller{

    /**
     * Display a listing of the resource.
     */
    public function index(int $id){
        $score = Score::where('user_id', $id)->first();
          if($score) {
             return ApiResponse::apiResponse(200, "User score retrieved successfully", $score);
          }  else {
             return ApiResponse::apiResponse(404, "User score not found");
          }
     }
 
     //get all scores
      
     public function allScores(){
         //get scores by sorting them descending
         $scores = Score::orderBy('score', 'desc')->paginate(10);
         //get every user with its score
         if(count($scores) > 0) {
            /*

             // if($scores->total() > $scores->perPage()){
             //     $userScores = [];
             //     foreach($scores as $score) {
             //      $userScores[] = [
             //      'user_id' => $score->user_id,
             //      'username' => $score->user->username,
             //      'score' => $score->score
             //     ];
             //     $data = [
             //         'scores' => $userScores,
             //         'next_page_url' => $scores->nextPageUrl(),
             //         'prev_page_url' => $scores->previousPageUrl(),
             //         'total' => $scores->total(),
             //     ];
             //   }  
             
             //  return ApiResponse::apiResponse(200, "All scores retrieved successfully", $data);
             // } else {
             */
                 $userScores = [];
                 foreach($scores as $score) {
                     if($score->score >= 50){
                      $userScores[] = [
                     'user_id' => $score->user_id,
                     'username' => $score->user->username,
                     'score' => $score->score 
                    ];
                  }
                 }
             return ApiResponse::apiResponse(200, "All scores retrieved successfully", $userScores);
             // }
           } else {
             return ApiResponse::apiResponse(404, "No scores found");
             } 
     }
 
     /**
      * Show the form for creating a new resource.
      */
     public function create()
     {
         //
     }
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(UpdateScoreRequest $request) {
 
         //validate info
          $request->validated();
        //create new score and store it, the return response if the score saved else return error 
             $score = new Score();
             $score->user_id = $request->input('user_id');
             $score->score = $request->input('score');
             $score->save();
             if($score) {
                 return ApiResponse::apiResponse(201, "Score created successfully", $score);
                 } else {
                     return ApiResponse::apiResponse(400, "Failed to create score");
                     }
           
    
         
     }
 
     /**
      * Display the specified resource.
      */
     public function show(Score $score)
     {
         //
     }
 
     /**
      * Show the form for editing the specified resource.
      */
     public function edit(Score $score)
     {
         //
     }
 
     /**
      * Update the specified resource in storage.
      */
     public function update(UpdateScoreRequest $request){
         //validate info
        $validatedData = $request->validated();
     
         //update the user score, add new coming score from the request and add it to existing score
         $score = Score::where('user_id',$request->user_id)->first();
         if($score) {
             $score->update([
                 'score' => $score->score + $request->score,
             ]);
             return ApiResponse::apiResponse(200, "Score updated successfully", $score);
             } else {
                 return ApiResponse::apiResponse(404, "Score not found");
                 }
         
     }
 
     /**
      * Remove the specified resource from storage.
      */
     public function destroy(Score $score)
     {
         //
     }
}
