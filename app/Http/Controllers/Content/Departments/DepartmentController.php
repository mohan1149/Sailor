<?php

namespace App\Http\Controllers\Content\Departments;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Content\CommonController;
class DepartmentController extends Controller
{
    private $commonController;
    public function __construct(){
        $this->commonController = new CommonController();
    }
    public function addDepartment(Request $request){ 
        $ins_type           = $_SESSION['ins'];
        $return_data        = [];          
        $return_data['ins'] = $this->commonController->getInstitutesByUser($ins_type);
        if($ins_type == 'college'){
            return view('departments.addDepartmentToCollege',['return_data'=>$return_data]);
        }elseif($ins_type == 'school'){
            return view('departments.addDepartmentToSchool',['return_data'=>$return_data]);
        }else{
            return view('excep',['error'=>'Invalid Route']);
        }        
    }

    //function to store departments
    public function storeDepartment(Request $request){
        $dept_name     = strip_tags($request['dept-name']);
        $dept_ins_id   = strip_tags($request['ins_id']);
        $dept_email    = strip_tags($request['email']);
        $dept_website  = strip_tags($request['website']);
        $dept_ins_type = $request['type'];
        //$hex           = bin2hex(openssl_random_pseudo_bytes(16));
        //$imageFileType = strtolower(pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));
       // move_uploaded_file($_FILES['logo']['tmp_name'],"storage/dep_logos/".$hex.'.'.$imageFileType);
        try{
            $query = DB::table('departments')
                ->insert([
                    'dept_name'     => $dept_name,
                    'dept_ins_id'   => $dept_ins_id,
                    'dept_email'    => $dept_email,
                    'dept_website'  => $dept_website,
                    'dept_logo'     => $request['image_url'],//$request->getSchemeAndHttpHost().Storage::url('dep_logos/'.$hex.'.'.$imageFileType),
                    'dept_ins_type' => $dept_ins_type
                ]);
            if($query){
                return redirect('/manage/departments');
            }else{
                return view('excep',['error'=>$e->getMessage()]); 
            }
        }catch(\Exception $e){
            return $e->getMessage();
            return view('excep',['error'=>$e->getMessage()]);
        }
    }

    //function to manage departments
    public function manageDepartments(){
        try{
            $return_data  = [];
            $college_data = [];
            $school_data  = [];
            $owner_id = $_SESSION['user_id'];
            if($_SESSION['ins'] == 'college'){
                $colleges = DB::table('college')
                    ->where('clg_owner',$owner_id)
                    ->get();
                foreach($colleges as $college){
                    $college_data[] = [
                        'clg_id'    => $college->id,
                        'clg_name'  => $college->clg_name,
                        'clg_depts' => $this->getDeptsByCollegeId($college->id)                    
                    ];
                }
                $return_data['colleges'] = $college_data;
                return view('departments.manageCollegeDepts',['return_data'=>$return_data]);
            }else{
                $schools = DB::table('school')
                    ->where('school_owner',$owner_id)
                    ->get();
                foreach($schools as $school){
                    $school_data[] = [
                        'school_id'    => $school->id,
                        'school_name'  => $school->school_name,
                        'school_depts' => $this->getDeptsBySchoolId($school->id)                    
                    ];
                }            
                $return_data['schools']  = $school_data;
                return view('departments.manageSchoolDepts',['return_data'=>$return_data]);
            }            
        }catch(\Exception $e){            
            return view('excep',['error'=>$e->getMessage()]);
        }
    }

    public function getDeptsByCollegeId($clg_id){
        try{
            $depts = DB::table('departments')
                ->where('dept_ins_id',$clg_id)
                ->where('dept_ins_type','college')
                ->get();
            return $depts;
        }catch(\Exception $e){
            return [];
        }
    }

    public function getDeptsBySchoolId($school_id){
        try{
            $depts = DB::table('departments')
                ->where('dept_ins_id',$school_id)
                ->where('dept_ins_type','school')
                ->get();
            return $depts;
        }catch(\Exception $e){
            return [];
        }
    }

    public function deptsByIns(Request $request){
        $depts  = [];
        $type   = $_SESSION['ins'];
        $ins_id = base64_decode($request['id']);
        $depts['ins_name'] = str_ireplace('_',' ',$request['ins']);
        if($type == 'college'){
            $depts['ins'] = $this->getDeptsByCollegeId($ins_id);
            return view('departments.deptsByIns',['depts'=>$depts]);            
        }elseif($type == 'school'){
            $depts['ins'] = $this->getDeptsBySchoolId($ins_id);
            return view('departments.deptsByIns',['depts'=>$depts]);
        }else{
            return view('excep',['error'=>'Invalid Route']);
        }
    }
    //function to return edit department view
    public function editDepartment(Request $request){
        $dep_id   = base64_decode($request['id']);
        $dep_data = DB::table('departments')
            ->where('id',$dep_id)
            ->first();
        return view('departments.editDepartment',['dep_data'=>$dep_data]);
    }

    //function to update departmet
    public function updateDepartment(Request $request){
        $dep_id        = base64_decode($request['id']);
        $dept_name     = strip_tags($request['dept-name']);
        $school_id     = strip_tags($request['school_id']);
        $email         = strip_tags($request['email']);
        $website       = strip_tags($request['website']);
        $hex           = bin2hex(openssl_random_pseudo_bytes(16));
        $imageFileType = strtolower(pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));
        if(strlen($request['image_url']) !== 0){
            //move_uploaded_file($_FILES['logo']['tmp_name'],"storage/dep_logos/".$hex.'.'.$imageFileType);
            try{
                $query = DB::table('departments')
                    ->where('id',$dep_id)
                    ->update([
                        'dept_name'    => $dept_name,
                        'dept_email'   => $email,
                        'dept_website' => $website,
                        'dept_logo'    => $request['image_url'],//$request->getSchemeAndHttpHost().Storage::url('dep_logos/'.$hex.'.'.$imageFileType),
                    ]);
                if($query){
                    return redirect('/manage/departments');
                }else{
                    return view('excep',['error'=>$e->getMessage()]);
                }
            }catch(\Exception $e){
                return view('excep',['error'=>$e->getMessage()]);
            }
        }else{
            try{
                $query = DB::table('departments')
                    ->where('id',$dep_id)
                    ->update([
                        'dept_name'    => $dept_name,
                        'dept_email'   => $email,
                        'dept_website' => $website,
                    ]);
                if($query){
                    return redirect('/manage/departments');
                }else{
                    return view('excep',['error'=>$e->getMessage()]);
                }
            }catch(\Exception $e){
                return view('excep',['error'=>$e->getMessage()]);
            }
        }
    }

    //function to delete department
    public function deleteDepartment(Request $request){
      try{
        $query = DB::table('departments')
          ->where('id',$request['id'])
          ->delete();
        return redirect('/manage/departments');
      }catch(\Exception $e){
        return response()->json($e->getMessage(),500);
      }
    }

    //function to view department
    public function viewDepartment(Request $request){
        $dept_id = base64_decode($request['id']);
        $dep = DB::table('departments')
            ->where('id',$dept_id)
            ->first();
        $classes = DB::table('class')
            ->where('class_dept_id',$dept_id)
            ->get();
        $staff = DB::table('teacher')
            ->where('teacher_dept',$dept_id)
            ->get();
        $students = DB::table('student')
            ->where('dept_id',$dept_id)
            ->get();
        $labs = DB::table('labs')
            ->where('dept_id',$dept_id)
            ->get();
        $responseData['dep']      = $dep;
        $responseData['classes']  = $classes;
        $responseData['staff']    = $staff;
        $responseData['students'] = $students;
        $responseData['labs']     = $labs;
        return view('departments.viewDepartment',['responseData'=>$responseData]);
    }
}
