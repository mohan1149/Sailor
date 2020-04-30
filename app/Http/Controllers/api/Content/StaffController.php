<?php

namespace App\Http\Controllers\api\Content;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $staff_name              = strip_tags($request['staffname']);
        $staff_phone             = strip_tags($request['phone']);
        $staff_email             = strip_tags($request['email']);
        $staff_designation       = strip_tags($request['designation']);
        $staff_school            = strip_tags($request['school_id']);
        $department              = strip_tags($request['department']);
        //$staff_class_teacher_for = strip_tags($request['class_teacher_for']);
        try{
            $query = DB::table('teacher')
                ->insertGetId([
                    'username'          => $staff_name,
                    'phone'             => $staff_phone,
                    'email'             => $staff_email,
                    'school_id'         => $staff_school,
                    'department'        => $department,
                    'class_teacher_for' => -1,
                    'designation'       => $staff_designation,
                ]
            );
        return redirect('/manage/staff');
        }catch(\Exception $e){
            return response()->json($e->getMessage(),500);
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
        $staff_name        = strip_tags($request['staffname']);
        $staff_phone       = strip_tags($request['phone']);
        $staff_email       = strip_tags($request['email']);
        $staff_designation = strip_tags($request['designation']);

        $update = DB::table('teacher')
          ->where('id',$staff_id)
          ->update([
            'username'    => $staff_name,
            'phone'       => $staff_phone,
            'email'       => $staff_email,
            'designation' => $staff_designation
          ]);
        return redirect('/manage/staff');
      }catch(\Exception $e){
        return $e->getMessage();
      }
    }

    public function viewStaff(Request $request){
      return view('csoon');
    }
}
