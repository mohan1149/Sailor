<?php

namespace App\Http\Controllers\api\Content;

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
        $school_owner_id = strip_tags($_SESSION['user_id']);
        $school_name     = strip_tags($request['name']);
        $school_phone    = strip_tags($request['phone']);
        $school_email    = strip_tags($request['email']);
        $school_website  = strip_tags($request['website']);
        $school_address  = strip_tags($request['address']);
        $periods         = strip_tags($request['periods']);
        $period_length   = strip_tags($request['period-length']);
        $reg_num         = strip_tags($request['reg-num']);
        $hex = bin2hex(openssl_random_pseudo_bytes(16));
        $imageFileType = strtolower(pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));
        move_uploaded_file($_FILES['logo']['tmp_name'],storage_path()."/app/public/school_logos/".$hex.'.'.$imageFileType);
        try{
            $query = DB::table('school')
                ->insertGetId([
                    'school_name'     => $school_name,
                    'school_address'  => $school_address,
                    'school_owner_id' => $school_owner_id,
                    'phone'           => $school_phone,
                    'email'           => $school_email,
                    'website'         => $school_website,
                    'logo_path'       => $request->getSchemeAndHttpHost().Storage::url('school_logos/'.$hex.'.'.$imageFileType),
                    'periods'         => $periods,
                    'period_length'   => $period_length,
                    'reg_num'         => $reg_num,
                    'status'          => 1,
                ]
            );
        return redirect('/dashboard');
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //function to manage schools to the Sailor System
    public function manageSchools(){
        $school_owner_id = $_SESSION['user_id'];
        $schools = DB::table('school')
            ->where('school_owner_id',$school_owner_id)
            ->orderBy('id')
            ->where('status',1)
            ->get();
        return view('manageSchool',['schools'=>$schools]);
    }

    //function to return edit school view
    public function editSchool(Request $request){
        $school_owner_id = $_SESSION['user_id'];
        $school_id       = base64_decode($request['id']);
        $schools = DB::table('school')
            ->where('school_owner_id',$school_owner_id)
            ->where('id',$school_id)
            ->get();
        return view('editSchool',['schools'=>$schools]);
    }

    //function to return view for viewing school
    public function viewSchool(Request $request){
        $school_owner_id = $_SESSION['user_id'];
        $responseData    = [];
        $school_id       = base64_decode($request['id']);
        $school          = DB::table('school')
            ->where('school_owner_id',$school_owner_id)
            ->where('id',$school_id)
            ->first();
        $deps = DB::table('departments')
            ->where('school_id',$school_id)
            ->get();
        $classes = DB::table('class')
            ->where('school_id',$school_id)
            ->get();
        $staff = DB::table('teacher')
            ->where('school_id',$school_id)
            ->get();
        $responseData['school']  = $school;
        $responseData['deps']    = $deps;
        $responseData['classes'] = $classes;
        $responseData['staff']   = $staff;
        $responseData['deps']    = $deps;
        return view('viewSchool',['responseData'=>$responseData]);
    }

    //function to delete school from the Sailor System
    public function deleteSchool(Request $request){
        $school_owner_id = $_SESSION['user_id'];
        try{
            $schools = DB::table('school')
                ->where('school_owner_id',$school_owner_id)
                ->where('id',$request['id'])
                ->update([
                    'status' => 0,
                ]);
            return redirect('/manage/schools');
        }catch(\Exception $e){
            return response()->json($e->getMessage(),500);
        }

    }

    ////function to update school to the Sailor System
    public function updateSchool(Request $request){
        $school_owner_id = $_SESSION['user_id'];
        $school_name     = strip_tags($request['name']);
        $school_phone    = strip_tags($request['phone']);
        $school_email    = strip_tags($request['email']);
        $school_website  = strip_tags($request['website']);
        $school_address  = strip_tags($request['address']);
        $periods         = strip_tags($request['periods']);
        $period_length   = strip_tags($request['period-length']);
        $reg_num         = strip_tags($request['reg-num']);
        $hex = bin2hex(openssl_random_pseudo_bytes(16));
        $imageFileType = strtolower(pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));
        if($imageFileType !==''){
            move_uploaded_file($_FILES['logo']['tmp_name'],'school_logos/'.$hex.'.'.$imageFileType);
            try{
                $query = DB::table('school')
                    ->where('id', $request['id'])
                    ->update([
                        'school_name'     => $school_name,
                        'school_address'  => $school_address,
                        'school_owner_id' => $school_owner_id,
                        'phone'           => $school_phone,
                        'email'           => $school_email,
                        'website'         => $school_website,
                        'logo_path'       => $request->getSchemeAndHttpHost().'/school_logos/'.$hex.'.'.$imageFileType,
                        'periods'         => $periods,
                        'period_length'   => $period_length,
                        'reg_num'         => $reg_num,
                    ]
                );
                return redirect('/manage/schools');
            }catch(\Exception $e){
                return $e->getMessage();
            }
        }else{
            try{
                $query = DB::table('school')
                    ->where('id', $request['id'])
                    ->update([
                        'school_name'     => $school_name,
                        'school_address'  => $school_address,
                        'school_owner_id' => $school_owner_id,
                        'phone'           => $school_phone,
                        'email'           => $school_email,
                        'website'         => $school_website,
                        'periods'         => $periods,
                        'period_length'   => $period_length,
                        'reg_num'         => $reg_num,
                    ]
                );
            return redirect('/manage/schools');
            }catch(\Exception $e){
                return $e->getMessage();
            }
        }
    }
}
