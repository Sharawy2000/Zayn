<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $routeName = $request->route()->getName();
        $permission = Permission::whereRaw("FIND_IN_SET('$routeName',routes)")->first();

        if($permission){
            if($user->can($permission->name)){
                return $next($request);
            }else{
                abort(403);
            }
        }else{
            abort(403);
        }
    }
}
