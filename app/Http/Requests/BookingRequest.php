<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !!request()->auth;
        // return request()->auth->get('otp-verified');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'center' => 'required',
            'slot' => 'required',
            'name' => 'required',
            'date' => 'required|date'
        ];
    }
}
