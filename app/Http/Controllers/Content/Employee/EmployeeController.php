<?php

namespace App\Http\Controllers\Content\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Content\CommonController;
class EmployeeController extends Controller
{
  	private $commonController;
  	public function __construct(){
    $this->commonController = new CommonController();
  	}

	public function addEmployee(){
		$return_data = [];
		if($_SESSION['ins'] == 'college'){
			//college code
		}else{
			$ins = $this->commonController->getInstitutesByUser('school');
			foreach($ins as $institute){
				$return_data[] = [
					'ins_id'    => $institute->id,
					'ins_name'  => $institute->school_name,
					'ins_depts' => $this->commonController->getDeptsByInsId($institute->id),
				];
			}		
			return view('employee.addSchoolEmployee',['return_data'=>$return_data]);
		}
	}
	public function storeEmployee(Request $request){
		$emp_reg_num      = strip_tags($request['staff_id']);
		$emp_username     = strip_tags($request['staffname']);
		$emp_phone        = strip_tags($request['phone']);
		$emp_email        = strip_tags($request['email']);
		$emp_designation  = strip_tags($request['designation']);
		$emp_institute    = strip_tags($request['ins_id']);
		$emp_depart       = strip_tags($request['department']);
		$emp_owner        = $_SESSION['user_id'];
		$emp_device_token = 'device_token';
		$emp_password     = Hash::make('password');
		//$hex              = bin2hex(openssl_random_pseudo_bytes(16));
		$emp_join_date    = $request['doj'];
		try{
			//$type    = strtolower(pathinfo($_FILES['profile']['name'],PATHINFO_EXTENSION));
			//move_uploaded_file($_FILES['profile']['tmp_name'],"storage/emp_images/".$hex.'.'.$type);
			$query = DB::table('emplyoee')
				->insertGetId(
				[
					'emp_reg_num'      => $emp_reg_num,
					'emp_username'     => $emp_username,
					'emp_phone'        => $emp_phone,
					'emp_email'        => $emp_email,
					'emp_institute'    => $emp_institute,
					'emp_depart'       => $emp_depart,                
					'emp_designation'  => $emp_designation,
					'emp_photo'        => $request['image_url'],//$request->getSchemeAndHttpHost().Storage::url('emp_images/'.$hex.'.'.$type),
					'emp_owner'        => $emp_owner,
					'emp_device_token' => $emp_device_token,
					'emp_join_date'    => $emp_join_date,
					'emp_password'     => $emp_password
				]
			);
			return redirect('/manage/employees');
		}catch(\Exception $e){
			return view('excep',['error'=>$e->getMessage()]);
		}
	}
	public function manageEmployees(){
		try{
			$return_data = [];
			$institutes = $this->commonController->getInstitutesByUser($_SESSION['ins']);
			foreach($institutes as $institute){
				$return_data[] = [
					'ins_id'    => $institute->id,
					'ins_name'  => $_SESSION['ins'] == 'college' ? $institute->clg_name : $institute->school_name,
					'ins_depts' => $this->getDeptsByInsId($institute->id)
				];
			}
			return view('employee.manageEmployess',['return_data'=>$return_data]);
		}catch(\Exception $e){
			return $e->getMessage();
			return view('excep',['error'=>$e->getMessage()]);
		}
  	}

  	public function getDeptsByInsId($ins_id){
		try{
			$response_data = [];
			$depts = $this->commonController->getDeptsByInsId($ins_id);
			foreach($depts as $dept){
				$response_data[] = [
					'dept_id'   => $dept->id,
					'dept_name' => $dept->dept_name,
					'dept_emps' => $this->getEmployeesByDept($dept->id)
				];
			}
			return $response_data;
		}catch(\Exception $e){
			return [];
		}
  	}

	public function getEmployeesByDept($dept_id){
		try{
			$employees = DB::table('emplyoee')
				->where('emp_depart',$dept_id)
				->get();
			return $employees;
	  	}catch(\Exception $e){
			return [];
	  	}
	  }
	  
	public function editEmployee(Request $request){
		return view('csoon');
	}

	public function updateEmployee(Request $request){
		return view('csoon');
	}

	public function deleteEmployee(Request $request){
		return view('csoon');
	}
}