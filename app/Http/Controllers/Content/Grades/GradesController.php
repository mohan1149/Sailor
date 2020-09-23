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
		$garde_num  = $request['year_numeric'];
        try{
          $query = DB::table('grades')
            ->insert([
              'grade_ins_id'   => $ins_id,
              'grade_year'     => strip_tags($year_value),
			  'grade_ins_type' => $ins_type,
			  'grade_numeric'  => $garde_num,
            ]);
            return redirect('/manage/years');
        }catch(\Exception $e){
          return view('excep',['error'=>$e->getMessage()]);
        }
	  }
	  
	public function manageYears(){
		try{
			$return_data = [];
			$schools = $this->commonController->getInstitutesByUser('school');
			foreach($schools as $school){
				$return_data [] = [
					'schoolId' => $school->id,
					'schoolName' => $school->school_name,
					'schoolGrades' => $this->commonController->getYearsByInsId($school->id),
				];
			}
			return view('grades.manageSchoolGrades',['return_data'=>$return_data]);
		}catch(\Eception $e){
			return view('excep',['error'=>$e->getMessage()]);
		}
	}

	public function listStudentsByGrade(Request $request){
		try{
			$students = [];
			$gid      = base64_decode($request['gid']);
			$students = DB::table('student')
				->where('grade_id',$gid)
				->orderBy('sid')
				->get();
			return view('grades.studentListByGrade',['students' =>$students]);			
		}catch(\Exceptopn $e){
			return view('excep',['error'=>$e->getMessage()]);
		}
	}

	public function deleteGrade(Request $request){
		try{
			$gid = $request['gid'];
			$delete = DB::table('grades')
				->where('id',$gid)
				->delete();
			return redirect('/manage/years');
		}catch(\Exception $e){
			return view('excep',['error'=>$e->getMessage()]);
		}
	}
	
	public function editGrade(Request $request){
		try{
			return view('grades.editGrade',['gid'=>$request['gid']]);
		}catch(\Exception $e){
			return view('excep',['error'=>$e->getMessage()]);
		}
	}

	public function updateYear(Request $request){
		try{
			$gid = base64_decode($request['gid']);
			$grade = strip_tags($request['year_value']);
			$garde_num = $request['year_numeric'];
			$update = DB::table('grades')
				->where('id',$gid)
				->update([
					'grade_year'    => $grade,
					'grade_numeric' => $garde_num,
				]);
			return redirect('/manage/years');
		}catch(\Exception $e){
			return view('excep',['error'=>$e->getMessage()]);	
		}
	}
}