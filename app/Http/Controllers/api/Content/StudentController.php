<?php

namespace App\Http\Controllers\api\Content;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\api\Content\SchoolController;
class StudentController extends Controller
{
  private $schoolController;
  public function __construct(){
      $this->schoolController = new SchoolController();
  }
  public function addStudent(){
      $schools = $this->schoolController->getSchoolsByUser();
      return view('addStudent',['schools'=>$schools]);
  }

  public function storeStudent(Request $request){
    $sid     = strip_tags($request['reg-id']);
    $fname   = strip_tags($request['fname']);
    $lname   = strip_tags($request['lname']);
    $gender  = strip_tags($request['gender']);
    $father  = strip_tags($request['father']);
    $mother  = strip_tags($request['mother']);
    $phone   = strip_tags($request['phone']);
    $email   = strip_tags($request['email']);
    $address = strip_tags($request['address']);
    $school  = $request['school_id'];
    $grade   = $request['grade'];
    $dept    = $request['department'];
    $class   = $request['class'];
    $hex     = bin2hex(openssl_random_pseudo_bytes(16));
    try{
      $type    = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));
      move_uploaded_file($_FILES['photo']['tmp_name'],storage_path()."/app/public/student_images/".$hex.'.'.$type);
      $query = DB::table('student')
        ->insert([
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
          'photo'       => $request->getSchemeAndHttpHost().Storage::url('student_images/'.$hex.'.'.$type),
        ]);
      return redirect('/manage/students');
    }catch(\Exception $e){
      return response()->json($e->getMessage(),500);
    }
  }

  public function manageStudents(){
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
        return view('manageStudents',['response_data'=>$response_data]);
    }catch(\Exception $e){
        return view('excep');
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
      ->get();
    return $return_data;
  }
  public function editStudent(Request $request){
    try{
      $schools = $this->schoolController->getSchoolsByUser();
      $stud_id = base64_decode($request['id']);
      $student = DB::table('student')
        ->where('id',$stud_id)
        ->first();
      $stud_data['schools'] = $schools;
      $stud_data['student'] = $student;
      return view('editStudent',['stud_data' => $stud_data]);
    }catch(\Exception $e){
      return view('excep');
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
    $school  = $request['school_id'];
    $grade   = $request['grade'];
    $dept    = $request['department'];
    $class   = $request['class'];
    $hex     = bin2hex(openssl_random_pseudo_bytes(16));
    try{
      $type    = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));
      if($type != ''){
        move_uploaded_file($_FILES['photo']['tmp_name'],storage_path()."/app/public/student_images/".$hex.'.'.$type);
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
            'school_id'   => $school,
            'grade_id'    => $grade,
            'dept_id'     => $dept,
            'class_id'    => $class,
            'photo'       => $request->getSchemeAndHttpHost().Storage::url('student_images/'.$hex.'.'.$type),
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
            'school_id'   => $school,
            'grade_id'    => $grade,
            'dept_id'     => $dept,
            'class_id'    => $class,
          ]);
      }
      return redirect('/manage/students');
    }catch(\Exception $e){
      return response()->json($e->getMessage(),500);
    }
  }

  public function deleteStudent(Request $request){
    try{
      $stud_id = $request['id'];
      $delete  = DB::table('student')
        ->where('id',$stud_id)
        ->delete();
    }catch(\Exception $e){
      return view('excep');
    }
  }

  public function viewStudent(Request $request){
    return view('csoon');
  }
}
