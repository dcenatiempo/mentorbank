<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Closure;

class AuthenticateWithPin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Log::debug(json_encode($request->session()->all()));

        return $next($request);
    }
}
