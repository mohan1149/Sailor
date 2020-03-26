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
            return response()->json('Internal Server Error',500);
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
                    return response()->json('Internal Server Error',500);
                }
        }catch(\Exception $e){
            return response()->json('Internal Server Error',500);
        }
    }
    public function manageArticles(){
        $user_id = $_SESSION['user_id'];
        $articles = DB::table('articles')
            ->where('user_id',$user_id)
            ->limit(8)
            ->orderBy('id')
            ->get();
        return view('manageArticles',['articles'=>$articles]);
    }
}