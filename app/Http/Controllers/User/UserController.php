<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use \Pusher\Pusher;

class UserController extends Controller
{
    // signup function for school owners
    public function signUp(Request $request)
    {
        session_start();
        $username = strip_tags($request['username']);
        $phone    = strip_tags($request['phone']);
        $email    = strip_tags($request['email']);
        $app_for  = $request['app_for'];
        $password = Hash::make( strip_tags($request['password']));
        $hex       = bin2hex(openssl_random_pseudo_bytes(16));
        $img_type  = strtolower(pathinfo($_FILES['profile']['name'],PATHINFO_EXTENSION));
        move_uploaded_file($_FILES['profile']['tmp_name'],"storage/user_profiles/".$hex.'.'.$img_type);
        try{
            $query = DB::table('users')
                ->insertGetId([
                    'username' => $username,
                    'phone'    => $phone,
                    'email'    => $email,
                    'password' => $password,
                    'app_for'  => $app_for,
                    'profile'  => $request->getSchemeAndHttpHost().Storage::url('user_profiles/'.$hex.'.'.$img_type),
                ]
            );
			$_SESSION['user_id'] = $query;
			$_SESSION['ins']     = $app_for;
			$_SESSION['lang']    = 'English';
			if($app_for == 'college'){
				return redirect('/college/dashboard');
			}elseif($app_for == 'school'){
				return redirect('/school/dashboard');
			}            
        }catch(\Exception $e){
			return $e->getMessage();
            return view('excep',['error'=>$e->getMessage()]);
        }
    }

    // login function for school owners
    public function login(Request $request){
        session_start();
        $email      = strip_tags($request['email']);
        $password   = strip_tags($request['password']);
        try {
            $user = DB::table('users')                
                ->where('email',$email)
				->first();					
            if(!$user){
				$msg = 'EMAIL NOT FOUND.';
				return view('emailNotExist',['msg'=>$msg]);				
            }else{
                if(Hash::check($password, $user->password)){
					$_SESSION['user_id'] = $user->id;
					if($user->app_for == 'college'){
						$_SESSION['ins'] = 'college';
						$_SESSION['lang'] ='English';
						return redirect('/college/dashboard');
					}else{
						$_SESSION['ins']  = 'school';
						$_SESSION['lang'] ='English';
						$_SESSION['user'] = $user;
						return redirect('/school/dashboard');
					}                
                }else{
                    $msg = 'INCORRECT PASSWORD';
                    return view('emailNotExist',['msg'=>$msg]);
                }
			}
        }catch (\Exception $e) {
            return view('excep',['error'=>$e->getMessage()]);
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

    public function logout(){
      try{
        $_SESSION['user_id'] = '';
        return redirect('/');
      }catch(\Exception $e){
        return view('excep');
      }
    }



    public function getPermissions(){
      try{
        $users = DB::table('user_roles')
          ->join('roles','roles.role_code','=','user_roles.role_id')
          ->join('emplyoee','emplyoee.id','=','user_roles.user_id')
          ->get();
        $roles = DB::table('roles')
          ->get();
        $emps  = DB::table('emplyoee')
          ->where('emp_owner',$_SESSION['user_id'])
          ->get();
        $institutes = DB::table('school')
          ->where('school_owner',$_SESSION['user_id'])          
          ->get();
        $ins_data = [];
        foreach($institutes as $institute){
          $ins_data[] = [
            'school_id'   => $institute->id,
            'school_name' => $institute->school_name,
            'dept_data'   => $this->getDeptsBySchoolId($institute->id),
          ];
        }
        $return_data = [];
        $return_data['roles']      = $roles;
        $return_data['emps']       = $emps;
        $return_data['institutes'] = $ins_data;
        $return_data['users']      = $users;
        return view('permissions',['return_data'=>$return_data]);
      }catch(\Exception $e){ 
        return $e->getMessage();    
        return view('excep');
      }
    }

    public function getDeptsBySchoolId($school_id){
      try{
        $depts = DB::table('departments')
          ->where('dept_ins_id',$school_id)
          ->get();
        return $depts;
      }catch(\Exception $e){
        return [];
      }
    }

    public function assignUserRole(Request $request){
      try{
        $role_id   = $request['role_id'];
        $user_id   = $request['user_id'];
        $school_id = $request['school_id'];
        $dept_id   = $request['dept_id'];
        $query = DB::table('user_roles')
          ->insert([
            'user_id'   => $user_id,
            'role_id'   => $role_id,
            'school_id' => $school_id,
            'dept_id'   => $dept_id
          ]);
        return response()->json('Succed',200);
      }catch(\Exception $e){
        return response()->json('Failed',500);
      }
    }
}
