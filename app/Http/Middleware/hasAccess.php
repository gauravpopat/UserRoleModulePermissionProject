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

    //module_code -> module_name & $access -> (c,r,u,d)access
    public $module_name, $access_name;

    public function handle(Request $request, Closure $next, $module_code, $access): Response
    {
        //Get auth User.
        $user = Auth::user();

        if ($user->hasAccess($module_code, $access)) { // => user.php->hasAccess()
            return $next($request);
            //return response($user->hasAccess($module_code, $access));
        } else {
            return error('Access denied...');
        };
    }
}
