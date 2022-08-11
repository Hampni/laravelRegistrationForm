<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{

    // abount of members on one page
    protected $limit = 10;

    public function index()
    {
        return MemberResource::collection(Member::all()->where('is_shown', 1));
    }

    public function getAllMembers()
    {
        return MemberResource::collection(Member::paginate($this->limit));
    }

    public function countMembers()
    {
        return DB::table('members')->count();
    }

    public function changeDisplay(Request $request)
    {
        DB::table('members')->where('id', $request->id)->update(['is_shown' => $request->change]);
        return $request->change;
    }

    public function deleteMember(Request $request)
    {
        DB::table('members')->where('id', $request->id)->delete();
    }
}
