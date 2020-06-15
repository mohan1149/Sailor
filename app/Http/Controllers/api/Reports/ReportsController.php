<?php

namespace App\Http\Controllers\api\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Edujugon\PushNotification\PushNotification;
use App\Http\Controllers\Mailings\MailController;
class ReportsController extends Controller
{
    public function getUserSyllabus(Request $request){
        try{
            $teacher_id = $request['uid'];   
            $sid        = $request['sid'];         
            $school     = DB::table('school')->where('id',$sid)->select('school_periods')->first();
            $periods    = $school->school_periods;
            $weeks      = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
            $timetable  = [];      
            $teacher_classes = [];      
            foreach ($weeks as $week) {
                for($i = 1; $i <= $periods; $i++){
                  $timetable[$week][$i] = DB::table('timetable')
                    ->join('class','timetable.class_id','=','class.id')                    
                    ->join('grades','grades.id','=','class.class_year')                    
                    ->whereRaw($week."->'".$i."'->>'staff_id' = ? ",[$teacher_id])
                    ->selectRaw($week."->'".$i."'->>'subject' as subject,class_id,class.class_name,grades.grade_year")
                    ->first($week);
                }
            } 
            $syllabus = [];            
            foreach($timetable as $key =>  $week){
                foreach($week as $period => $day){
                    if($day !== null){
                        $syllabus [] = $day;
                    }
                }
            }
            $classes  = [];
            $subjects = [];
            $final    = [];            
            foreach($syllabus as $class){                   
                if(!in_array($class->class_id,$classes) || !in_array(json_decode($class->subject)->subject,$subjects)){                
                    array_push($classes,$class->class_id);
                    array_push($subjects,json_decode($class->subject)->subject);
                    array_push($final,$class);                    
                }
            }                        
            foreach($final as $subject){                
                $sub =  json_decode($subject->subject)->subject;                
                $subjects_count[] = [
                    'className' => $subject->class_name,
                    'gradeYear' => $subject->grade_year,
                    'subjects'  => $this->getSubjectData($subject->class_id,$sub),
                ];                     
            }   


            $return_data['sub_syllabus']  = $subjects_count;
            $return_data['classes_count'] = $this->getUserTakenClases($teacher_id);
            return response()->json($return_data,200);                       
        }catch(\Exception $e){
            return response()->json($e->getLine(),200);
        }
    }
    public function getSubjectData($cid,$sub){
        try{                        
            $sub_name = $sub;
            $data     = DB::table('subjects')
                ->where('class_id',$cid)
                ->first();
            $subjects     = json_decode($data->subjects_list);
            $subjects     = (array) $subjects;
            $subject_data = [];
            foreach($subjects as $key => $subject){
                if($subject->subject_name == $sub_name){
                    $subject_data['subject'] = $subject;
                    $subject_data['key']     = $key;
                    break;
                }
            }
            return $subject_data;        
        }catch(\Exception $e){
            return [];
        }
    }
    public function getUserTakenClases($uid){
        try{
            $count = DB::select("
                select count(*),
                date_part('month',attend_date)
                from school_attendence
                where attend_poster = ? 
                group by (date_part('month',attend_date))",
                [$uid]
            );
            return $count;
        }catch(\Exception $e){
            return [];
        }
    }

}