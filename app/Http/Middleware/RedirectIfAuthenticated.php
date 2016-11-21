<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;




class RedirectIfAuthenticated
{



    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            $role = Auth::user()->role_id;
            $uid = Auth::user()->id;

            switch($role) {
                case ROLE_ADMIN:
                    return redirect(route('userList'));
                    break;
                case ROLE_COOK:
                    return redirect(route('cook.list'));
                    break;
                case ROLE_WAITER:
                    return redirect(route('waiter.list'));
                    break;
            }
        }

        return $next($request);
    }


}
