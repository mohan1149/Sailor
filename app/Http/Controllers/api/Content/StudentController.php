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

}
