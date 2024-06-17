<?php

class ApiResponse { 
 
    public static function apiResponse($status = 201, $message = null, $data =[]){
    
     $response = [
         'status'=>$status,
         'message'=>$message,
         'data'=>$data
     ];
         return response()->json($response, $status);
    }
    }
?>
