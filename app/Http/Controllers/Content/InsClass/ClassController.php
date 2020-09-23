<?php

namespace App\Http\Controllers\Content\InsClass;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Content\CommonController;
class ClassController extends Controller
{    
    private $commonController;    
    public function __construct(){
        $this->commonController = new CommonController();
    }
    public function addClass(){
		$return_data = [];
		$ins_type    = $_SESSION['ins'];
        $ins = $this->commonController->getInstitutesByUser($ins_type);
        foreach($ins as $institute){
			$return_data[] = [
				'ins_id'    => $institute->id,
				'ins_name'  => $ins_type == 'college' ? $institute->clg_name : $institute->school_name,
                'ins_depts' => $this->commonController->getDeptsByInsId($institute->id),
                'ins_years' => $this->commonController->getYearsByInsId($institute->id),
                'ins_staff' => $this->commonController->getStaffByInsId($institute->id),
			];
		}
		if($ins_type == 'college'){
            return view('class.addCollegeClass',['return_data'=> $return_data]);			
		}else{            
            return view('class.addSchoolClass',['return_data'=> $return_data]);
		}   
    }
    public function storeClass(Request $request){        
        $class_name         = strip_tags($request['className']);
        $class_ins_id       = strip_tags($request['ins_id']);
        $class_num_subjects = strip_tags($request['subjects']);
        $class_dept_id      = strip_tags($request['department']);
        $class_year         = $request['year'];
        $class_ins_type     = $request['type'];
        $classTeacher       = $request['cl_teacher'];
        $query = '';
        try{
            $query = DB::table('class')
                ->insertGetId([
                    'class_name'         => $class_name,                    
                    'class_ins_id'       => $class_ins_id,
                    'class_num_subjects' => $class_num_subjects,
                    'class_dept_id'      => $class_dept_id,
                    'class_ins_type'     => $class_ins_type,
                    'class_year'         => $class_year,
                    'class_teacher'      => $classTeacher,

                ]);          
            for($i = 1; $i <= $class_num_subjects; $i++) {
                $subjects[] = $request['subject'.$i];
                $subjects_json[$i] = [
                    'subject_name'       => $request['subject'.$i],
                    'subject_completion' => 0,
                    'subject_chapters'   => '',
                ];
            }            
            $res  = DB::table('subjects')
                ->insert([
                    'class_id'      => $query,
                    'subjects_list' => json_encode($subjects_json)
                ]);            
            $staff = DB::table('teacher')
                ->where('teacher_ins_id',$class_ins_id)
                ->where('teacher_ins_type',$_SESSION['ins'])
                ->get();
            if($_SESSION['ins'] == 'college'){
                $periods = DB::table('college')->where('id',$class_ins_id)->first();
            }else{
                $periods = DB::table('school')->where('id',$class_ins_id)->first();
            }            
            $viewData['subjects']  = $subjects;
            $viewData['staff']     = $staff;
            $viewData['periods']   = $class_ins_type == 'college' ? $periods->clg_periods :$periods->school_periods;
            $viewData['className'] = $class_name;
            $viewData['class_id']  = $query;            
            return view('timetable.addTimeTable',['viewData'=>$viewData]);
        }catch(\Exception $e){                      
            return view('excep',['error'=>$e->getMessage()]);
        }
    }

    public function manageClass(){
      try{
            $owner_id = $_SESSION['user_id'];
            $response_data   = [];
            if($_SESSION['ins'] == 'school'){
                $schools = DB::table('school')
                    ->where('school_owner',$owner_id)            
                    ->get();
                foreach ($schools as $school) {
                    $response_data[] = [
                        'id'        => $school->id,
                        'school_name' => $school->school_name,
                        'dept_data' => $this->getYearsBySchoolId($school->id),
                    ];
                }
                return view('class.manageSchoolClasses',['response_data'=>$response_data]);
            }else{
                //code for mange collge
            }
          
        }catch(\Exception $e){            
            return view('excep',['error'=>$e->getMessage()]);
        }
    }

    public function getDeptsBySchoolId($school_id){
      $return_data = [];
      $deps = DB::table('departments')->where('dept_ins_id',$school_id)->get();
        foreach ($deps as $dep) {
          $return_data[] = [
            'id'         => $dep->id,
            'dept_name'  => $dep->dept_name,
            'class_data' => $this->getClassesByDeptId($dep->id),
          ];
        }
      return $return_data;
    }

    public function getYearsBySchoolId($school_id){
        $return_data = [];
        $grades = DB::table('grades')
            ->where('grade_ins_id',$school_id)
            ->where('grade_ins_type','school')
            ->orderBy('grade_year')
            ->get();
          foreach ($grades as $grade) {
            $return_data[] = [
              'id'         => $grade->id,
              'grade_name' => $grade->grade_year,
              'class_data' => $this->getClassesByYearId($grade->id),
            ];
          }
        return $return_data;
    }

    public function getClassesByYearId($year_id){
        $return_data = [];
        $return_data['classes'] = DB::table('class')
          ->where('class_year',$year_id)
          ->where('class_ins_type','school')          
          ->get();
        $counts=[];
        foreach($return_data['classes'] as $class){
            $counts[] = DB::table('student')
                ->where('class_id',$class->id)
                ->count();
        }
        $return_data['counts'] = $counts;
        return $return_data;
    }

    public function getClassesByDeptId($dept_id){
      $return_data = [];
      $return_data['classes'] = DB::table('class')
        ->where('id',$dept_id)
        ->get();
    $counts=[];
    foreach($return_data['classes'] as $class){
        $counts[] = DB::table('student')
            ->where('class_id',$class->id)
            ->count();
    }
    $return_data['counts'] = $counts;
    return $return_data;
    }

    public function storeTimetable(Request $request){        
        $periods  = $request['periods'];
        $class_id = $request['cid'];
        $weeks = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
        $str = [];
        foreach($weeks as $week){
            for($i = 1;$i <= $periods;$i++){
                $data[$i] = [
                    'staff_id' => substr($request[$week.'_'.$i.'_staff'],0,stripos($request[$week.'_'.$i.'_staff'],'_')),
                    'staff'    => substr($request[$week.'_'.$i.'_staff'],strripos($request[$week.'_'.$i.'_staff'],'_') + 1),
                    'subject'  =>  [
                        'key' => $i,
                        'subject' => $request[$week.'_'.$i.'_subject'],
                    ],                    
                ];                

            }
            $res[$week] = json_encode($data);
        }
        try{
            $query = DB::table('timetable')->insert([
                'class_id'  => $class_id,
                'sunday'    => $res['sunday'],
                'monday'    => $res['monday'],
                'tuesday'   => $res['tuesday'],
                'wednesday' => $res['wednesday'],
                'thursday'  => $res['thursday'],
                'friday'    => $res['friday'],
                'saturday'  => $res['saturday'],
            ]);
            return redirect('/manage/classes');
        }catch(\Exception $e){            
            return view('excep',['error' =>$e->getMessage()]);
        }
    }
    public function deleteClass(Request $request){
        try{
            $query = DB::table('class')
                ->where('id',$request['id'])
                ->delete();
            return redirect('/manage/classes');
        }catch(\Exception $e){
            return view('excep',['error' =>$e->getMessage()]);
        }
    }

    public function editClass(Request $request){
        try{
            $response_data = [];
            $subjects      = [];
            $class_id      = base64_decode($request['id']);
            $class_data    = DB::table('class')
                ->join('subjects','subjects.class_id','=','class.id')
                ->where('class.id',$class_id)
                ->first();            
            if(isset($class_data->subjects_list)){
                $subjects = $class_data->subjects_list;
                $response_data['subjects'] = json_decode($subjects);       
            }            
            $response_data['class'] = $class_data;                   
            return view('class.editClass',['class'=>$response_data]);
        }catch(\Exception $e){               
            return view('excep',['error' =>$e->getMessage()]);
        }
    }

    public function updateClass(Request $request){
        $class_id  = $request['id'];
        $className = strip_tags($request['className']);        
        $subjects  = json_decode($request['subjects']);
        $count     = count($subjects);        
        $subjects_json = [];                
        try{
            $updateClass = DB::table('class')
                ->where('id',$class_id)
                ->update([
                    'class_name'         => $className,
                    'class_num_subjects' => $count,
                ]);
            for($i = 0; $i< $count; $i++ ){                
                $subjects_json[$i+1] = [
                    'subject_name'       => $subjects[$i]->subject_name,
                    'subject_completion' => $subjects[$i]->subject_completion,
                    'subject_chapters'   => '',
                ];
            }
            $upSubjects = DB::table('subjects')
                ->where('class_id',$class_id)
                ->update([
                    'subjects_list' => json_encode($subjects_json),
                ]);
            return redirect('/manage/classes');
        }catch(\Exception $e){
            return view('excep',['error'=>$e->getMessage()]);
        }
        return $request['subjects'];
    }

    public function viewTimetable(Request $request){
        $class_id  = base64_decode($request['id']);
        $timetable = DB::table('timetable')
            ->where('class_id',$class_id)
            ->first();
        return view('viewTimetable',['timetable'=>$timetable]);
    }

    public function viewClass(Request $request){
        try{
            $class_id      = base64_decode($request['id']);
            $response_data = []; 
            $class_data = DB::table('class')
                ->where('id',$class_id)
                ->first();
            $students = DB::table('student')
                ->where('class_id',$class_id)
                ->where('ins_type',$_SESSION['ins'])
                ->get();
            $subjects = DB::table('subjects')
                ->where('class_id',$class_id)
                ->first();
            $response_data['class_data'] = $class_data;
            $response_data['students']   = $students;
            $response_data['subjects']   = $subjects;
            return view('class.viewSchoolClass',['responseData'=>$response_data]);
        }catch(\Exception $e){            
            return view('excep',['error'=>$e->getMessage()]);
        }
    }

    public function updateSyllabus(Request $request){
        try{
            $class_id    = $request['class_id'];
            $sub_index   = $request['subject_index'];
            $sub_percent = $request['sub_percent'];
            $update = DB::table('subjects')
                ->where('class_id',$class_id)
                ->update([
                    "subjects_list->".$sub_index."->subject_completion" => $sub_percent,
                ]);
            return redirect('/manage/classes');
        }catch(\Exception $e){
            return view('excep',['error'=>$e->getMessage()]);
        }
    }

    public function addChaptersToSubject(Request $request){
        try{
            $class_id  = $request['class_id'];
            $sub_index = $request['subject_index'];
            $count     = $request['chapters_count'];
            for($i = 1;$i <= $count;$i++){
                $chapters[$i] = [                    
                    'chapter_name'      => $request['chapter'.$i],
                    'chapter_compltion' => 0,
                ];
            }
            $update = DB::table('subjects')
                ->where('class_id',$class_id)
                ->update([
                    "subjects_list->".$sub_index."->subject_chapters" => $chapters,
                ]);
            return redirect('/manage/classes');
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function classesByIns(Request $request){
        try{
            $ins_id = base64_decode($request['id']);
            $classes['ins_name'] = str_ireplace('_',' ',$request['ins']);
            $classes['classes']  = [];
            $classes['classes']  = DB::table("class")
                ->join("grades","grades.id","=","class_year")
                ->where("class.class_ins_id",$ins_id)
                ->orderBy("grades.grade_numeric")
                ->select(["class.class_name","class.class_num_subjects","grades.grade_year","class.id"])
                ->get();
                return view('class.classesByIns',['classes'=>$classes]);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
