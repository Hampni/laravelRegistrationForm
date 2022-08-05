<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{

    public function index()
    {
        return MemberResource::collection(Member::all());
    }

    public function countMembers()
    {
        return DB::table('members')->count();
    }

}
