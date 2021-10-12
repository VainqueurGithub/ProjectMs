<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;
class CheckDatabaseConnection
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
        try {
          
            DB::connection()->getPdo();

            if(DB::connection()->getDatabaseName()){
                return $next($request);
            }else{
                $errorMessage = "Could not find the database. Please check your configuration.";
                //return view('', compact('errorMessage'));
                return response()->view('errors.500', ['data' => $errorMessage]);
            }
        } catch (\Exception $e) {
             $errorMessage = "Could not open connection to database server.  Please check your configuration.";
             //return view('errors.500', compact('errorMessage'));
             return response()->view('errors.500', ['data' => $errorMessage]);
        }
        
    }
}
