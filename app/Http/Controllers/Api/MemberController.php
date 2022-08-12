<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddNewMemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{

    // amount of members on one page
    protected $limit = 30;

    public function getShownMembers()
    {
        return MemberResource::collection(Member::where('is_shown', 1)->paginate($this->limit));
    }

    public function getAllMembers()
    {
        return MemberResource::collection(Member::paginate($this->limit));
    }

    public function getOneMember($id)
    {
        return MemberResource::collection(Member::all()->where('id', $id));
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

    public function addMember(AddNewMemberRequest $request)
    {
        if (!empty($request->file('image'))) {
            $file = $request->file('image');
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('images/memberImages'), $file_name);
            $_POST['photo'] = $file_name;
        }

        $_POST['created_at'] = date_create()->format('Y-m-d H:i:s');
        $id = DB::table('members')->insert($_POST);
        return 'success';
    }

    public function updateMember(Request $request)
    {

        if (!empty($request->file('image'))) {
            $file = $request->file('image');
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('images/memberImages'), $file_name);
            $_POST['photo'] = $file_name;
        }
        $_POST['updated_at'] = date_create()->format('Y-m-d H:i:s');

        DB::table('members')->where('id', $_POST['id'])->update($_POST);
        return 'success';
    }

    public function deleteMember(Request $request)
    {
        DB::table('members')->where('id', $request->id)->delete();
    }
}
