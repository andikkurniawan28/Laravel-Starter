<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Globalization;
use Illuminate\Support\Facades\Route;

class EnsurePermission
{
    /**
     * Function to perform permission checking based on the currently logged-in role.
     * The function will select based on the permissions stored in the database.
     * If the permission is not found, it will throw an alert stating that this route is inaccessible.
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
        return redirect()->back()->with("success", "You are not permitted to access ".Route::currentRouteName());
    }
}
