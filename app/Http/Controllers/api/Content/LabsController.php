<?php

namespace App\Http\Controllers\api\Content;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\api\Content\SchoolController;
class LabsController extends Controller
{
  private $schoolController;
  public function __construct(){
    $this->schoolController = new SchoolController();
  }

  public function addLab(){
    $schools = $this->schoolController->getSchoolsByUser();
    return view('addLab',['schools'=>$schools]);
  }

  public function storeLab(Request $request){
    try{
      $lab      = strip_tags($request['lab']);
      $school   = $request['school_id'];
      $dept     = $request['department'];
      $machines = strip_tags($request['machines']);
      $insert_q = DB::table('labs')
        ->insert([
          'name'      => $lab,
          'school_id' => $school,
          'dept_id'   => $dept,
          'machines'  => $machines,
        ]);
      return redirect('/manage/labs');
    }catch(\Exception $e){
      return view('excep');
    }
  }
  public function manageLabs(){
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
        return view('manageLabs',['response_data'=>$response_data]);
    }catch(\Exception $e){
        return view('excep');
    }
  }

  public function getDeptsBySchoolId($school_id){
    $return_data = [];
    $deps = DB::table('departments')->where('school_id',$school_id)->get();
      foreach ($deps as $dep) {
        $return_data[] = [
          'id'        => $dep->id,
          'dept_name' => $dep->d_name,
          'lab_data'  => $this->getClassesByDeptId($dep->id),
        ];
      }
    return $return_data;
  }

  public function getClassesByDeptId($dept_id){
    $return_data = [];
    $return_data['labs'] = DB::table('labs')
      ->where('dept_id',$dept_id)
      ->get();
  return $return_data;
  }

  public function editLab(Request $request){
    try{
      $lab_id   = base64_decode($request['id']);
      $lab_data = DB::table('labs')
        ->where('id',$lab_id)
        ->first();
      return view('editLab',['lab_data'=>$lab_data]);
    }catch(\Exception $e){
      return view('excep');
    }
  }

  public function updateLab(Request $request){
    try{
      $lab_id   = $request['id'];
      $name     = strip_tags($request['lab']);
      $machines = strip_tags($request['machines']);
      $update = DB::table('labs')
        ->where('id',$lab_id)
        ->update([
          'name'     => $name,
          'machines' => $machines,
        ]);
      return redirect('/manage/labs');
    }catch(\Exception $e){
      return view('excep');
    }
  }

  public function deleteLab(Request $request){
    try{
      $lab_id = $request['id'];
      $delete = DB::table('labs')
        ->where('id',$lab_id)
        ->delete();
      return redirect('/manage/labs');
    }
    catch(\Expection $e){
      return view('excep');
    }
  }
}
