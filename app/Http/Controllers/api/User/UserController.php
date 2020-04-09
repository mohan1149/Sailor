<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Edujugon\PushNotification\PushNotification;

use \Pusher\Pusher;

session_start();
class UserController extends Controller
{
    private $userController;
    public function __constructor(){
        $userController = new UserController();
    }
    public function signUp(Request $request)
    {
        
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
            return 'error in sign up';
        }
    }
    public function login(Request $request){
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
                    return redirect('/dashboard');
                }else{
                    $msg = 'INCORRECT PASSWORD';
                    return view('emailNotExist',['msg'=>$msg]);
                }
            }
        }catch (\Exception $e) {
            return  response()->json($e, 500);
        }
    }





    public function studentAccess(Request $request){
        $socketId = $request->socket_id;
        $channelName = $request->channel_name;

        $pusher = new Pusher('ff793c35582f038e2bf0','15567ceb86ac0eea861e','978654',[
            'cluster'=> 'ap2',
            'encrypted'=> true,
        ]);
        $presence_data =  ['name'=>'Mohan'];
        $key = $pusher->pressence_auth($channelName,$socketId,1,$presence_data);
        return response($key);
    }
}
