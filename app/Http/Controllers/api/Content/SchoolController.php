<?php

namespace App\Http\Controllers\api\Content;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SchoolController extends Controller
{
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
        move_uploaded_file($_FILES['logo']['tmp_name'],'school_logos/'.$hex.'.'.$imageFileType);
        try{
            $query = DB::table('school')
                ->insertGetId([
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
        return redirect('/dashboard');
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
    public function manageSchools(){
        $school_owner_id = $_SESSION['user_id'];
        $schools = DB::table('school')
            ->where('school_owner_id',$school_owner_id)
            ->limit(8)
            ->orderBy('id')
            ->get();
        return view('manageSchool',['schools'=>$schools]);
    }
    public function editSchool(Request $request){
        $school_owner_id = $_SESSION['user_id'];
        $schools = DB::table('school')
            ->where('school_owner_id',$school_owner_id)
            ->where('id',$request['id'])
            ->get();
        return view('editSchool',['schools'=>$schools]);
    }
    public function viewSchool(Request $request){
        $school_owner_id = $_SESSION['user_id'];
        $responseData = [];
        $school = DB::table('school')
            ->where('school_owner_id',$school_owner_id)
            ->where('id',$request['id'])
            ->first();
        $deps = DB::table('departments')
            ->where('school_id',$request['id'])
            ->get();
        $classes = DB::table('class')
            ->where('school_id',$request['id'])
            ->get();
        $staff = DB::table('teacher')
            ->where('school_id',$request['id'])
            ->get();
        $responseData['school'] = $school;
        $responseData['deps'] = $deps;
        $responseData['classes'] = $classes;
        $responseData['staff'] = $staff;
        $responseData['deps'] = $deps;
        return view('viewSchool',['responseData'=>$responseData]);
    }
    public function deleteSchool(Request $request){
        $school_owner_id = $_SESSION['user_id'];
        $schools = DB::table('school')
            ->where('school_owner_id',$school_owner_id)
            ->where('id',$request['id'])
            ->get();
        return view('editSchool',['schools'=>$schools]);
    }
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
    }
}
