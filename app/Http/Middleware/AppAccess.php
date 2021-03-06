<?php

namespace App\Http\Middleware;

use Closure;

class AppAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*$token = $request->bearerToken();
        if ($token != env('API_KEY')) {
            return response()->json('Unauthorized', 401);
        }*/
        if(isset($_SESSION['user_id']) && isset($_SESSION['role'])){
            if($_SESSION['user_id'] != '' && $_SESSION['role'] == 0){
                return $next($request);
            }else{
                return response()->view('accessDenied');    
            }
        }else{
            return response()->view('accessDenied');
        }
    }
}
