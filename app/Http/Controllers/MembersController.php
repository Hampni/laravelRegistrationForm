<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MembersController extends Controller
{
    public function index(Request $request)
    {
        return view('members');
    }
}
