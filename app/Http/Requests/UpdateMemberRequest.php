<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
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
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'birthday' => 'required|date|max:10',
            'report_subject' => 'required|max:500|regex:/^[\pL\s\0-9\-]+$/u',
            'country' => 'required',
            'phone' => 'required',
            'email' => 'required|email|',
            'company' => 'nullable|max:100|regex:/^[\pL\s\0-9\-]+$/u',
            'position' => 'nullable|max:100|regex:/^[\pL\s\0-9\-]+$/u',
            'about_me' => 'nullable|max:500|regex:/^[\pL\s\0-9\-]+$/u'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'This field is mandatory',
            'regex' => 'Only upper and lower case are allowed',
            'max' => 'Maximum 500 symbols',
            'unique' => 'Such email already exists'
        ];
    }
}
