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
        return MemberResource::collection(Member::all()->where('is_shown', 1));
    }

    public function getAllMembers()
    {
        return MemberResource::collection(Member::all());
    }

    public function countMembers()
    {
        return DB::table('members')->count();
    }

    public function changeDisplay(int $member_id, string $toDo)
    {
        DB::table('members')->where('id', $member_id)->update(['is_shown' => $toDo]);
    }

}
