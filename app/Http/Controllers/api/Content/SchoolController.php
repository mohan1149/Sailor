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
        $school_owner_id = $_SESSION['user_id'];
        $school_name     = $request['name'];
        $school_phone    = $request['phone'];
        $school_email    = $request['email'];
        $school_website  = $request['website'];
        $school_address  = $request['address'];
        $periods         = $request['periods'];
        $period_length   = $request['period-length'];
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
                ]
            );
        return redirect('/dashboard');
        }catch(\Exception $e){
            return $e;
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
        return view('viewSchool');
        $school_owner_id = $_SESSION['user_id'];
        $schools = DB::table('school')
            ->where('school_owner_id',$school_owner_id)
            ->where('id',$request['id'])
            ->get();
        return view('editSchool',['schools'=>$schools]);
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
        $school_name     = $request['name'];
        $school_phone    = $request['phone'];
        $school_email    = $request['email'];
        $school_website  = $request['website'];
        $school_address  = $request['address'];
        $periods         = $request['periods'];
        $period_length   = $request['period-length'];
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
                ]
            );
        return redirect('/api/manage/schools');
        }catch(\Exception $e){
            return $e;
        }
    }
}
