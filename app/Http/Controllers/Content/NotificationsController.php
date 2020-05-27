<?php

namespace App\Http\Controllers\api\Content;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class NotificationsController extends Controller
{    
    private $schoolController;
    public function __construct(){
        $this->schoolController = new CollegeController();
    }

    public function addNotification(){
        try{
            $return_data = [];
            $schools = $this->schoolController->getCollegesByUser();
            foreach($schools as $school){
                $return_data[] = [
                    'school_id'   => $school->id,
                    'school_name' => $school->school_name,
                    'years_data'  => $this->getYearsBySchoolId($school->id),
                    'dep_data'    => $this->getDeptsBySchoolId($school->id),
                ];
            }            
            return view('addNotification',['return_data'=>json_encode($return_data)]);
        }catch(\Exception $e){            
            return view('excep');
        }        
    }

    public function getYearsBySchoolId($schoolId){        
        try{
            $years = DB::table('grades')
                ->where('school_id',$schoolId)
                ->get();
            return $years;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function getDeptsBySchoolId($schoolId){        
        try{
            $depts = DB::table('departments')
                ->where('school_id',$schoolId)
                ->get();
            foreach($depts as $dept){
                $dept_data[] = [
                    'dept_id'   => $dept->id,
                    'dept_name'  => $dept->d_name,
                    'class_data' => $this->getClassByDeptId($dept->id),
                ];
            }
            return $dept_data;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function getClassByDeptId($deptId){
        try{
            $class_data = DB::table('class')
                ->where('dept_id',$deptId)
                ->get();            
            return $class_data;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

}