<?php

namespace App\Http\Controllers;

use App\Mail\SendEmailToAdvertiser;
use Illuminate\Http\Request;

class SendMailController extends Controller
{
    //
    public function sendMail(ContactRequest $user){
        \Mail::to($user->adv_email)->send(new SendEmailToAdvertiser($user));

        return back();
    }
}
