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
        $school_owner_id = $_SESSION['user_id'];
        $ids =  DB::table('school')
            ->join('teacher','school.id','=','teacher.school_id')
            ->distinct()
            ->where('school.school_owner_id',$school_owner_id)
            ->where('school.status',1)
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
}
