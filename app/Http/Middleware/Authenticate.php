<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->get('Profil') === null) {
            if ($request->session()->get('User') === 'User' OR $request->session()->get('User')=='User') {
                return redirect()->route('index');

            }else{
               return redirect()->route('Login'); 
            }
        } 
        return $next($request);
    }
}
