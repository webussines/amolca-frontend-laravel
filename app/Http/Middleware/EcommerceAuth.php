<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EcommerceAuth
{

    public function handle(Request $request, Closure $next)
    {
        if( !session('access_token') ) {
            if( !session('user') ) {
                $url = $request->url();
            	return redirect('/iniciar-sesion?redirect=' . $url);
            }
        }

        return $next($request);
    }
}