<?php

namespace App\Http\Controllers\api\Content;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class ArticlesController extends Controller
{
    public function publishArticle(Request $request){
        $basepath  = $request->getSchemeAndHttpHost();
        $hex       = bin2hex(openssl_random_pseudo_bytes(16));
        $title     = $request['art_title'];
        $data      = $request['article'];
        $html_link = str_ireplace(" ", "_", $title.$hex.".html");
        try{
            $art_html = fopen(storage_path()."/app/public/articles/".$html_link, "w");
            $write    = fwrite($art_html, $data);
            $url      = $basepath.Storage::url('articles/'.$html_link);
        }catch(\Exception $e){
            return response()->json($e->getMessage(),500);
        }
        $user_id   = $_SESSION['user_id'];
        $likes     = 0;
        $created   = date('Y-m-d H:i:s');
        $html_link = $url;
        try{
            $query = DB::table('articles')
                ->insert([
                    'user_id'   => $user_id,
                    'likes'     => $likes,
                    'created'   => $created,
                    'title'     => $title,
                    'html_link' => $url,
                ]);
                if($query){
                    response()->json('Article Published',200);
                }else{
                    return response()->json($e->getMessage(),500);
                }
        }catch(\Exception $e){
            return response()->json($e->getMessage(),500);
        }
    }
    public function manageArticles(){
      try{
          $user_id = $_SESSION['user_id'];
          $articles = DB::table('articles')
              ->where('user_id',$user_id)
              ->orderBy('id','desc')
              ->get();
          return view('manageArticles',['articles'=>$articles]);
      }catch(\Exception $e){
        return view('excep');
      }
    }

    public function deleteArticle(Request $request){
      try{
        $art_id = $request['id'];
        $delete = DB::table('articles')
          ->where('id',$art_id)
          ->delete();
        return redirect('/manage/articles');
      }catch(\Exception $e){
        return view('excep');
      }
    }
}
