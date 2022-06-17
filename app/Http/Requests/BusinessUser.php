<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $valid_password = '';
        $valid_business_name = '';
        if(request()->route()->getName() == "businesses.create" || request()->route()->getName() == "users.create"){
            $valid_password = 'required|string|min:8';
        }elseif(request()->route()->getName() == "businesses.create" || request()->route()->getName() == "businesses.update"){
            $valid_business_name = 'required';
        }
        return [
            'business_name' => $valid_business_name,
            'name' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => $valid_password,
            'phone' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return[
            'name' => 'The first name field is required.',
            'lname' => 'The last name field is required.'
        ];
    }
}
