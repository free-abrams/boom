<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

class VerifyLogin
{
    /**
     * Handle an incoming request.
     * 未登录用户跳转登录页面
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
    	if(!\Auth::guard('admin')->check()) {
    		return redirect()->route('login');
	    }
    	
        return $next($request);
    }
}
