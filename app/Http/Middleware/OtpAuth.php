<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OtpAuth
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
        if(!session('otp_auth'))
        {
            // echo $request->route()->uri;
            return redirect()->route('otp.index',[
                'to' => $request->route()->uri
            ]);
        }
        return $next($request);
    }
}
