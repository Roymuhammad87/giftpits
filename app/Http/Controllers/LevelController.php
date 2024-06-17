<?php

namespace App\Http\Controllers;

use ApiResponse;
use App\Models\Level;
use Illuminate\Http\Request;
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
}
