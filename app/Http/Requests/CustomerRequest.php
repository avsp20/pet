<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        if(request()->route()->getName() == 'customers.store'){
            return [
                'fname' => 'required',
                'lname' => 'required',
                'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                'phone' => 'required|numeric',
                'pet_name' => 'required',
                'pet_status' => 'required',
                'payment_status' => 'required',
                'pet_type' => 'required',
                'gender' => 'required|in:0,1',
                'age' => 'required|numeric',
                'weight' => 'required',
                'date_of_birth' => 'required|date_format:Y-m-d',
                'breed_and_color' => 'required'
            ];
        }elseif(request()->route()->getName() == 'customers.update'){
            return [
                'fname' => 'required',
                'lname' => 'required',
                'phone' => 'required|numeric'
            ];
        }
    }

    public function messages()
    {
        if(request()->route()->getName() == 'customers.store'){
            return[
                'name.required' => 'The first name field is required.',
                'lname.required' => 'The last name field is required.',
                'breed_and_color.required' => 'The pet breed and color field is required.',
                'date_of_birth.required' => 'The date of death field is required.'
            ];
        }elseif(request()->route()->getName() == 'customers.update'){
            return [
                'name.required' => 'The first name field is required.',
                'lname.required' => 'The last name field is required.',
            ];
        }
    }
}
