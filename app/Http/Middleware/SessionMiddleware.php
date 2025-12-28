<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use App\Models\Session;

class SessionMiddleware
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
        $session_id = session()->get('PHPSESSID');

        if(empty(Session::checkSession($session_id))){
            return redirect()->to(Config::get('jobfit.direct_url'));
        }

        elseif(Session::checkSession($session_id)->level != 'admin'){
            return redirect()->to(Config::get('jobfit.direct_url'));
        }

        return $next($request);
    }
}
