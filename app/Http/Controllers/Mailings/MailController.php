<?php

namespace App\Http\Controllers\Mailings;

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
            $mail = Mail::send('mailings.passwordResetView', $data, function($message) {
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


    
    public function sendAppTeacherPasswordLink($user_id,$user_reg){
        $user_data = array('user_id'=> $user_id,'user_reg_num' => $user_reg);
        $mail = Mail::send('mailings.appTeacherPasswordLink',$user_data, function($message) {
            $mail = $_SESSION['user_mail'];
            $message->to($mail, 'Sailor ERP System')->subject('Sailor App, password reset mail.');
            $message->from('mohan.velegacherla@gmail.com','postman@sailor');
        });
        return $mail;
    }
}
