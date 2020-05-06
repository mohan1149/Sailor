<?php

namespace App\Http\Controllers\api\Content;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\api\Content\SchoolController;
class StaffController extends Controller
{
    private $schoolController;
    private $classController;
    public function __construct(){
        $this->schoolController = new SchoolController();
    }
    public function getSchools(){
        $schools = $this->schoolController->getSchoolsByUser();
        return view('addStaff',['schools'=>$schools]);
    }
    public function addStaff(Request $request)
    {
        $staff_id          = strip_tags($request['staff_id']);
        $staff_name        = strip_tags($request['staffname']);
        $staff_phone       = strip_tags($request['phone']);
        $staff_email       = strip_tags($request['email']);
        $staff_designation = strip_tags($request['designation']);
        $staff_school      = strip_tags($request['school_id']);
        $department        = strip_tags($request['department']);
        $hex               = bin2hex(openssl_random_pseudo_bytes(16));
        try{
          $type    = strtolower(pathinfo($_FILES['profile']['name'],PATHINFO_EXTENSION));
          move_uploaded_file($_FILES['profile']['tmp_name'],storage_path()."/app/public/staff_images/".$hex.'.'.$type);
            $query = DB::table('teacher')
              ->insertGetId(
                [
                  'staff_id'          => $staff_id,
                  'username'          => $staff_name,
                  'phone'             => $staff_phone,
                  'email'             => $staff_email,
                  'school_id'         => $staff_school,
                  'department'        => $department,
                  'class_teacher_for' => -1,
                  'designation'       => $staff_designation,
                  'profile'           => $request->getSchemeAndHttpHost().Storage::url('staff_images/'.$hex.'.'.$type),
                ]
              );
            return redirect('/manage/staff');
        }catch(\Exception $e){
            return view('excep');
        }
    }
    public function manageStaff(){
      try{
          $school_owner_id = $_SESSION['user_id'];
          $response_data   = [];
          $schools = DB::table('school')
            ->where('school_owner_id',$school_owner_id)
            ->where('status',1)
            ->get();
          foreach ($schools as $school) {
            $response_data[] = [
              'id'        => $school->id,
              'school_name' => $school->school_name,
              'dept_data' => $this->getDeptsBySchoolId($school->id),
            ];
          }
          return view('manageStaff',['response_data'=>$response_data]);
      }catch(\Exception $e){
          return view('excep');
      }
    }

    public function getDeptsBySchoolId($school_id){
      $return_data = [];
      $deps = DB::table('departments')->where('school_id',$school_id)->get();
        foreach ($deps as $dep) {
          $return_data[] = [
            'id'         => $dep->id,
            'dept_name'  => $dep->d_name,
            'staff_data' => $this->geStaffByDeptId($dep->id),
          ];
        }
      return $return_data;
    }

    public function geStaffByDeptId($dept_id){
      $return_data = [];
      $return_data['staff'] = DB::table('teacher')
        ->where('department',$dept_id)
        ->orderBy('username')
        ->get();
      return $return_data;
    }

    public function deleteStaff(Request $request){
      try{
        $staff_id = $request['id'];
        $delete   = DB::table('teacher')
          ->where('id', $staff_id)
          ->delete();
        return redirect ('/manage/staff');
      }catch(\Exception $e){
        return view('excep');
      }
    }
    public function editStaff(Request $request){
      try{
        $staff_id   = base64_decode($request['id']);
        $staff_data = DB::table('teacher')
          ->where('id',$staff_id)
          ->first();
        return view('editStaff',['staff_data'=>$staff_data]);
      }catch(\Exception $e){
        return view('excep');
      }
    }
    public function updateStaff(Request $request){
      try{
        $staff_id          = $request['id'];
        $staff_sid         = strip_tags($request['staff_id']);
        $staff_name        = strip_tags($request['staffname']);
        $staff_phone       = strip_tags($request['phone']);
        $staff_email       = strip_tags($request['email']);
        $staff_designation = strip_tags($request['designation']);
        $hex               = bin2hex(openssl_random_pseudo_bytes(16));
        $type              = strtolower(pathinfo($_FILES['profile']['name'],PATHINFO_EXTENSION));
        if($type !=''){
          move_uploaded_file($_FILES['profile']['tmp_name'],storage_path()."/app/public/staff_images/".$hex.'.'.$type);
          $update = DB::table('teacher')
            ->where('id',$staff_id)
            ->update([
              'staff_id'    => $staff_sid,
              'username'    => $staff_name,
              'phone'       => $staff_phone,
              'email'       => $staff_email,
              'designation' => $staff_designation,
              'profile'     => $request->getSchemeAndHttpHost().Storage::url('staff_images/'.$hex.'.'.$type),

            ]
          );
        }else{
          $update = DB::table('teacher')
            ->where('id',$staff_id)
            ->update([
              'staff_id'    => $staff_sid,
              'username'    => $staff_name,
              'phone'       => $staff_phone,
              'email'       => $staff_email,
              'designation' => $staff_designation
            ]
          );
        }
        return redirect('/manage/staff');
      }catch(\Exception $e){
        return $e->getMessage();
      }
    }

    public function viewStaff(Request $request){
      $staff_id = base64_decode($request['id']);
      $staff_data = [];
      try{
        $staff = DB::table('teacher')
          ->where('id',$staff_id)
          ->first();
        $school_id = $staff->school_id;
        $periods   = DB::table('school')
          ->where('id',$school_id)
          ->select(['periods'])
          ->first();
        $school_periods = $periods->periods;
        $weeks = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
        $timetable = [];
        foreach ($weeks as $week) {
          for($i = 1; $i <= $school_periods; $i++){
            $timetable[$week][$i] = DB::table('timetable')
              ->join('class','timetable.class_id','=','class.id')
              ->whereRaw($week."->'".$i."'->>'staff_id' = ? ",[$staff_id])
              ->selectRaw($week."->'".$i."'->>'subject' as subject,class_id,class.value")
              ->first($week);
          }
        }        
        $staff_data['staff']    = $staff;
        $staff_data['timetable'] = $timetable;
        return view('viewStaff',['staff_data'=>$staff_data]);
      }catch(\Exception $e){
        return $e->getMessage();
        return view('excep');
      }
      return $staff_id;
    }
}
