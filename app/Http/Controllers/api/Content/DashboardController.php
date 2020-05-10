<?php

namespace App\Http\Controllers\api\Content;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
  public function __construct(){

  }
  public function getInstituteGraphData(){
    try{
      $schol_owenr_id = $_SESSION['user_id'];
      $response_data  = [];
      $schools = DB::table('school')
        ->where('school_owner_id',$schol_owenr_id)
        ->where('status',1)
        ->get();
      foreach ($schools as $key => $school) {
        $response_data[] = [
          'school_name' => $school->school_name,
          'depts_count' => $this->getDeptsCountBySchoolId( $school->id ),
          'staff_count' => $this->getStaffCountBySchoolId( $school->id ),
          'studs_count' => $this->getStudentsCountBySchoolId( $school->id ),
          'labs_count'  => $this->getLabsCountBySchoolId( $school->id )
        ];
      }
      return response()->json($response_data,200);
    }catch(\Exception $e){
      return 0;
    }
  }

  public function getDeptsCountBySchoolId($school_id){
      try{
        $depts = DB::table('departments')
          ->where('school_id',$school_id)
          ->count();
        return $depts;
      }catch(\Exception $e){
        return 0;
      }
  }

  public function getStaffCountBySchoolId($school_id){
    try{
      $stff = DB::table('teacher')
        ->where('school_id',$school_id)
        ->count();
      return $stff;
    }catch(\Exception $e){
      return 0;
    }
  }

  public function getStudentsCountBySchoolId($school_id){
    try{
      $students = DB::table('student')
        ->where('school_id',$school_id)
        ->count();
      return $students;
    }catch(\Exception $e){
      return 0;
    }
  }

  public function getLabsCountBySchoolId($school_id){
    try{
      $labs = DB::table('labs')
        ->where('school_id',$school_id)
        ->count();
    return $labs;
    }catch(\Exception $e){
      return 0;
    }
  }
}
