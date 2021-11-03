<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ((\Auth::user()->role == User::ROLE_ULTRA_ADMIN)||(\Auth::user()->role == User::ROLE_ADMIN)) {
            return $next($request);
        }
        return redirect('/');
    }
}
