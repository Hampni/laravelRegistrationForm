<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FirstStepRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class FirstStepController extends Controller
{
    public function index(FirstStepRequest $request)
    {
        $_POST['created_at'] = date_create()->format('Y-m-d H:i:s');
        $id = DB::table('members')->insertGetId($_POST);
        $request->session()->put('id', $id);
        return 'success';
    }
}
