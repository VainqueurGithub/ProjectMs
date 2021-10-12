<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ExerciceComptable;
use Illuminate\Http\Request;

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
    {   $Nbre = ExerciceComptable::whereEtat(0)->count('id');
        if ($Nbre!=0) {
            return $next($request);
        }
        return back();
    }
}
