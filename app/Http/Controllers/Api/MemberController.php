<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddNewMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{

    public function getShownMembers()
    {
        return MemberResource::collection(Member::latest()->where('is_shown', 1)->paginate(10));
    }

    public function getAllMembers()
    {
        return MemberResource::collection(Member::latest()->paginate(10));
    }

    public function getOneMember($id)
    {
        return MemberResource::collection(Member::where('id', $id)->get());
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
        $file_name = 'default.png';
        if (!empty($request->file('image'))) {
            $file = $request->file('image');
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('images/memberImages'), $file_name);
        }
        $r = $request->all();
        $r['photo'] = $file_name;
        Member::create($r);

    }

    public function updateMember(UpdateMemberRequest $request)
    {
        $file_name = 'default.png';
        if (!empty($request->file('image'))) {
            $file = $request->file('image');
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('images/memberImages'), $file_name);
        }

        $r = $request->all();
        $r['photo'] = $file_name;
        unset($r['image']);
        Member::whereId($r['id'])->update($r);
    }

    public function deletePhoto(Request $request)
    {
        Member::whereId($request->id)->update($request->all());
    }

    public function deleteMember(Request $request)
    {
        DB::table('members')->where('id', $request->id)->delete();
    }
}
