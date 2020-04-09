<?php

namespace App\Http\Controllers\api\Content;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class DepartmentController extends Controller
{
    public function addDepartment(){
        $school_owner_id = $_SESSION['user_id'];
        $schools = DB::table('school')
            ->where('school_owner_id',$school_owner_id)
            ->get();
        return view('addDepartment',['schools'=>$schools]);
    }
    public function storeDepartment(Request $request){
        $dept_name = strip_tags($request['dept-name']);
        $school_id = strip_tags($request['school_id']);
        try{
            $query = DB::table('departments')
                ->insert([
                    'd_name'    => $dept_name,
                    'school_id' => $school_id,
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
    public function manageDepartments(){
        try{
            $departments = DB::table('departments')
                ->get();
            return $departments;
        }catch(\Exception $e){
            return response()->json($e->getMessage(),500);
        }
    }
}