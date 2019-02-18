<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{    

	protected $roles = ["SUPERADMIN", "ADMIN", "SELLER", "AUTHOR", "EDITOR"];

    public function handle($request, Closure $next)
    {
        if(!session('access_token')) {
            if(!session('user') || !in_array(session('user')->role, $roles)) {
            	return redirect('/am-admin?redirect=' . $request->url());
            }
        }

        return $next($request);
    }
}