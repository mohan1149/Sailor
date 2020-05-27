<?php

namespace App\Http\Controllers\Content\College;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Content\CommonController;
class CollegeController extends Controller
{
    private $commonController;    
    public function __construct(){
        $this->commonController = new CommonController();
    }
    //function to add college
    public function addCollege(Request $request)
    {
        $clg_owner      = strip_tags($_SESSION['user_id']);
        $clg_name       = strip_tags($request['name']);
        $clg_phone      = strip_tags($request['phone']);
        $clg_email      = strip_tags($request['email']);
        $clg_website    = strip_tags($request['website']);
        $clg_address    = strip_tags($request['address']);
        $clg_periods    = strip_tags($request['periods']);
        $clg_period_len = strip_tags($request['period-length']);
        $clg_reg_num    = strip_tags($request['reg-num']);        
        $hex            = bin2hex(openssl_random_pseudo_bytes(16));
        $imageFileType  = strtolower(pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));
        move_uploaded_file($_FILES['logo']['tmp_name'],"storage/college_logos/".$hex.'.'.$imageFileType);
        try{
            $query = DB::table('college')
                ->insertGetId([
                    'clg_name'       => $clg_name,
                    'clg_address'    => $clg_address,
                    'clg_owner'      => $clg_owner,
                    'clg_phone'      => $clg_phone,
                    'clg_email'      => $clg_email,
                    'clg_website'    => $clg_website,
                    'clg_logo'       => $request->getSchemeAndHttpHost().Storage::url('college_logos/'.$hex.'.'.$imageFileType),
                    'clg_periods'    => $clg_periods,
                    'clg_period_len' => $clg_period_len,
                    'clg_reg_num'    => $clg_reg_num,                                   
                ]
            );        
            return redirect('/manage/colleges');        
        }catch(\Exception $e){            
            return view('excep',['error' => $e->getMessage()]);
        }
    }

    //function to manage colleges to the Sailor System
    public function manageColleges(){
        try{
            $clg_owner_id = $_SESSION['user_id'];
            $colleges = DB::table('college')
                ->where('clg_owner',$clg_owner_id)
                ->orderBy('id')            
                ->get();
            return view('college.manageColleges',['colleges'=>$colleges]);
        }catch(\Exception $e){
            return view('excep',['error' => $e->getMessage()]);
        }
    }

    //function to return edit college view
    public function editCollege(Request $request){
        try{
            $clg_owner_id = $_SESSION['user_id'];
            $clg_id       = base64_decode($request['id']);

            //db query
            $collge = DB::table('college')
                ->where('clg_owner',$clg_owner_id)
                ->where('id',$clg_id)
                ->first();
            return view('college.editCollege',['college'=>$collge]);
        }catch(\Exception $e){
            return view('excep',['error' => $e->getMessage()]);
        }
    }

    //function to return view for viewing college
    public function viewCollege(Request $request){
        try{
            $clg_owner_id = $_SESSION['user_id'];
            $responseData = [];
            $clg_id       = base64_decode($request['id']);
    
            //db quries
            $college = DB::table('college')
                ->where('clg_owner',$clg_owner_id)
                ->where('id',$clg_id)
                ->first();        
            $deps = DB::table('departments')
                ->where('dept_ins_id',$clg_id)
                ->get();
            $classes = DB::table('class')
                ->where('school_id',$clg_id)
                ->get();
            $staff = DB::table('teacher')
                ->where('teacher_ins_id',$clg_id)
                ->get();
            $students = DB::table('student')
                ->where('school_id',$clg_id)
                ->get();
            $labs = DB::table('labs')
                ->where('school_id',$clg_id)
                ->get();
            $emps = DB::table('emplyoee')
                ->where('emp_institute',$clg_id)
                ->get();
            $responseData['college']  = $college;
            $responseData['deps']     = $deps;
            $responseData['classes']  = $classes;
            $responseData['staff']    = $staff;
            $responseData['students'] = $students;
            $responseData['labs']     = $labs;
            $responseData['emps']     = $emps;
            return view('college.viewCollege',['responseData'=>$responseData]);
        }catch(\Exception $e){            
            return view('excep',['error' => $e->getMessage()]);
        }
    }

    //function to delete college from the Sailor System
    public function deleteCollege(Request $request){
        $clg_owner_id = $_SESSION['user_id'];
        try{
            $query = DB::table('college')
                ->where('clg_owner',$clg_owner_id)
                ->where('id',$request['id'])
                ->delete();
            return redirect('/manage/colleges');
        }catch(\Exception $e){
            return view('excep',['error' => $e->getMessage()]);
        }
    }

    //function to update college to the Sailor System
    public function updateCollege(Request $request){
        $clg_owner_id   = $_SESSION['user_id'];
        $clg_name       = strip_tags($request['name']);
        $clg_phone      = strip_tags($request['phone']);
        $clg_email      = strip_tags($request['email']);
        $clg_website    = strip_tags($request['website']);
        $clg_address    = strip_tags($request['address']);
        $clg_periods    = strip_tags($request['periods']);
        $clg_period_len = strip_tags($request['period-length']);
        $clg_reg_num    = strip_tags($request['reg-num']);
        $hex = bin2hex(openssl_random_pseudo_bytes(16));
        $imageFileType = strtolower(pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));
        if($imageFileType !== ''){
            move_uploaded_file($_FILES['logo']['tmp_name'],"storage/college_logos/".$hex.'.'.$imageFileType);
            try{
                $query = DB::table('college')
                    ->where('id', $request['id'])
                    ->update([
                        'clg_name'       => $clg_name,
                        'clg_address'    => $clg_address,
                        'clg_owner'      => $clg_owner_id,
                        'clg_phone'      => $clg_phone,
                        'clg_email'      => $clg_email,
                        'clg_website'    => $clg_website,
                        'clg_logo'       => $request->getSchemeAndHttpHost().Storage::url('college_logos/'.$hex.'.'.$imageFileType),
                        'clg_periods'    => $clg_periods,
                        'clg_period_len' => $clg_period_len,
                        'clg_reg_num'    => $clg_reg_num,
                    ]
                );
                return redirect('/manage/colleges');
            }catch(\Exception $e){
                return view('excep',['error' => $e->getMessage()]);
            }
        }else{
            try{
                $query = DB::table('college')
                    ->where('id', $request['id'])
                    ->update([                        
                        'clg_name'       => $clg_name,
                        'clg_address'    => $clg_address,
                        'clg_owner'      => $clg_owner_id,
                        'clg_phone'      => $clg_phone,
                        'clg_email'      => $clg_email,
                        'clg_website'    => $clg_website,                        
                        'clg_periods'    => $clg_periods,
                        'clg_period_len' => $clg_period_len,
                        'clg_reg_num'    => $clg_reg_num,
                    ]
                );
            return redirect('/manage/colleges');
            }catch(\Exception $e){
                return view('excep',['error' => $e->getMessage()]);
            }
        }
    }


    // public function getDepartsAndGradesByCollegeId(Request $request){
    //     try{
    //         $deps = DB::table('departments')
    //             ->where('school_id',$request['id'])
    //             ->get();
    //         $classes = DB::table('grades')
    //             ->where('school_id',$request['id'])
    //             ->get();
    //         $responseData = [];
    //         $responseData['deps'] = $deps;
    //         $responseData['classes'] = $classes;
    //         return response()->json($responseData,200);

    //     }catch(\Exception $e){
    //         return response()->json($e->getMessage(),500);
    //     }
    // }

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
