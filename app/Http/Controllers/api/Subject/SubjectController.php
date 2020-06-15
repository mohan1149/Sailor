<?php

namespace App\Http\Controllers\api\Subject;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Edujugon\PushNotification\PushNotification;
use App\Http\Controllers\Mailings\MailController;
class SubjectController extends Controller
{
    public function getSubjectDataBySubject(Request $request){
        try{            
            $cid      = $request['cid'];
            $sub_name = $request['subject'];
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
            return response()->json($subject_data,200);            
        }catch(\Exception $e){
            return response()->json(0,200);
        }
    }

    public function updateSubjectSyllabus(Request $request){
        try{
            $targetClass      = $request['targetClass'];
            $targetSubject    = $request['targetSubject'];
            $targetChapter    = $request['targetChapter'];
            $targetPercentage = $request['targetPercentage'];
            
            $subject = DB::table('subjects')
                ->where('class_id',$targetClass)                
                ->selectRaw("subjects_list->'".$targetSubject."'->'subject_chapters' as subject")
                ->get();
            $d = (array)$subject[0];
            $s = (array)json_decode($d['subject']);
            $sum = 0;
            foreach($s as $key => $t){
                if($key != $targetChapter){
                    $sum += $t->chapter_compltion;
                }                
            }
            $sum += $targetPercentage;                     
            $update = DB::table('subjects')
                ->where('class_id',$targetClass)
                ->update([
                    "subjects_list->".$targetSubject."->subject_chapters->".$targetChapter.'->chapter_compltion' => $targetPercentage,                    
                ]);
            $updateTotal = DB::table('subjects')
                ->where('class_id',$targetClass)
                ->update([                
                    "subjects_list->".$targetSubject."->subject_completion" => ceil($sum/count($s)),
                ]);
            return response()->json(1,200);
        }catch(\Exception $e){
            return response()->json($e->getMessage(),200);
        }
    }
}
