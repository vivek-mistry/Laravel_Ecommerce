<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    /*public function authorize()
    {
        return false;
    }*/

    public function failedValidation(Validator $validator)
    {
        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'phone_number'=> [
                'required',
                'digits:10'
            ],
            'password' => [
                'required',
                'min:6'
            ]
        ];
    }
}
