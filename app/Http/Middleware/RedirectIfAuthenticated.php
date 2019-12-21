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
     // ログインした時に飛ぶページをユーザの種類によって決定する。
    public function handle($request, Closure $next, $guard = null)
    {
        if($request->ajax() === true)
        {
            return $next($request);
        }
        else
        {
            abort(404,'is not ajax!!!!');
        }
    }
}
