<?php

namespace App\Http\Controllers\Content;

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
    	$owenr_id = $_SESSION['user_id'];
		$response_data  = [];
		if($_SESSION['ins'] == 'college'){
			$schools = DB::table('college')
        	->where('clg_owner',$owenr_id)        	
        	->get();
      	foreach ($schools as $key => $school) {
        	$response_data[] = [
          		'school_name' => $school->clg_name,
          		'depts_count' => $this->getDeptsCountBySchoolId( $school->id ),
				'emps_count'  => $this->getEmpsCountBySchoolId( $school->id ),
				'staff_count' => $this->getStaffCountBySchoolId( $school->id ),
				'studs_count' => $this->getStudentsCountBySchoolId( $school->id ),
				'labs_count'  => $this->getLabsCountBySchoolId( $school->id )
        	];
      	}
      	return response()->json($response_data,200);
		}else{
			$schools = DB::table('school')
        		->where('school_owner',$owenr_id)        	
        		->get();
      		foreach ($schools as $key => $school) {
        		$response_data[] = [
					'school_name' => $school->school_name,
					'depts_count' => $this->getDeptsCountBySchoolId( $school->id ),
					'emps_count'  => $this->getEmpsCountBySchoolId( $school->id ),
					'staff_count' => $this->getStaffCountBySchoolId( $school->id ),
					'studs_count' => $this->getStudentsCountBySchoolId( $school->id ),
					'labs_count'  => $this->getLabsCountBySchoolId( $school->id )
        		];
      		}
      		return response()->json($response_data,200);
		}
    }catch(\Exception $e){
    	return $e->getMessage();
    }
  }

  public function getDeptsCountBySchoolId($school_id){
      try{
        $depts = DB::table('departments')
          ->where('dept_ins_id',$school_id)
          ->count();
        return $depts;
      }catch(\Exception $e){
        return 0;
      }
  }

  public function getStaffCountBySchoolId($school_id){
	try{
		$staff = DB::table('teacher')
			->where('teacher_ins_id',$school_id)
			->where('teacher_ins_type',$_SESSION['ins'])
        	->count();
      	return $staff;
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

  public function getEmpsCountBySchoolId($school_id){
	  try{
		$emps = DB::table('emplyoee')
			->where('emp_institute',$school_id)
			->count();
		return $emps;
	  }catch(\Exception $e){
		  return 0;
	  }
  }
}
