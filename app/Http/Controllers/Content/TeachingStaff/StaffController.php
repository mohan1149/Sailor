<?php

namespace App\Http\Controllers\Content\TeachingStaff;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Content\CommonController;
class StaffController extends Controller
{
    private $commonController;    
    public function __construct(){
        $this->commonController = new CommonController();
    }
    public function addStaff(){
		$return_data = [];
		$ins_type    = $_SESSION['ins'];
        $ins = $this->commonController->getInstitutesByUser($ins_type);
        foreach($ins as $institute){
			$return_data[] = [
				'ins_id'    => $institute->id,
				'ins_name'  => $ins_type == 'college' ? $institute->clg_name : $institute->school_name,
				'ins_depts' => $this->commonController->getDeptsByInsId($institute->id),
			];
		}
		if($ins_type == 'college'){
			return view('teaching_staff.addCollegeStaff',['return_data'=>$return_data]);
		}else{
			return view('teaching_staff.addSchoolStaff',['return_data'=>$return_data]);
		}   
    }
    public function storeStaff(Request $request)
    {
        $teacher_reg_id      = strip_tags($request['staff_id']);
        $teacher_name        = strip_tags($request['staffname']);
        $teacher_phone       = strip_tags($request['phone']);
        $teacher_email       = strip_tags($request['email']);
        $teacher_designation = strip_tags($request['designation']);
        $teacher_ins_id      = strip_tags($request['ins_id']);
		$teacher_dept        = strip_tags($request['department']);
		$teacher_join_date   = $request['doj'];
		$teacher_ins_type    = $request['type'];
        //$hex                 = bin2hex(openssl_random_pseudo_bytes(16));
        try{
          //$type    = strtolower(pathinfo($_FILES['profile']['name'],PATHINFO_EXTENSION));
          //move_uploaded_file($_FILES['profile']['tmp_name'],"storage/staff_images/".$hex.'.'.$type);
            $query = DB::table('teacher')
              ->insertGetId(
                [
                  'teacher_reg_id'      => $teacher_reg_id,
                  'teacher_name'        => $teacher_name,
                  'teacher_phone'       => $teacher_phone,
                  'teacher_email'       => $teacher_email,
                  'teacher_ins_id'      => $teacher_ins_id,
                  'teacher_dept'        => $teacher_dept,                  
                  'teacher_designation' => $teacher_designation,
				  'teacher_profile'     => $request['image_url'],//$request->getSchemeAndHttpHost().Storage::url('staff_images/'.$hex.'.'.$type),
				  'teacher_join_date'   => $teacher_join_date,
				  'teacher_ins_type'    => $teacher_ins_type
                ]
              );
              $addEmp = DB::table('emplyoee')
                ->insert([
                  'emp_username'        => $teacher_name,
                  'emp_reg_num'         => $teacher_reg_id,
                  'emp_institute'       => $teacher_ins_id,
                  'emp_depart'          => $teacher_dept,
                  'emp_join_date'       => $teacher_join_date,
                  'emp_phone'           => $teacher_phone,
                  'emp_email'           => $teacher_email,
                  'emp_photo'           => $request['image_url'],//$request->getSchemeAndHttpHost().Storage::url('staff_images/'.$hex.'.'.$type),                  
                  'emp_password'        => Hash::make('password'),
                  'emp_owner'           => $_SESSION['user_id'],
                  'emp_designation'     => $teacher_designation,
				  'emp_device_token'    =>'token',
				  'teacher_foriegn_key' => $query,
                ]);
            return redirect('/manage/staff');
        }catch(\Exception $e){          
          return view('excep',['error'=>$e->getMessage()]);
        }
    } 
    public function manageStaff(){
    	try{
        	$school_owner_id = $_SESSION['user_id'];
		  	$response_data   = [];
		  	if($_SESSION['ins'] == 'college'){
				$colleges =  $this->commonController->getInstitutesByUser('college');
			  	foreach($colleges as $college){
					$response_data [] =
					[
						'clg_id'    => $college->id,
						'clg_name'  => $college->clg_name,
						'clg_depts' => $this->getDeptsByInsId($college->id)
					];
				}				
				return view('teaching_staff.manageCollegeStaff',['response_data'=>$response_data]);
		  	}else{
				$schools = $this->commonController->getInstitutesByUser('school');
          		foreach ($schools as $school) {
					$response_data[] = 
					[
              			'school_id'    => $school->id,
              			'school_name'  => $school->school_name,
              			'school_depts' => $this->getDeptsByInsId($school->id),
            		];
		  		}
				  return view('teaching_staff.manageSchoolStaff',['response_data'=>$response_data]);
		}                    
      	}catch(\Exception $e){		  	
          	return view('excep',['error'=>$e->getMessage()]);
      	}
    }

	public function getDeptsByInsId($ins_id){
		$return_data = [];
		$depts = $this->commonController->getDeptsByInsId($ins_id);
		foreach($depts as $dept){
			$return_data[] = [
				'dept_id'    => $dept->id,
				'dept_name'  => $dept->dept_name,
				'staff_data' => $this->geStaffByDeptId($dept->id),
			];
		}
		return $return_data;
	}
    public function geStaffByDeptId($dept_id){
      $return_data = DB::table('teacher')
        ->where('teacher_dept',$dept_id)
        ->orderBy('teacher_name')
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
        return view('excep',['error'=>$e->getMessage()]);
      }
    }
    public function editStaff(Request $request){
      try{
        $staff_id   = base64_decode($request['id']);
        $staff_data = DB::table('teacher')
          ->where('id',$staff_id)
          ->first();
        return view('teaching_staff.editStaff',['staff_data'=>$staff_data]);
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
        //$hex               = bin2hex(openssl_random_pseudo_bytes(16));
        //$type              = strtolower(pathinfo($_FILES['profile']['name'],PATHINFO_EXTENSION));
        if(strlen($request['image_url']) != 0){				
          //move_uploaded_file($_FILES['profile']['tmp_name'],"storage/staff_images/".$hex.'.'.$type);
          $update = DB::table('teacher')
            ->where('id',$staff_id)
            ->update([
              'teacher_reg_id'      => $staff_sid,
              'teacher_name'        => $staff_name,
              'teacher_phone'       => $staff_phone,
              'teacher_email'       => $staff_email,
              'teacher_designation' => $staff_designation,
              'teacher_profile'     => $request['image_url'],//$request->getSchemeAndHttpHost().Storage::url('staff_images/'.$hex.'.'.$type),

            ]
		  );
			$update = DB::table('emplyoee')
				->where('teacher_foriegn_key',$staff_id)
				->update([
					'emp_reg_num'     => $staff_sid,
					'emp_username'    => $staff_name,
					'emp_phone'       => $staff_phone,
					'emp_email'       => $staff_email,
					'emp_designation' => $staff_designation,
					'emp_photo'       => $request['image_url'],//$request->getSchemeAndHttpHost().Storage::url('staff_images/'.$hex.'.'.$type),
				]
			);
        }else{
          $update = DB::table('teacher')
		  	->where('id',$staff_id)
            ->update([
              'teacher_reg_id'     => $staff_sid,
              'teacher_name'        => $staff_name,
              'teacher_phone'       => $staff_phone,
              'teacher_email'       => $staff_email,
              'teacher_designation' => $staff_designation
            ]
		  );
		  $update = DB::table('emplyoee')
		  ->where('teacher_foriegn_key',$staff_id)
		  ->update([
			  'emp_reg_num'     => $staff_sid,
			  'emp_username'    => $staff_name,
			  'emp_phone'       => $staff_phone,
			  'emp_email'       => $staff_email,
			  'emp_designation' => $staff_designation,			  
		  ]
	  );
        }
        return redirect('/manage/staff');
      }catch(\Exception $e){
		  return $e->getMessage();
        return view('excep',['error'=>$e->getMessage()]);
      }
    }

    public function viewStaff(Request $request){
      $teacher_id   = base64_decode($request['id']);
      $teacher_data = [];
      try{
    	$teacher = DB::table('teacher')
        	->where('id',$teacher_id)
          	->first();
		$ins_id  = $teacher->teacher_ins_id;
		if($_SESSION['ins'] == 'college'){
			$periods = DB::table('college')
        	->where('id',$ins_id)
          	->select(['clg_periods'])
          	->first();
			$ins_periods = $periods->clg_periods;
		}else{
			$periods = DB::table('school')
        	->where('id',$ins_id)
          	->select(['school_periods'])
          	->first();
			$ins_periods = $periods->school_periods;
		}		
        $weeks = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
        $timetable = [];
        foreach ($weeks as $week) {
          for($i = 1; $i <= $ins_periods; $i++){
            $timetable[$week][$i] = DB::table('timetable')
              ->join('class','timetable.class_id','=','class.id')
              ->whereRaw($week."->'".$i."'->>'staff_id' = ? ",[$teacher_id])
              ->selectRaw($week."->'".$i."'->>'subject' as subject,class_id,class.class_name")
              ->first($week);
          }
        }        
        $staff_data['staff']    = $teacher;
		$staff_data['timetable'] = $timetable;			
        return view('teaching_staff.viewStaff',['staff_data'=>$staff_data]);
      }catch(\Exception $e){
		return $e->getMessage();
        return view('excep',['error'=>$e->getMessage()]);
      }
    }
}
