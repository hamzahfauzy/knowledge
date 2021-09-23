<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use App\Models\JwtSession;
use Illuminate\Http\Request;

class JwtMiddleware
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
        $token = $request->cookie('labura_layanan_app_token');
        if($token)
        {
            // check token validation
            $secret = env('APP_JWT_SECRET','');
            $decoded = JWT::decode($token, $secret, array('HS256'));
            JwtSession::init($decoded);
        }

        return $next($request);
    }
}
