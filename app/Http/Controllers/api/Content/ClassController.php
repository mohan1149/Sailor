<?php

namespace App\Http\Controllers\api\Content;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ClassController extends Controller
{    
    private $schoolController;
    public function __construct(){
        $this->schoolController = new SchoolController();
    }
    public function getSchools(){
        $schools = $this->schoolController->getSchoolsByUser();
        return view('addClass',['schools'=>$schools]);
    }

    public function storeClass(Request $request){
        $className   = strip_tags($request['className']);
        $schoolId    = strip_tags($request['school_id']);
        $numSubjects = strip_tags($request['subjects']);
        $dept_id     = strip_tags($request['department']);
        $query = '';
        try{
            $query = DB::table('class')
                ->insertGetId([
                    'value'         => $className,
                    'class_teacher' => -1,
                    'school_id'     => $schoolId,
                    'num_subjects'  => $numSubjects,
                    'dept_id'       => $dept_id,
                ]);
            $subjects = [];
            for($i=1; $i <= $numSubjects; $i++) {
                $subjects[] = $request['subject'.$i];
            }        
            $subs = json_encode($subjects);
            $res = DB::table('subjects')
                ->insert([
                    'class_id'      => $query,
                    'subjects_list' => $subs
                ]);
            $staff = DB::table('teacher')
                ->where('school_id',$schoolId)
                ->get();
            $periods = DB::table('school')->where('id',$schoolId)->first();
            $viewData['subjects']  = $subjects;
            $viewData['staff']     = $staff;
            $viewData['periods']   = $periods;
            $viewData['className'] = $className;
            $viewData['class_id']  = $query;            
            return view('addTimeTable',['viewData'=>$viewData]);
        }catch(\Exception $e){
            return view('excep');
        }
    }

    public function manageClass(){
      try{
          $school_owner_id = $_SESSION['user_id'];
          $response_data   = [];
          $schools = DB::table('school')
            ->where('school_owner_id',$school_owner_id)
            ->where('status',1)
            ->get();
          foreach ($schools as $school) {
            $response_data[] = [
              'id'        => $school->id,
              'school_name' => $school->school_name,
              'dept_data' => $this->getDeptsBySchoolId($school->id),
            ];
          }
          return view('manageClasses',['response_data'=>$response_data]);
      }catch(\Exception $e){
          return view('excep');
      }
    }

    public function getDeptsBySchoolId($school_id){
      $return_data = [];
      $deps = DB::table('departments')->where('school_id',$school_id)->get();
        foreach ($deps as $dep) {
          $return_data[] = [
            'id'         => $dep->id,
            'dept_name'  => $dep->d_name,
            'class_data' => $this->getClassesByDeptId($dep->id),
          ];
        }
      return $return_data;
    }

    public function getClassesByDeptId($dept_id){
      $return_data = [];
      $return_data['classes'] = DB::table('class')
        ->where('dept_id',$dept_id)
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
                    'subject'  => $request[$week.'_'.$i.'_subject']
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
            return redirect('/manage/class');
        }catch(\Exception $e){
            return $e->getMessage();
            return view('excep');
        }
    }
    public function deleteClass(Request $request){
        try{
            $query = DB::table('class')
                ->where('id',$request['id'])
                ->delete();
            return redirect('/manage/class');
        }catch(\Exception $e){
            return view('excep');
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
            }            
            $response_data['class'] = $class_data;
            $response_data['subjects'] = json_decode($subjects);
            return view('editClass',['class'=>$response_data]);
        }catch(\Exception $e){
            return view('excep');    
        }
    }

    public function updateClass(Request $request){
        $class_id  = $request['id'];
        $className = strip_tags($request['className']);
        $subjects  = json_encode(explode(',',strip_tags($request['subjects'])));
        $count     = count(explode(',',$subjects));        
        try{
            $updateClass = DB::table('class')
                ->where('id',$class_id)
                ->update([
                    'value'        => $className,
                    'num_subjects' => $count,
                ]);
            $upSubjects = DB::table('subjects')
                ->where('class_id',$class_id)
                ->update([
                    'subjects_list' => $subjects,
                ]);
            return redirect('/manage/class');
        }catch(\Exception $e){
            return view('excep');
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
            $stud_count = DB::table('student')
                ->where('class_id',$class_id)
                ->count();
            $response_data['class_data'] = $class_data;
            $response_data['students']   = $stud_count;
            return view('viewClass',['responseData'=>$response_data]);
        }catch(\Exception $e){
            return view('excep');
        }
    }
}
