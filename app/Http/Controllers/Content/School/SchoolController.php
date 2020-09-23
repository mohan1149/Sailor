<?php

namespace App\Http\Controllers\Content\School;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class SchoolController extends Controller
{
    //function to add school to the Sailor System
    public function addSchool(Request $request)
    {
        $owner_id             = strip_tags($_SESSION['user_id']);
        $school_name          = strip_tags($request['name']);
        $school_phone         = strip_tags($request['phone']);
        $school_email         = strip_tags($request['email']);
        $school_website       = strip_tags($request['website']);
        $school_address       = strip_tags($request['address']);
        $school_periods       = strip_tags($request['periods']);
        $school_period_length = strip_tags($request['period-length']);
        $school_reg_num       = strip_tags($request['reg-num']);        
        //$hex                  = bin2hex(openssl_random_pseudo_bytes(16));
        //$imageFileType        = strtolower(pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));
        //move_uploaded_file($_FILES['logo']['tmp_name'],"storage/school_logos/".$hex.'.'.$imageFileType);
        try{
            $query = DB::table('school')
                ->insertGetId([
                    'school_name'          => $school_name,
                    'school_address'       => $school_address,
                    'school_owner'         => $owner_id,
                    'school_phone'         => $school_phone,
                    'school_email'         => $school_email,
                    'school_website'       => $school_website,
                    'school_logo'          => $request['image_url'],//$request->getSchemeAndHttpHost().Storage::url('school_logos/'.$hex.'.'.$imageFileType),
                    'school_periods'       => $school_periods,
                    'school_period_length' => $school_period_length,
                    'school_reg_num'       => $school_reg_num,                                
                ]
            );
            $upStud = DB::table('student_attendence')
                ->insertGetId([ 
                    'sid'        => $query, 
                    'percentage' => 0, 
                    'month'      => date('m'),                      
                ]
            );    
            return redirect('/manage/schools');        
        }catch(\Exception $e){            
            return view('excep',['error'=>$e->getMessage()]);
        }
    }

    //function to manage schools to the Sailor System
    public function manageSchools(){
        $owner_id = $_SESSION['user_id'];
        $schools = DB::table('school')
            ->where('school_owner',$owner_id)
            ->orderBy('id')            
            ->get();
        return view('school.manageSchools',['schools'=>$schools]);
    }

    //function to return edit school view
    public function editSchool(Request $request){
        try{
            $owner_id  = $_SESSION['user_id'];
            $school_id = base64_decode($request['id']);
            $school = DB::table('school')
                ->where('school_owner',$owner_id)
                ->where('id',$school_id)
                ->first();
            return view('school.editSchool',['school'=>$school]);
        }catch(\Exception $e){
            return view('excep',['error'=>$e->getMessage()]);
        }
    }

    //function to return view for viewing school
    public function viewSchool(Request $request){
        $owner_id        = $_SESSION['user_id'];
        $responseData    = [];
        $school_id       = base64_decode($request['id']);
        $school          = DB::table('school')
            ->where('school_owner',$owner_id)
            ->where('id',$school_id)
            ->first();
        $deps = DB::table('departments')
            ->where('dept_ins_id',$school_id)
            ->where('dept_ins_type','school')
            ->get();
        $classes = DB::table('class')
            ->where('class_ins_id',$school_id)
            ->where('class_ins_type','school')
            ->get();
        $staff = DB::table('teacher')
            ->where('teacher_ins_id',$school_id)
            ->where('teacher_ins_type','school')
            ->get();
        $students = DB::table('student')
            ->where('school_id',$school_id)
            ->get();
        $labs = DB::table('labs')
            ->where('school_id',$school_id)
            ->get();
        $emps = DB::table('emplyoee')
            ->where('emp_institute',$school_id)
            ->get();
        $responseData['school']   = $school;
        $responseData['deps']     = $deps;
        $responseData['classes']  = $classes;
        $responseData['staff']    = $staff;
        $responseData['students'] = $students;
        $responseData['labs']     = $labs;
        $responseData['emps']     = $emps;
        $responseData['schoolId'] = $school_id;
        return view('school.viewSchool',['responseData'=>$responseData]);
    }

    //function to delete college from the Sailor System
    public function deleteSchool(Request $request){
        $owner_id = $_SESSION['user_id'];
        try{
            $schools = DB::table('school')
                ->where('school_owner',$owner_id)
                ->where('id',$request['id'])
                ->delete();
            return redirect('/manage/schools');
        }catch(\Exception $e){
            return view('excep',['error'=>$e->getMessage()]);
        }

    }

    //function to update college to the Sailor System
    public function updateSchool(Request $request){
        $school_owner         = $_SESSION['user_id'];
        $school_name          = strip_tags($request['name']);
        $school_phone         = strip_tags($request['phone']);
        $school_email         = strip_tags($request['email']);
        $school_website       = strip_tags($request['website']);
        $school_address       = strip_tags($request['address']);
        $school_periods       = strip_tags($request['periods']);
        $school_period_length = strip_tags($request['period-length']);
        $school_reg_num       = strip_tags($request['reg-num']);
        
        //$imageFileType        = strtolower(pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION)); 
        if( strlen($request['image_url']) != 0){            
            //$hex = bin2hex(openssl_random_pseudo_bytes(16));
            //move_uploaded_file($_FILES['logo']['tmp_name'],"storage/school_logos/".$hex.'.'.$imageFileType);
            try{
                $query = DB::table('school')
                    ->where('id', $request['id'])
                    ->update([
                        'school_name'          => $school_name,
                        'school_address'       => $school_address,                        
                        'school_phone'         => $school_phone,
                        'school_email'         => $school_email,
                        'school_website'       => $school_website,
                        'school_logo'          => $request['image_url'],//$request->getSchemeAndHttpHost().Storage::url('school_logos/'.$hex.'.'.$imageFileType),
                        'school_periods'       => $school_periods,
                        'school_period_length' => $school_period_length,
                        'school_reg_num'       => $school_reg_num,
                    ]
                );
                return redirect('/manage/schools');
            }catch(\Exception $e){
                return view('excep',['error'=>$e->getMessage()]);
            }
        }else{            
            try{
                $query = DB::table('school')
                    ->where('id', $request['id'])
                    ->update([
                        'school_name'          => $school_name,
                        'school_address'       => $school_address,                        
                        'school_phone'         => $school_phone,
                        'school_email'         => $school_email,
                        'school_website'       => $school_website,                        
                        'school_periods'       => $school_periods,
                        'school_period_length' => $school_period_length,
                        'school_reg_num'       => $school_reg_num,
                    ]
                );
            return redirect('/manage/schools');
            }catch(\Exception $e){
                return view('excep',['error'=>$e->getMessage()]);
            }
        }
    }

    // function to return colleges to add year of study
    public function addYearOfStudy(){
        $schools = $this->getSchoolsByUser();
        return view('addYearOfStudy',['schools'=>$schools]);
    }

    public function addYear(Request $request){
      $year_value = $request['year-value'];
      $school_id  = $request['school_id'];
      try{
        $query = DB::table('grades')
          ->insert([
            'school_id' => $school_id,
            'year'     => strip_tags($year_value),
          ]);
        return redirect('/manage/colleges');
      }catch(\Exception $e){
        return reponse()->json($e->getMessage(),500);
      }
    }

    public function getDepartsAndGradesByCollegeId(Request $request){
        try{
            $deps = DB::table('departments')
                ->where('school_id',$request['id'])
                ->get();
            $classes = DB::table('grades')
                ->where('school_id',$request['id'])
                ->get();
            $responseData = [];
            $responseData['deps'] = $deps;
            $responseData['classes'] = $classes;
            return response()->json($responseData,200);

        }catch(\Exception $e){
            return response()->json($e->getMessage(),500);
        }
    }

    public function getClasses(Request $request){
      try{
        $classes = DB::table('class')
          ->where('dept_id', $request['id'])
          ->get();
        return $classes;
      }catch(\Exception $e){
        return response()->json($e->getMessage(),500);
      }
    }
}
