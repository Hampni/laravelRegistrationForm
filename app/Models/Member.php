<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'first_name',
        'last_name',
        'birthday',
        'report_subject',
        'country',
        'phone',
        'email',
        'company',
        'position',
        'about_me',
        'photo'
    ];

}
