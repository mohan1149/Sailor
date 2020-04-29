<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Edujugon\PushNotification\PushNotification;

use \Pusher\Pusher;

class UserController extends Controller
{
    // signup function for school owners
    public function signUp(Request $request)
    {
        session_start();
        $username  = strip_tags($request['username']);
        $phone     = strip_tags($request['phone']);
        $email     = strip_tags($request['email']);
        $password  = Hash::make( strip_tags($request['password']));
        try{
            $query = DB::table('users')
                ->insertGetId([
                    'username' => $username,
                    'phone'    => $phone,
                    'email'    => $email,
                    'password' => $password,
                ]
            );
            $_SESSION['user_id'] = $query;
            return redirect('/add/school');
        }catch(\Exception $e){
            return response()->json($e->getMessage(),500);
        }
    }

    // login function for school owners
    public function login(Request $request){
        session_start();
        $email      = strip_tags($request['email']);
        $password   = strip_tags($request['password']);
        try {
            $user = DB::table('users')
                ->select(['id','password'])
                ->where('email',$email)
                ->first();
            if(!$user){
                $msg = 'EMAIL NOT FOUND.';
                return view('emailNotExist',['msg'=>$msg]);
            }else{
                if(Hash::check($password, $user->password)){
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['role']    = 0;
                    return redirect('/dashboard');
                }else{
                    $msg = 'INCORRECT PASSWORD';
                    return view('emailNotExist',['msg'=>$msg]);
                }
            }
        }catch (\Exception $e) {
            return  response()->json($e->getMessage(), 500);
        }
    }

    // function to get user profile
    public function getProfile(){
      try{
        $user_id   = $_SESSION['user_id'];
        $user_data = DB::table('users')
          ->where('id',$user_id)
          ->first();
        return view('profile',['user' => $user_data]);
      }catch(\Exception $e){
        return view('execp');
      }
    }

    // function to get user mail box
    public function getMailbox(){
      return view('mailbox');
    }

    //function to get user notifiactions
    public function getNotifications(){
      return view('notifications');
    }


    public function studentAccess(Request $request){
        $socketId = $request->socket_id;
        $channelName = $request->channel_name;

        $pusher = new Pusher('83c9614fa128f8d6027a', '21cc55200cb583256bf2', '497574', [
            'cluster' => 'ap2',
            'encrypted' => true
        ]);

        $presence_data = ['name' => auth()->user()->name];
        $key = $pusher->presence_auth($channelName, $socketId, auth()->id(), $presence_data);

        return response($key);
    }
}
