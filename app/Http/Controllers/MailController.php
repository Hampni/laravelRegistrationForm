<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\HelloMail;

class MailController extends Controller
{
    public function sendMail()
    {

        $name = 'Illia';

        Mail::to('i.prodanets@lajm.lt')->send(new HelloMail($name));
    }
}
