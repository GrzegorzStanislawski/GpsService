<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Log;

class ApiMiddleware
{


    public function handle($request, Closure $next)
    {
    	Log::save('logs/');
        return $next($request);
    }


}//end class