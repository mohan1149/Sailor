<?php

namespace App\Http\Controllers\api\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Edujugon\PushNotification\PushNotification;
use App\Http\Controllers\Mailings\MailController;
class TeacherController extends Controller
{
    private $mailController;
    public function __construct(){
        $this->mailController = new MailController();
    }

    public function appUserLogin(Request $request){
        try{
            $user_id    = $request['user_id'];
            $password   = $request['password'];
            $device_fcm = $request['device_fcm'];
            $user = DB::table('emplyoee')
                ->where('emp_reg_num',$user_id)
                ->first();
            if(isset($user)){
                if( Hash::check($password, $user->emp_password) ){
                    $update = DB::table('emplyoee')
                        ->where('id',$user->id)
                        ->update([
                            'emp_device_token' => $device_fcm,
                        ]);
                    return response()->json($user,200); 
                }else{
                    //invalid password
                    return response()->json(2,200);
                }
            }else{
                //invalid user id
                return response()->json(1,200);
            }            
        }catch(\Exception $e){
            //server error
            return response()->json(0,200);
        }
    }

    public function forgotPassword(Request $request){
        //return to reset password url with view
        try{            
            $user_reg_num = $request['user_reg_num'];            
            $check_user = DB::table('emplyoee')                
                ->where('emp_reg_num',$user_reg_num)
                ->first();
            if($check_user){
                $_SESSION['user_mail'] = $check_user->emp_email;                
                $send_mail = $this->mailController->sendAppTeacherPasswordLink($check_user->id,$user_reg_num);                
                return response()->json(2,200);                
            }else{
                //id not found
                return response()->json(1,200);
            }            
        }catch(\Exception $e){
            // 500 error
            return response()->json(0,200);
        }        
    }

    public function teacherResetPassword(Request $request){
        try{
            $user_data = [
                'user_id'      => $request['user_id'],
                'user_reg_num' => $request['user_reg'],
            ];
            return view('mobileViews.appTeacherPasswordResetView',['user_data' => $user_data]);
        }catch(\Exception $e){

        }
    }

    public function teacherUpdatePassword(Request $request){
        try{
            $uid     = base64_decode($request['user_id']);
            $new_pwd = strip_tags($request['new_pwd']); 
            $update  = DB::table('emplyoee')
                ->where('id',$uid)
                ->update([
                    'emp_password' => Hash::make($new_pwd),
                ]);
            return redirect('/password/reset/success');        
        }catch(\Exception $e){
            return view('excep',['error'=>$e->getMessage()]);
        }
    }

    public function getTeacherInstituteData(Request $request){
        try{
            $return_data = [];
            $uid = $request['uid'];
            $user = DB::table('emplyoee')
                ->where('emplyoee.id',$uid)
                ->first();
            $return_data['school'] = $this->getSchoolNameById($user->emp_institute);
            $return_data['dept'] = $this->getDepartmentNameById($user->emp_depart);
            return response()->json($return_data,200);
        }catch(\Exception $e){
            return response()->json($e->getMessage(),200);
        }
    }

    public function getSchoolNameById($school_id){
        try{
            $school_name = DB::table('school')
                ->where('id',$school_id)
                ->select('school_name')
                ->first();
            return $school_name;
        }catch(\Exception $e){
            return 'Not Found';
        }
    }

    public function getDepartmentNameById($dept_id){
        try{
            $dept_name = DB::table('departments')
                ->where('id',$dept_id)
                ->select('dept_name')
                ->first();
            return $dept_name;
        }catch(\Exception $e){
            return 'Not Found';
        }
    }

    public function getTeacherTimetable(Request $request){
        try{
            $user_reg   = $request['uid'];
            $sid        = $request['sid'];
            $teacher    = DB::table('teacher')->where('teacher_reg_id',$user_reg)->select('id')->first();
            $teacher_id = $teacher->id;
            $school     = DB::table('school')->where('id',$sid)->select('school_periods')->first();
            $periods    = $school->school_periods;
            $weeks      = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
            $timetable = [];            
            foreach ($weeks as $week) {
                for($i = 1; $i <= $periods; $i++){
                  $timetable[$week][$i] = DB::table('timetable')
                    ->join('class','timetable.class_id','=','class.id')
                    ->join('grades','grades.id','=','class.class_year')
                    ->whereRaw($week."->'".$i."'->>'staff_id' = ? ",[$teacher_id])
                    ->selectRaw($week."->'".$i."'->>'subject' as subject,class_id,class.class_name,grades.grade_year")
                    ->first($week);
                }
              }
            return $timetable;
        }catch(\Exception $e){
            return response()->json($e->getMessage(),200);
        }
    }

    public function getTeacherClasses(Request $request){
        try{            
            $teacher_id = $request['uid'];   
            $sid        = $request['sid'];         
            $school     = DB::table('school')->where('id',$sid)->select('school_periods')->first();
            $periods    = $school->school_periods;
            $weeks      = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
            $timetable  = [];      
            $teacher_classes = [];      
            foreach ($weeks as $week) {
                for($i = 1; $i <= $periods; $i++){
                  $timetable[$week][$i] = DB::table('timetable')
                    ->join('class','timetable.class_id','=','class.id')
                    ->join('grades','grades.id','=','class.class_year')
                    ->whereRaw($week."->'".$i."'->>'staff_id' = ? ",[$teacher_id])
                    ->selectRaw($week."->'".$i."'->>'subject' as subject,class_id,class.class_name,grades.grade_year")                    
                    ->first($week);
                }
            }
            $date =  date('w');            
            $classes =  $timetable[$weeks[$date]];                    
            foreach($classes as $key => $class){
                if($class !=null){
                    $teacher_classes [] = [
                        'period'        => $key,
                        'grade'         => $class->grade_year,
                        'classId'       => $class->class_id,
                        'className'     => $class->class_name,
                        'subjectName'   => $class->subject,
                        'classStudents' => $this->getStudentsByClass($class->class_id),
                    ];
                }
            }
            return $teacher_classes;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function getStudentsByClass($classId){
        try{
            $students = [];
            $students = DB::table('student')
                ->where('class_id',$classId)
                ->orderBy('sid')
                ->get();
            return $students;
        }catch(\Exception $e){
            return [];
        }
    }

    public function getMyClass(Request $request){
        try{
            $return_data = [];
            $uid = $request['uid'];
            $class = DB::table('class')
                ->where('class_teacher',$uid)
                ->join('grades','grades.id','=','class.class_year')
                ->select(['class.id','class.class_name','grades.grade_year'])
                ->first();
            $subjects = DB::table('subjects')
                ->where('class_id',$class->id)
                ->first();
            $students = DB::table('student')
                ->where('class_id',$class->id)
                ->orderBy('sid')
                ->get();
            $return_data['class']     = $class;
            $return_data['subjects']  = json_decode($subjects->subjects_list);
            $return_data['students']  = $students;
            return response()->json($return_data,200);
        }catch(\Exception $e){
            return response()->json(0,200);
        }
    }

    public function updateProfile(Request $request){
        try{
            $uid    = $request['uid'];
            $phone  = $request['phone'];
            $email  = $request['email'];
            $photo  = $request['photo'];
            $update = DB::table('emplyoee')
                ->where('teacher_foriegn_key',$uid)
                ->update([
                    'emp_phone' => $phone,
                    'emp_email' => $email,
                    'emp_photo' => $photo,
                ]
            );
            $updateTeacher = DB::table('teacher')
                ->where('id',$uid)
                ->update([
                    'teacher_phone'   => $phone,
                    'teacher_email'   => $email,
                    'teacher_profile' => $photo,
                ]
            ); 
            $getLatest = DB::table('emplyoee')
                ->where('teacher_foriegn_key',$uid)
                ->first();      
            return response()->json($getLatest, 200); 
        }catch(\Exception $e){
            return response()->json($e->getMessage(), 200);
        }
    }
}