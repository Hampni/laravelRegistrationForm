<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParticipationRequest extends FormRequest
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
            'first_name' => 'required|regex:/^[\p{Alphabetic}\-._ ]+$/u',
            'last_name' => 'required|regex:/^[\p{Alphabetic}\-._ ]+$/u',
            'birthday' => 'required|date',
            'report_subject' => 'required|max:500|regex:/^[\p{Alphabetic}0-9\-._ ]+$/u',
            'country' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'company' => 'nullable|max:100|regex:/^[\p{Alphabetic}0-9\-._ ]+$/u',
            'position' => 'nullable|max:100|regex:/^[\p{Alphabetic}0-9\-._ ]+$/u',
            'about_me' => 'nullable|max:500|regex:/^[\p{Alphabetic}0-9\-._ ]+$/u'
        ];
    }
}
