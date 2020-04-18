<?php

namespace App\Http\Controllers\api\Content;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class DepartmentController extends Controller
{

    //function to get schools for departments
    public function getSchools(){
        $school_owner_id = $_SESSION['user_id'];
        $schools = DB::table('school')
            ->where('school_owner_id',$school_owner_id)
            ->where('status',1)
            ->get();
        return view('addDepartment',['schools'=>$schools]);
    }
    
    //function to store departments
    public function storeDepartment(Request $request){
        $dept_name     = strip_tags($request['dept-name']);
        $school_id     = strip_tags($request['school_id']);
        $email         = strip_tags($request['email']); 
        $website       = strip_tags($request['website']);
        $hex           = bin2hex(openssl_random_pseudo_bytes(16));
        $imageFileType = strtolower(pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));
        move_uploaded_file($_FILES['logo']['tmp_name'],storage_path()."/app/public/dep_logos/".$hex.'.'.$imageFileType);
        try{
            $query = DB::table('departments')
                ->insert([
                    'd_name'    => $dept_name,
                    'school_id' => $school_id,
                    'email'     => $email,
                    'website'   => $website,
                    'logo'      => $request->getSchemeAndHttpHost().Storage::url('dep_logos/'.$hex.'.'.$imageFileType),
                ]);
            if($query){
                return redirect('/manage/departments');
            }else{
                return response()->json($e->getMessage(),500);
            }
        }catch(\Exception $e){
            return response()->json($e->getMessage(),500);
        }
    }

    //function to manage departments
    public function manageDepartments(){
        try{
            $school_owner_id = $_SESSION['user_id'];
            $ids =  DB::table('school')
                ->join('departments','school.id','=','departments.school_id')
                ->distinct()
                ->where('school.school_owner_id',$school_owner_id)
                ->where('school.status',1)
                ->select(['departments.school_id'])
                ->get();
            foreach($ids as $id){
                $deps[] = DB::table('school')
                    ->join('departments','school.id','=','departments.school_id')
                    ->where('school_id',$id->school_id)
                    ->get();
            }
            return view('manageDepartments',['deps'=>$deps]);
        }catch(\Exception $e){
            return response()->json($e->getMessage(),500);
        }
    }
    public function editDepartment(Request $request){
        $dep_id   = base64_decode($request['id']);
        $dep_data = DB::table('departments')
            ->where('id',$dep_id)
            ->first();
        return view('editDepartment',['dep_data'=>$dep_data]);
    }


    public function updateDepartment(Request $request){
        $dep_id        = base64_decode($request['id']);
        $dept_name     = strip_tags($request['dept-name']);
        $school_id     = strip_tags($request['school_id']);
        $email         = strip_tags($request['email']); 
        $website       = strip_tags($request['website']);
        $hex           = bin2hex(openssl_random_pseudo_bytes(16));
        $imageFileType = strtolower(pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION));
        if($imageFileType !== ''){
            move_uploaded_file($_FILES['logo']['tmp_name'],storage_path()."/app/public/dep_logos/".$hex.'.'.$imageFileType);
            try{
                $query = DB::table('departments')
                    ->where('id',$dep_id)
                    ->update([
                        'd_name'    => $dept_name,
                        'email'     => $email,
                        'website'   => $website,
                        'logo'      => $request->getSchemeAndHttpHost().Storage::url('dep_logos/'.$hex.'.'.$imageFileType),
                    ]);
                if($query){
                    return redirect('/manage/departments');
                }else{
                    return response()->json($e->getMessage(),500);
                }
            }catch(\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }else{
            try{
                $query = DB::table('departments')
                    ->where('id',$dep_id)
                    ->update([
                        'd_name'    => $dept_name,
                        'email'     => $email,
                        'website'   => $website,
                    ]);
                if($query){
                    return redirect('/manage/departments');
                }else{
                    return response()->json($e->getMessage(),500);
                }
            }catch(\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }
}