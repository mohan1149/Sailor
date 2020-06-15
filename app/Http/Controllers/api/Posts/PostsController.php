<?php

namespace App\Http\Controllers\api\Posts;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Edujugon\PushNotification\PushNotification;

class PostsController extends Controller
{
    public function addPost(Request $request){
        try{
            $ins_id        = $request['ins_id'];
            $ins_type      = $request['ins_type'];
            $poster_id     = $request['poster_id'];
            $poster_name   = $request['poster_name'];
            $post_title    = strip_tags($request['post_title']);
            $post_desc     = $request['post_desc'];
            $post_date     = date('Y-m-d');
            $post_day      = $request['post_day'];
            $poster_image  = $request['poster_image'];
            $post_thumnail = $request['post_thumbnail'];
            $postId = DB::table('posts')
                ->insertGetId([
                    'ins_id'         => $ins_id,
                    'ins_type'       => $ins_type,
                    'poster_id'      => $poster_id,
                    'poster_name'    => $poster_name,
                    'post_title'     => $post_title,
                    'post_desc'      => $post_desc,
                    'post_date'      => $post_date,
                    'post_day'       => $post_day,
                    'poster_image'   => $poster_image,
                    'post_thumbnail' => $post_thumnail,
                ]);
            return response()->json(1,200);
        }catch(\Exception $e){
            return response()->json(0,200);
        }
    }    
    public function getUserPosts(Request $request){
        try{
            $offset = $request['offset'] == '' ? 0 : $request['offset'];
            $upper_limit = 10;
            $uid = $request['uid'];
            $posts = DB::table('posts')
                ->where('poster_id',$uid)
                ->offset($offset)
                ->limit(20)
                ->get();
            return response()->json($posts,200);
        }catch(\Exxception $e){
            return response()->json(0,200);
        }
    }

    public function getSchoolPosts(Request $request){
        try{
            $sid = $request['sid'];
            $uid = $request['uid'];
            $posts = DB::table('posts')
                ->where('ins_id',$sid)
                ->where('poster_id', '!=', $uid)
                ->get();
            return $posts;
        }catch(\Exception $e){
            return response()->json(0,200);
        }
    }

    public function deletePost(Request $request){
        try{
            $pid = $request['pid'];
            $delete = DB::table('posts')
                ->where('id',$pid)
                ->delete();
            return response()->json(1,200);
        }catch(\Exception $e){
            return reponse()->json(0,200);
        }
    }
}
