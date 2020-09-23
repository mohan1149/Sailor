<?php

namespace App\Http\Controllers\api\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Edujugon\PushNotification\PushNotification;
use App\Http\Controllers\Mailings\MailController;
class ExamsController extends Controller
{
    public function createExam(Request $request){
        try{            
            $ex_title        = $request['exTitle'];
            $ex_desc         = $request['exDesc'];
            $ex_maxmarks     = $request['exMaxmarks'];
            $ex_qualifymarks = $request['exQualifymarks'];
            $ex_date         = $request['exDate'];
            $ex_time         = $request['exTime'];
            $ex_attachments  = json_encode($request['exAttachments']);
            $ex_class        = $request['exClass'];
            $ex_subject      = $request['exSubject'];
            $ex_uid          = $request['uid'];            
            $create_exam = DB::table('exams')
                ->insert([
                    'ex_title'          => $ex_title,
                    'ex_desc'           => $ex_desc,
                    'ex_maxmarks'       => $ex_maxmarks,
                    'ex_qualifymarks'   => $ex_qualifymarks,
                    'ex_date'           => $ex_date,
                    'ex_time'           => $ex_time,
                    'ex_attachments'    => $ex_attachments,
                    'ex_class'          => $ex_class,
                    'ex_subject'        => $ex_subject,
                    'ex_uid'            => $ex_uid,
                    'is_marks_assigned' => 0,
                ]);
            return response()->json(1, 200);
        }catch(\Exception $e){
            return response()->json($e->getMessage(), 200);
        }
    }
    
    public function getExams(Request $request){
        try{
            $uid = $request['uid'];
            $exams = DB::table('exams')
                ->join('class','class.id','=','exams.ex_class')
                ->join('grades','grades.id','=','class.class_year')
                //->join('exam_marks','exam_marks.exam_id','=','exams.id')
                ->where('ex_uid',$uid)
                ->where('is_marks_assigned',0)
                ->orderBy('ex_date')
                ->select(['exams.id','class.id as class_id','exams.ex_subject','grades.grade_year','class.class_name','exams.ex_date','exams.ex_time','exams.ex_title','exams.is_marks_assigned','exams.ex_maxmarks'])
                ->get();
            return response()->json($exams, 200);
        }catch(\Exception $e){
            return response()->json($e->getMessage(), 200);
        }
    }

    public function getClassStudents(Request $request){
        try{
            $cid = $request['cid'];
            $students = DB::table('student')
                ->where('class_id',$cid)
                ->orderBy('sid')
                ->get();
            return response()->json($students, 200);
        }catch(\Exception $e){
            return response()->json($e->getMessage(), 200);
        }
    }

    public function saveExamMarks(Request $request){
        try{
            $class_id = $request['class_id'];
            $exam_id  = $request['exam_id'];
            $students = $request['students'];               
            foreach($students as $student){
                $student_json[$student['id']] = [
                    'id'    => $student['id'],
                    'marks' => $student['marks'],
                ];
            }                          
            $insert = DB::table('exam_marks')
                ->insert([
                    'exam_id'       => $exam_id,
                    'exam_class'    => $class_id,
                    'exam_students' => json_encode($student_json),
                ]);
            return response()->json(1, 200);
        }catch(\Exception $e){
            return response()->json($e->getMessage(), 200);
        }
    }
}