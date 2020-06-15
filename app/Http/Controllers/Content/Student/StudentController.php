<?php

namespace App\Http\Controllers\Content\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Content\CommonController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class StudentController extends Controller
{
	private $commonController;
  	public function __construct(){		  
		$this->commonController = new CommonController();
	}

  	public function addStudent(){
		$return_data = [];
		try{
			if($_SESSION['ins'] == 'college'){
				//college code
			}else{				
				$return_data = $this->getDataToAddSTudent();		
				return view('student.addSchoolStudent',['return_data' => $return_data]);
			}
		}catch(\Exception $e){			
			return view('excep',['error'=>$e->getMessage()]);
		}
	}
	
	public function getDataToAddSTudent(){
		try{
			if($_SESSION['ins'] == 'college'){
				//college code
			}else{
				$schools = $this->commonController->getInstitutesByUser('school');
				foreach($schools as $school){
					$return_data[] = [
						'school_id'    => $school->id,
						'school_name'  => $school->school_name,
						'school_years' => $this->getSchoolClassesByYear($school->id),
					];
				}
				return $return_data;
			}
		}catch(\Exception $e){
			return [];
		}
	}


	public function getSchoolClassesByYear($school_id){
		$response_data = [];
		$years = $this->commonController->getYearsByInsId($school_id);
		foreach($years as $year){
			$response_data[] = [
				'year_id'      => $year->id,
				'year_name'    => $year->grade_year,
				'year_classes' => $this->commonController->getClassesByYear($year->id),
			];
		}
		return $response_data;
	}
  	public function storeStudent(Request $request){
    	$sid      = strip_tags($request['reg-id']);
    	$fname    = strip_tags($request['fname']);
    	$lname    = strip_tags($request['lname']);
    	$gender   = strip_tags($request['gender']);
    	$father   = strip_tags($request['father']);
    	$mother   = strip_tags($request['mother']);
	    $phone    = strip_tags($request['phone']);
		$email    = strip_tags($request['email']);
		$address  = strip_tags($request['address']);
		$school   = $request['school_id'];
		$grade    = $request['grade'];
		$dept     = $request['department'];
		$class    = $request['class'];
		$ins_type = $request['type'];
		//$hex      = bin2hex(openssl_random_pseudo_bytes(16));
		try{
			//$type    = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));
			//move_uploaded_file($_FILES['photo']['tmp_name'],storage_path()."/app/public/student_images/".$hex.'.'.$type);
			$query = DB::table('student')
				->insertGetId([
					'sid'         => $sid,
					'fname'       => $fname,
					'lname'       => $lname,
					'gender'      => $gender,
					'father_name' => $father,
					'mother_name' => $mother,
					'phone'       => $phone,
					'email'       => $email,
					'address'     => $address,
					'school_id'   => $school,
					'grade_id'    => $grade,
					'dept_id'     => $dept,
					'class_id'    => $class,
					'photo'       => $request['image_url'],//$request->getSchemeAndHttpHost().Storage::url('student_images/'.$hex.'.'.$type),
					'ins_type'    => $ins_type,
				]
			);
			$insert = DB::table('student_attendence')
				->insert([
					'sid'        => $query,
					'percentage' => 0,
					'month'      => date('m')
				]);
			return redirect('/manage/students');
		}catch(\Exception $e){
			return view('excep',['error'=>$e->getMessage()]);
		}
  	}

  public function manageStudents(){
    try{
        $owner_id = $_SESSION['user_id'];
		$response_data   = [];
		if($_SESSION['ins'] == 'colleghe'){
			//college code
		}else{
			$schools = $this->commonController->getInstitutesByUser('school');
			foreach($schools as $school ){
				$response_data[] = [
					'school_name'  => $school->school_name,
					'school_id'    => $school->id,
					'school_years' => $this->getYearsByInsId($school->id),
				];
			}			
			return view('student.manageSchoolStudents',['response_data'=> $response_data]);
		}        
    }catch(\Exception $e){
        return view('excep',['error'=>$e->getMessage()]);
    }
  }

  public function getYearsByInsId($school_id){
	try{
		$response_data = [];
		$years = $this->commonController->getYearsByInsId($school_id);
		foreach($years as $year){
			$response_data [] = [
				'year_id'       => $year->id,
				'year_name'     => $year->grade_year,
				'year_students' => $this->getStudentsYear($year->id)
			];
		}
		return $response_data;
	}catch(\Exception $e){
		return [];
	}
  }
  public function getStudentsYear($year){
	try{
		$students = DB::table('student')
			->join('class','class.id','=','student.class_id')
			->where('grade_id',$year)
			//->where('ins_type',$_SESSION['ins'])
			->select(['fname','lname','father_name','mother_name','student.id','sid','class.class_name','phone','email'])
			->get();
		return $students;
	}catch(\Exception $e){
		return [];
	}
  }
  public function getDeptsBySchoolId($school_id){
    $return_data = [];
    $deps = DB::table('departments')->where('school_id',$school_id)->get();
      foreach ($deps as $dep) {
        $return_data[] = [
          'id'            => $dep->id,
          'dept_name'     => $dep->d_name,
          'students_data' => $this->getStudentsByDeptId($dep->id),
        ];
      }
    return $return_data;
  }

  public function getStudentsByDeptId($dept_id){
    $return_data = [];
    $return_data['students'] = DB::table('student')
      ->join('grades','grades.id','=','student.grade_id')
      ->join('class','class.id','=','student.class_id')
      ->where('student.dept_id',$dept_id)
      ->orderBy('sid')
      ->select(['fname','lname','father_name','mother_name','student.id','sid','year','value','phone'])
      ->get();
    return $return_data;
  }


  public function editStudent(Request $request){
    try{      
		$stud_id = base64_decode($request['id']);		
      	$student = DB::table('student')
        	->where('id',$stud_id)
			->first();		
     	return view('student.editStudent',['student' => $student]);
    }catch(\Exception $e){
    	return view('excep',['error'=>$e->getMessage()]);
    }
  }

  public function updateStudent(Request $request){
    $stud_id = $request['id'];
    $sid     = strip_tags($request['reg-id']);
    $fname   = strip_tags($request['fname']);
    $lname   = strip_tags($request['lname']);
    $gender  = strip_tags($request['gender']);
    $father  = strip_tags($request['father']);
    $mother  = strip_tags($request['mother']);
    $phone   = strip_tags($request['phone']);
    $email   = strip_tags($request['email']);
    $address = strip_tags($request['address']);    
	//$hex     = bin2hex(openssl_random_pseudo_bytes(16));	
    try{
      //$type    = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));
      if(strlen($request['image_url']) != 0){
        //move_uploaded_file($_FILES['photo']['tmp_name'],"storage/student_images/".$hex.'.'.$type);
        $query = DB::table('student')
          ->where('id',$stud_id)
          ->update([
            'fname'       => $fname,
            'lname'       => $lname,
            'gender'      => $gender,
            'father_name' => $father,
            'mother_name' => $mother,
            'phone'       => $phone,
            'email'       => $email,
            'address'     => $address,            
            'photo'       => $request['image_url'],//$request->getSchemeAndHttpHost().Storage::url('student_images/'.$hex.'.'.$type),
          ]);
      }else{
        $query = DB::table('student')
          ->where('id',$stud_id)
          ->update([
            'fname'       => $fname,
            'lname'       => $lname,
            'gender'      => $gender,
            'father_name' => $father,
            'mother_name' => $mother,
            'phone'       => $phone,
            'email'       => $email,
            'address'     => $address,
          ]);
      }
      return redirect('/manage/students');
    }catch(\Exception $e){
		return view('excep',['error'=>$e->getMessage()]);
    }
  }

  public function deleteStudent(Request $request){
    try{
      $stud_id = $request['id'];
      $delete  = DB::table('student')
        ->where('id',$stud_id)
        ->delete();
    }catch(\Exception $e){
		return view('excep',['error'=>$e->getMessage()]);
    }
  }

	public function viewStudent(Request $request){
		try{
			$stud_id = base64_decode($request['id']);
			$stud_data = [];
			if($_SESSION['ins'] == 'college'){
				//collge
			}else{
				$student = DB::table('student')
					->where('student.id',$stud_id)
					->where('student.ins_type','school')
					->join('grades','grades.id','=','student.grade_id')
					->join('school','school.id','=','student.school_id')					
					->first();				
				$stud_data['student'] = $student;
				$stud_data['class']   = $this->getStudentClassData($student->class_id);								
				return view('student.viewSchoolStudent',['student_data'=>$stud_data]);
			}		
		}catch(\Exception $e){					
			return view('excep',['error'=>$e->getMessage()]);
		}
	}
	
	public function getStudentClassData($class_id){
		try{
			$response_data = [];
			$class = DB::table('class')
				->where('class.id',$class_id)
				->join('subjects','class.id','=','subjects.class_id')
				->first();			
			$response_data['class_data'] = $class;
			return $response_data;
		}catch(\Exception $e){
			return [];
		}
	}

	public function importStudentView(Request $request){
		$return_data = $this->getDataToAddSTudent();
		return view('student.importStudents',['return_data'=>$return_data]);
	}

	public function importStudents(Request $request){
		try{
			$school_id = $request['school_id'];
			$grade     = $request['grade'];			
			$class_id  = $request['class'];
			$ins_type = $_SESSION['ins'];			
			$type = strtolower(pathinfo($_FILES['data_file']['name'],PATHINFO_EXTENSION));
			if($type ==='xlsx'){
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
			}elseif($type === 'xls'){
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
			}
			$reader->setReadDataOnly(true);
			$worksheetData = $reader->listWorksheetInfo($_FILES['data_file']['tmp_name']);			
			foreach ($worksheetData as $worksheet) {
				$sheetName = $worksheet['worksheetName'];				
				$reader->setLoadSheetsOnly($sheetName);
				$spreadsheet = $reader->load($_FILES['data_file']['tmp_name']);
				$worksheet = $spreadsheet->getActiveSheet();				
				$rows = $worksheet->toArray();
				foreach($rows as $key => $row){			
					$student = array_unique($row);
					if($key != 0 )
					{
						$sid        = $student[0];
						$fname      = $student[1];
						$lname      = $student[2];
						$fathername = $student[3];
						$mothername = $student[4];
						$phone      = $student[5];
						$email      = $student[6];
						$address    = $student[7];
						$gender     = $student[8];						
						$id    = DB::table('student')
							->insertGetId([
								'sid'         => $sid,
								'fname'       => $fname,
								'lname'       => $lname,
								'father_name' => $fathername,
								'mother_name' => $mothername,
								'phone'       => $phone,
								'email'       => $email,
								'address'     => $address,
								'gender'      => $gender,
								'school_id'   => $school_id,
								'grade_id'    => $grade,
								'dept_id'     => 0,
								'class_id'    => $class_id,
								'ins_type'    => $ins_type,
							]
						);
						$query = DB::table('student_attendence')
							->insert([
								'sid'        => $id,
								'percentage' => 0,
								'month'      => date('m'),
							]
						);
					}
				}
			}
			return redirect('/manage/students');
		}catch(\Exception $e){
			return $e->getMessage();
		}
	}
}
