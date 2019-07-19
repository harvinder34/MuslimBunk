<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class API
{
    
	public function handle($request, Closure $next)
    {
		return $next($request); 
    }
}
