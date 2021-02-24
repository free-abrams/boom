<?php

namespace App\Http\Middleware;

use App\Models\AdminUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VerifyPermission
{
    /**
     * Handle an incoming request.
     * 检查权限
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
    	if (\Auth::guard('admin')->user()->hasRoute(\Route::currentRouteName()) === false) {
    		return redirect()->route('index.error');
	    }
    	
        return $next($request);
    }
}
