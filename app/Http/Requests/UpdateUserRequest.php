<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'id'=>'required|integer|exists:users,id',
           'username'=> 'nullable|string|min:3|unique:users,username',
           'email'=> 'nullable|email|unique:users,email',
           'image'=>'nullable|image|mimes:png,jpg,jpeg,webp|max:2048'
        ];
    }
}
