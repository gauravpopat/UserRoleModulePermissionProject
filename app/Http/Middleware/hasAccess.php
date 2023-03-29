<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class hasAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public $module_name,$access_name;

    public function handle(Request $request, Closure $next, $module_code, $access): Response
    {
        $user = Auth::user();
        // return response($user);

        if($user->hasAccess($module_code,$access)){
            return $next($request); 
        };
        return error('Access denied...');
    }
}
