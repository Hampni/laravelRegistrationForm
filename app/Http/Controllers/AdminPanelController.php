<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class AdminPanelController extends Controller
{
    public function index(Request $request)
    {
        return view('adminPanel', ['title' => 'Admin Panel']);
    }

    public function update($member_id)
    {
        return view('updateMember', ['id' => $member_id, 'title' => 'Update Member']);
    }

    public function add()
    {
        return view('addMember', ['title' => 'Add Member']);
    }
}
