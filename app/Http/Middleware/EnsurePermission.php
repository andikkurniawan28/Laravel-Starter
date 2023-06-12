<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Globalization;
use Illuminate\Support\Facades\Route;

class EnsurePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $global = Globalization::index();
        foreach($global["permission"] as $permission){

            if(Route::currentRouteName() == $permission->menu->route){
                return $next($request);
            }
            elseif(Route::currentRouteName() == $permission->menu->route.".index"){
                return $next($request);
            }
            elseif(Route::currentRouteName() == $permission->menu->route.".create"){
                return $next($request);
            }
            elseif(Route::currentRouteName() == $permission->menu->route.".edit"){
                return $next($request);
            }
            elseif(Route::currentRouteName() == $permission->menu->route.".show"){
                return $next($request);
            }
            elseif(Route::currentRouteName() == $permission->menu->route.".store"){
                return $next($request);
            }
            elseif(Route::currentRouteName() == $permission->menu->route.".update"){
                return $next($request);
            }
            elseif(Route::currentRouteName() == $permission->menu->route.".destroy"){
                return $next($request);
            }

        }

        return redirect()->back()->with("success", "You are not permitted to access those page!");
    }
}
