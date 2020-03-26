<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class MailController extends Controller
{
    public function sendPasswordResetLink(Request $request){
        $data = array('email'=>$_POST['reg-email']);
        $query = DB::table('users')
            ->where('email',$_POST['reg-email'])
            ->first();
        if(isset($query->email)){
            $mail = Mail::send('mailings.passwordResetMail', $data, function($message) {
                $email = $_POST['reg-email'];
                $message->to($email, 'STM System')->subject('STM:Password Reset Link');
                $message->from('mohan.velegacherla@gmail.com','admin@stm');
            });
            return view('passwordLinkSent');
        }else{
            $msg = 'EMAIL NOT FOUND.';
            return view('emailNotExist',['msg'=>$msg]);
        }
    }
}
