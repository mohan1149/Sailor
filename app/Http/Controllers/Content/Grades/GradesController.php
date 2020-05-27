<?php

namespace App\Http\Controllers\Content\Grades;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Content\CommonController;
class GradesController extends Controller
{
    private $commonController;    
    public function __construct(){
        $this->commonController = new CommonController();
    }


    // function to return colleges to add year of study
    public function addYearOfStudy(){
        try{
            if($_SESSION['ins'] == 'college'){
                $colleges = $this->commonController->getInstitutesByUser('college');                
                return view('grades.addCollegeYear',['colleges'=>$colleges]);
            }else{
                $schools = $this->commonController->getInstitutesByUser('school');                
                return view('grades.addSchoolGrade',['schools'=>$schools]);
            }
        }
        catch(\Exception $e){            
            return view('excep',['error'=>$e->getMessage()]);
        }        
    }

    public function addYear(Request $request){
        $year_value = $request['year_value'];
        $ins_id     = $request['ins_id'];
        $ins_type   = $request['type'];
        try{
          $query = DB::table('grades')
            ->insert([
              'grade_ins_id'   => $ins_id,
              'grade_year'     => strip_tags($year_value),
              'grade_ins_type' => $ins_type
            ]);
          return response()->json('sucess',200);
        }catch(\Exception $e){
          return view('excep',['error'=>$e->getMessage()]);
        }
      }
}