<?php

namespace App\Http\Controllers\api\Homework;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Edujugon\PushNotification\PushNotification;
use App\Http\Controllers\Mailings\MailController;
class HomeworkController extends Controller
{
    public function postHomework(Request $request){
        try{
            $hw_uid     = $request['uid'];
            $hw_class   = $request['hwClass'];
            $hw_title   = $request['hwTitle'];
            $hw_desc    = $request['hwDesc'];
            $hw_date    = date('Y-m-d');
            $hw_subject = $request['hwSubject'];
            $images    = $request['hwImages'];
            $files     = $request['hwAttachs'];            
            $insert  = DB::table('homeworks')
                ->insert([
                    'hw_uid'         => $hw_uid,
                    'hw_class'       => $hw_class,
                    'hw_title'       => $hw_title,
                    'hw_desc'        => $hw_desc,
                    'hw_date'        => $hw_date,
                    'hw_subject'     => $hw_subject,
                    'hw_images'      => json_encode($images),
                    'hw_attachments' => json_encode($files),
                ]);
            return response()->json(1, 200);
        }catch(\Exception $e){
            return response()->json($e->getMessage(), 200);
        }
    }



    public function test(){
        $hw = DB::table('homeworks')
            ->get();
        return $hw;
    }
}