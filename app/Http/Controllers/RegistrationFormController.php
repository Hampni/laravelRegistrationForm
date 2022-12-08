<?php

namespace App\Http\Controllers;

class RegistrationFormController extends Controller
{
    public function index()
    {
        return view('registrationForm', ['title' => 'Registration Form']);
    }
}
