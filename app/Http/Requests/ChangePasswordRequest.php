<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    public function failedValidation(Validator $validator)
    {
        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => [
                'required_with:password_confirmation',
                'required'
            ],
            'new_password' => [
                'required', //'confirmed', 'different:old_password',
                'min:6'
            ],
            'confirm_password' => [
                'required',
                'same:new_password'
            ]
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        // checks user current password
        $validator->after(function ($validator) {
            if ( !Hash::check($this->old_password, auth()->user()->password) ) {
                $validator->errors()->add('old_password', 'Your old password is incorrect.');
            }
        });
        return;
    }
}
