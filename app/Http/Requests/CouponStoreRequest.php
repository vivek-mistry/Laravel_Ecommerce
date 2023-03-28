<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CouponStoreRequest extends FormRequest
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
            'coupon_code' => [
                'required',
                'alpha_num',
                'max:8'
            ],
            'description' => [
                'sometimes'
            ],
            'coupon_type' => [
                'required'
            ],
            'discount_type' => [
                'required'
            ],
            'discount' => [
                'required',
                'numeric'
            ],
            'min_order_amount' => [
                'required',
                'numeric'
            ],
            'max_discount_amount' => [
                'required',
                'numeric'
            ],
            'expired_at' => [
                'required',
                'date'
            ],
            'number_of_time_used' => [
                'required'
            ],
            'is_active' => [
                'sometimes'
            ]
        ];
    }
}
