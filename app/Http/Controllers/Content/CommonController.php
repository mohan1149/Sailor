<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class CommonController extends Controller
{
    //get colleges or schools by user
    public function getInstitutesByUser($ins_type){
        switch($ins_type){
            case 'college':
                return $this->getCollegesByUser();
            case 'school':
                return $this->getSchoolsByUser();
            default:
                return [];
        }
    }

    public function getCollegesByUser(){
        try{
            $colleges = [];
            $colleges = DB::table('college')
                ->where('clg_owner',$_SESSION['user_id'])
                ->get();
            return $colleges;
        }catch(\Exception $e){
            return [];
        }
    }

    public function getSchoolsByUser(){
        try{
            $schools = [];
            $schools = DB::table('school')
                ->where('school_owner',$_SESSION['user_id'])
                ->get();
            return $schools;
        }catch(\Exception $e){
            return [];
        }
    }

    public function getDeptsByInsId($ins_id){
        try{
            $depts = DB::table('departments')
                ->where('dept_ins_id',$ins_id)
                ->where('dept_ins_type',$_SESSION['ins'])
                ->get();
            return $depts;
        }catch(\Exception $e){
            return [];
        }
    }

    public function getYearsByInsId($ins_id){
        try{
            $years = DB::table('grades')
                ->where('grade_ins_id',$ins_id)
                ->where('grade_ins_type',$_SESSION['ins'])
                ->orderBy('grade_year')
                ->get();
            return $years;
        }catch(\Exception $e){
            return [];
        }
    }

    public function getClassesByYear($year_id){
        try{
            $classes = DB::table('class')
                ->where('class_year',$year_id)
                ->where('class_ins_type',$_SESSION['ins'])
                ->get();
            return $classes;
        }catch(\Exception $e){
            return [];
        }
    }

    public function getStaffByInsId($school_id){
        try{
            $staff = [];
            $staff = DB::table('teacher')
                ->where('teacher_ins_id',$school_id)
                ->orderBy('teacher_name')
                ->get();
            return $staff;
        }catch(\Exception $e){
            return [];
        }
    }

    public function getLabsByDeptId($dept_id){
        try{
            $labs = [];
            $labs = DB::table('labs')
                ->where('dept_id',$dept_id)
                ->get();
            return $labs;
        }catch(\Exception $e){
            return [];
        }
    }




    public function dbtest(){
        $pdo = DB::connection()->getPdo();
        $item = 'CREATE TABLE IF NOT EXISTS item 
            (
                id SERIAL PRIMARY KEY,
                item_name CHARACTER VARYING(100),
                item_description CHARACTER VARYING(255)
            );'
        ; 
        $pdo->exec($item);           
    }
}