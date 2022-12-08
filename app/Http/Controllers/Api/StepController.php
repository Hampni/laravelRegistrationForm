<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FirstStepRequest;
use App\Http\Requests\SecondStepRequest;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class StepController extends Controller
{
    public function firstStep(FirstStepRequest $request)
    {
        $member = Member::create($request->all());
        session()->put('id', $member->id);
    }

    public function secondStep(SecondStepRequest $request)
    {
        $file_name = 'default.png';
        if (!empty($request->file('photo'))) {
            $file = $request->file('photo');
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('images/memberImages'), $file_name);
        }

        $r = $request->all();
        $r['photo'] = $file_name;
        Member::whereId(session()->get('id'))->update($r);

    }

}
