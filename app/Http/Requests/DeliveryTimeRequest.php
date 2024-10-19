<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryTimeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Change this if you want to implement authorization
    }

    public function rules()
    {
        return [
            'delivery_time' => 'required|string|max:255|unique:delivery_times,delivery_time',
        ];
    }

    public function messages()
    {
        return [
            'delivery_time.required' => 'The delivery time is required.',
            'delivery_time.string' => 'The delivery time must be a string.',
            'delivery_time.max' => 'The delivery time must not exceed 255 characters.',
            'delivery_time.unique' => 'The delivery time has already been taken.', // Custom message for uniqueness violation
        ];
    }
}
