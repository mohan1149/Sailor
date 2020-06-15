<?php

namespace App\Http\Controllers\api\Attendence;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Edujugon\PushNotification\PushNotification;
use App\Http\Controllers\Mailings\MailController;
class AttendenceController extends Controller
{
    public function postAttendence(Request $request){
        try{
            $classId  = $request['classId'];
            $session  = $request['session'];
            $posterId = $request['posterId'];
            $students = $request['students'];
            foreach($students as $student){
                $month = date('m');
                $check_month = DB::table('student_attendence')
                    ->updateOrInsert(
                        [
                            'month'      => $month,
                            'sid'        => $student['id'],                            
                        ],
                        ['month' => $month]
                    );
                $percentage = $student['status'] ? 1 : 0;
                $update = DB::table('student_attendence')
                    ->where('sid',$student['id'])
                    ->where('month',$month)               
                    ->increment('percentage',$percentage);
                $student_json[$student['sid']] = [                    
                    'sid'    => $student['sid'],
                    'status' => $student['status']
                ];                
            }            
            $insert = DB::table('school_attendence')
                ->insert([
                    'attend_class_id' => $classId,
                    'attend_session'  => $session,
                    'attend_date'     => date('Y-m-d'),
                    'attend_poster'   => $posterId,  
                    'attend_students' => json_encode($student_json),
                ]);
                return response()->json(1,200);
        }catch(\Exception $e){
            return response()->json(0,200);
        }              
    }
}