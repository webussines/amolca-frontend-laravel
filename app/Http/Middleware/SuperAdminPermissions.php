<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminPermissions
{

    protected $request;

    public function __construct(Request $request) {

        $this->request = $request;

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $route = json_decode( json_encode( $this->request->route()->getAction() ) );

        $complete = explode('\\', $route->controller);
        $controller = $complete[count($complete) - 1];
        $active = explode('@', $controller)[0];

        $route_to_redirect = '/am-admin/libros';

        switch ($active) {
            case 'AdminBooksController':
                $route_to_redirect = '/am-admin/libros/inventario';
                break;

            case 'AdminSettingsController':
                $route_to_redirect = '/am-admin/ajustes';
                break;

            case 'AdminOrdersController':
                $route_to_redirect = '/am-admin/pedidos';
                break;
            
            default:
                $route_to_redirect = '/am-admin/libros';
                break;
        }

        $url = $request->url();

        if(session('user')->role !== 'SUPERADMIN') {
            return redirect($route_to_redirect);
        }

        return $next($request);
    }
}
