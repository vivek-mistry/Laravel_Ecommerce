<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'coupon_id' => [
                'required',
                'exists:coupons,id'
            ],
            'name' => [
                'required'
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->route('user_id'), 'id')->whereNull('deleted_at')
            ],
            'phone_number'=> [
                'required'
            ],
            'password' => [
                'sometimes'
            ]
        ];
    }
}
