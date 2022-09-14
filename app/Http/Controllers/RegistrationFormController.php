<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RegistrationFormController extends Controller
{
    public function index(Request $request)
    {
        return view('registrationForm', ['title' => 'Registration Form']);
    }
}
