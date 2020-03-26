<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Edujugon\PushNotification\PushNotification;

session_start();
class UserController extends Controller
{
    public function signUp(Request $request)
    {
        
        $username  = $request['username'];
        $phone     = $request['phone'];
        $email     = $request['email'];
        $password  = Hash::make( $request['password'] );
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
        $email      = $request['email'];
        $password   = $request['password'];
        /*$firebase   = env('FIREBASE_API_KEY');
        $token = 'dLDSGfJmXus:APA91bGwekQkig7g_AUeGDV30I9MT5UkDuXta9WrganoBrw3HonQZzk4NwPqjtNFdDYnElWqZ-Xpm8okEx-FBfbgzRN0DptW1Au7XDZL5MVvCuN-y0CHhF7AblqgPqGBF6wBH-D5dVuB';
        $push = new PushNotification('fcm');
        $resp = $push->setService('fcm')
            ->setMessage([
                'notification' => [
                        'title'=>'This is the title',
                        'body'=>'This is the message',
                        'sound' => 'default'
                        ],
                'data' => [
                        'extraPayLoad1' => 'value1',
                        'extraPayLoad2' => 'value2'
                        ]
            ])
            ->setApiKey('AAAAsAB2TDM:APA91bH9ASjefr2SdGzQKo05M6oiD31AEXmYIDuKBSefWPSTfjDw4uMgYPbNxbcj4ner4D40_WHwRW6baxUQg0GtpavPMlOFDzLIBba4s-VeIKTIC_Hy-IR8kK8ip1PJPE8ouwC1GJVK')
            ->setDevicesToken($token)
            ->send()
            ->getFeedback();
        print_r($resp);exit;*/
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
}
