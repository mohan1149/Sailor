<?php

namespace App\Http\Controllers\Content\Labs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Content\CommonController;
class LabsController extends Controller
{
  private $commonController;
  public function __construct(){
    $this->commonController = new CommonController();
  }

  public function addLab(){
    $schools = $this->commonController->getInstitutesByUser('school');
    foreach($schools as $school){
      $return_data  [] = [
        'schoolId'   => $school->id,
        'schoolName' => $school->school_name,
        'ins_depts'  => $this->commonController->getDeptsByInsId($school->id)
      ];
    }
    return view('labs.addLab',['schools'=>$return_data]);
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
      return view('excep',['error'=>$e->getMessage()]);
    }
  }
  public function manageLabs(){
    try{
        $owner = $_SESSION['user_id'];
        $response_data   = [];
        $schools =$this->commonController->getInstitutesByUser('school');
        foreach ($schools as $school) {
          $response_data[] = [
            'id'          => $school->id,
            'school_name' => $school->school_name,
            'dept_data'   => $this->getDeptsByInsId($school->id)
          ];
		}		
        return view('labs.manageLabs',['response_data'=>$response_data]);
    }catch(\Exception $e){      
      return view('excep',['error'=>$e->getMessage()]);
    }
  }

  public function getDeptsByInsId($ins_id){
	try{
		$return_data = [];
		$depts = $this->commonController->getDeptsByInsId($ins_id);
		foreach($depts as $dept){
			$return_data[] = [
				'id' => $dept->id,
				'dept_name' => $dept->dept_name,
				'lab_data' => $this->commonController->getLabsByDeptId($dept->id),
			];
		}
		return $return_data;
	}catch(\Exception $e){
		return [];
	}
  }

  public function editLab(Request $request){
    try{
      $lab_id   = base64_decode($request['id']);
      $lab_data = DB::table('labs')
        ->where('id',$lab_id)
        ->first();
      return view('labs.editLab',['lab_data'=>$lab_data]);
    }catch(\Exception $e){

		return view('excep',['error'=>$e->getMessage()]);
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
