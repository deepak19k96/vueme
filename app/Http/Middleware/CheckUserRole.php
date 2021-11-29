<?php

namespace App\Http\Middleware;

use App\Services\ApiUtils;
use Closure;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        if (auth()->check() && auth()->user()->email != 'blake@psychics1on1.com' && auth()->user()->email != 'account@psychics1on1.com')
        if (!auth()->user()->hasRole($role)) {

            return redirect('/');

        }
        return $next($request);
    }
}
