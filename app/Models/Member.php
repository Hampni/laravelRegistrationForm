<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    use HasFactory;

    public static function insertNewMember(array $dataArray)
    {
        DB::table('members')->insert($dataArray);
    }

}
