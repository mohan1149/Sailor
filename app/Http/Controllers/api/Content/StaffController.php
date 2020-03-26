<?php

namespace App\Http\Controllers\api\Content;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class StaffController extends Controller
{
    public function getSchools(){
        $school_owner_id = $_SESSION['user_id'];
        $schools = DB::table('school')
            ->where('school_owner_id',$school_owner_id)
            ->get();
        return view('addStaff',['schools'=>$schools]);
    }
    public function addStaff(Request $request)
    {
        $staff_name              = $request['staffname'];
        $staff_phone             = $request['phone'];
        $staff_email             = $request['email'];
        $staff_designation       = $request['designation'];
        $staff_school            = $request['school_id'];
        $staff_main_field        = $request['main_field'];
        $staff_class_teacher_for = $request['class_teacher_for'];
        try{
            $query = DB::table('teacher')
                ->insertGetId([
                    'username'          => $staff_name,
                    'phone'             => $staff_phone,
                    'email'             => $staff_email,
                    'school_id'         => $staff_school,
                    'main_field'        => $staff_main_field,
                    'class_teacher_for' => $staff_class_teacher_for,
                    'designation'       => $staff_designation,
                ]
            );
        return redirect('api/manage/staff');
        }catch(\Exception $e){
            return $e;
        }
    }
    public function manageStaff(){
        $school_owner_id = $_SESSION['user_id'];
        $ids =  DB::table('school')
            ->join('teacher','school.id','=','teacher.school_id')
            ->distinct()
            ->where('school.school_owner_id',$school_owner_id)
            ->select(['teacher.school_id'])
            ->get();
        foreach($ids as $id){
            $staff[] = DB::table('school')
                ->join('teacher','school.id','=','teacher.school_id')
                ->where('school_id',$id->school_id)
                ->get();
        }
        return view('manageStaff',['staff'=>$staff]);
    }
    function getStaff(Request $request){
        $staff = DB::table('teacher')
            ->get();
        return response()->json($staff,200);
    }
}
