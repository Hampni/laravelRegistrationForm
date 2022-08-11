<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SecondStepRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class SecondStepController extends Controller
{
    public function index(SecondStepRequest $request)
    {

    if (!empty($request->file('image'))) {
        $file = $request->file('image');
        $file_name = $file->getClientOriginalName();
        $file->move(public_path('images/memberImages'), $file_name);
        $_POST['photo'] = $file_name;
    }

        $_POST['updated_at'] = date_create()->format('Y-m-d H:i:s');

        DB::table('members')->where('id', $request->session()->get('id'))->update($_POST);

        return $request->session()->get('id');
    }
}
