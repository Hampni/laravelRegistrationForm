<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SecondStepRequest extends FormRequest
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
            'company' => 'nullable|max:100|regex:/^[\p{Alphabetic}0-9\-._ ]+$/u',
            'position' => 'nullable|max:100|regex:/^[\p{Alphabetic}0-9\-._ ]+$/u',
            'about_me' => 'nullable|max:500|regex:/^[\p{Alphabetic}0-9\-._ ]+$/u'
        ];
    }

    public function messages()
    {
        return [
            'regex' => 'Only upper and lower case are allowed'
        ];
    }
}
