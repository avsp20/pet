<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerPetRequest extends FormRequest
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
        return [
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
    }

    public function messages()
    {
        return[
            'breed_and_color.required' => 'The pet breed and color field is required.',
            'date_of_birth.required' => 'The date of death field is required.'
        ];
    }
}
