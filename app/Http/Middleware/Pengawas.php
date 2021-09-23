<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\JwtSession;
use Illuminate\Http\Request;

class Pengawas
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
        $session   = JwtSession::user();
        $role      = $session->role;
        if($role->role_id != 2)
            return redirect()->route(strtolower($role->name).'.index');
        return $next($request);
    }
}
