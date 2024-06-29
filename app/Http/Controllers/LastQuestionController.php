<?php

namespace App\Http\Controllers;

use ApiResponse;
use App\Models\LastQuestion;
use Illuminate\Http\Request;

class LastQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $lastQuestion = LastQuestion::where('user_id', $request->user_id)->first();
        if ($lastQuestion) {
            return ApiResponse::apiResponse(200, 'successfully retrieved ', $lastQuestion);
            }
            else {
                return ApiResponse::apiResponse(400, 'No last question found', null);
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
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'question_id' => 'required|integer|exists:questions,id',
        ]);
        $lastQuestion = LastQuestion::where('user_id', $request->input('user_id'))->first();
        if($lastQuestion) {
            $lastQuestion->question_id = $request->input('question_id');
            $lastQuestion->save();
            return ApiResponse::apiResponse(201, 'last question updated successfullly', $lastQuestion);
        }else {
            $lastQuestion = new LastQuestion();
            $lastQuestion->user_id = $request->input('user_id');
            $lastQuestion->question_id = $request->input('question_id');
            $lastQuestion->save();
            return ApiResponse::apiResponse(200, 'last inserted successfully', $lastQuestion);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LastQuestion $lastQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LastQuestion $lastQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LastQuestion $lastQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LastQuestion $lastQuestion)
    {
        //
    }
}
