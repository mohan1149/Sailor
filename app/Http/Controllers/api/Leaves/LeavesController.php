<?php

namespace App\Http\Controllers\api\Leaves;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Edujugon\PushNotification\PushNotification;
use App\Http\Controllers\Mailings\MailController;
class LeavesController extends Controller
{
    public function getUserLeaves(Request $request){
        try{
            $uid = $request['uid'];
            $leaves = DB::table('leaves')
                ->where('leave_uid',$uid)
                ->where('leave_status','!=',3)
                ->orderBy('leave_applied_on')
                ->get();
            return  response()->json($leaves, 200);
        }catch(\Exception $e){
            return  response()->json($e->getMessage(), 200);
        }
    }

    public function applyLeave(Request $request){
        try{
            $uid = $request['uid'];
            $reason = $request['reason'];
            $from   = date($request['from']);
            $to = date($request['to']);
            $insert = DB::table('leaves')
                ->insert([
                    'leave_uid'        => $uid,
                    'leave_reason'     => $reason,
                    'leave_from'       => $from,
                    'leave_to'         => $to,
                    'leave_status'     => 0,
                    'leave_applied_on' => date('Y-m-d')
                ]);
            return  response()->json(1, 200);
        }catch(\Exception $e){
            return  response()->json(0, 200);
        }
    }

    public function deleteLeave(Request $request){
        try{
            $id = $request['id'];
            $delete = DB::table('leaves')
                ->where('id',$id)
                ->update(['leave_status'=>3]);
            return response()->json(1, 200);
        }catch(\Exception $e){
            return response()->json(0, 200);
        }
    }
}