<?php

namespace App\Http\Requests;

use ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    
    public function failedValidation(Validator $validator){

        if($this->is('api/*')) {
            $response = ApiResponse::apiResponse(422, 'Validation Errors Found', $validator->getMessageBag()->all());
             throw new ValidationException($validator,$response );
        }

     }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'=>'required|email',
            'password'=>'required'
        ];
    }
}
