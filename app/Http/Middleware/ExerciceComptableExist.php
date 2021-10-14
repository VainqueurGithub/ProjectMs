<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ExerciceComptable;
use Illuminate\Http\Request;
use Session;
class ExerciceComptableExist
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
        if (Session::has('ExerciceComptableId')) {
            return $next($request);
        }
        return back();
    }
}
