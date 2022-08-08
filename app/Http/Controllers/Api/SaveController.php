<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParticipationRequest;

use App\Models\Member;
use Illuminate\Http\Request;


class SaveController extends Controller
{
    public function index(ParticipationRequest $request)
    {
        if (empty($_SESSION['id'])) {
            Member::insertNewMember($_POST);
        }
        return $_POST;
    }
}
