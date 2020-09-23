<?php

namespace App\Http\Controllers\api\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Edujugon\PushNotification\PushNotification;
use App\Http\Controllers\Mailings\MailController;
class NotificationsController extends Controller
{
    public function addNotifcation(Request $request){
        try{
            $uid           = $request['uid'];
            $nfTitle       = $request['nfTitle'];
            $nfDesc        = $request['nfDesc'];
            $notif_sid     = $request['notif_sid'];
            $targetAll     = $request['targetAll'];
            $allStaff      = $request['allStaff'];
            $allStudents   = $request['allStudents'];
            $finalClasses  = $request['finalClasses'];
            $nfAttachments = $request['nfAttachments'];            
            $insert = DB::table('notifications')
                ->insert([
                    'notif_uid'            => $uid,
                    'notif_title'          => $nfTitle,
                    'notif_desc'           => $nfDesc,
                    'notif_target_all'     => $targetAll,
                    'notif_all_staff'      => $allStaff,
                    'notif_all_students'   => $allStudents,
                    'notif_target_classes' => json_encode($finalClasses),
                    'notif_attachments'    => json_encode($nfAttachments),
                    'notif_date'           => date('Y-m-d'),
                    'notif_sid'            => $notif_sid,
                ]);
            return response()->json(1,200);
        }catch(\Exception $e){
            return response()->json($e->getMessage(),200);
        }
    }

    public function getMyNotifications(Request $request){
        try{
            $uid = $request['uid'];
            $notifications = DB::table('notifications')
                ->where('notif_uid',$uid)
                ->orderBy('notif_date')
                ->get();
            return response()->json($notifications, 200);
        }catch(\Exception $e){
            return response()->json($e->getMessage(),200);
        }
    }
    public function deleteNotification(Request $request){
        try{
            $nid = $request['nid'];
            $delete = DB::table('notifications')
                ->where('id',$nid)
                ->delete();
                return response()->json(1, 200);
        }catch(\Exception $e){
            return response()->json($e->getMessage(), 200);
        }
    }

    public function getNotifications(Request $request){
        try{
            $sid = $request['sid'];            
            $notifs = DB::table('notifications')
                ->where('notif_sid',$sid)
                ->get();
            return response()->json($notifs,200);
        }catch(\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }
}