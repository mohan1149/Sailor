<?php

namespace App\Http\Middleware;

use Closure;

class MemberAccess
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
        session_start();
        if(isset($_SESSION['MemberAccess'])){
            if($_SESSION['MemberAccess']){
                return $next($request);
            }else{
                return response()->view('accessDenied');    
            }
        }else{
            return response()->view('accessDenied');
        }
    }
}
