<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeginRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'identifier' => 'required|min:5',
            'phone' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'identifier.required' => 'An ID card number or a passport number must be provided',
            'identifier.min' => 'An ID card number or a passport can\'t be so short?',
            'phone.required' => 'A phone number is required',
        ];
    }
}
