<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Posts;
use App\Repositories\Authors;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    
    protected $posts;

    public function __construct(Posts $posts, Authors $authors) {
        $this->posts = $posts;
        $this->authors = $authors;
    }

    public function index()
    {
        $odontologic = $this->posts->all("book", 'orderby=title&skip=0&limit=8');
        $medician = $this->posts->all("book", 'orderby=title&skip=8&limit=8');

        $authors = $this->authors->all('skip=0&limit=8&orderby=thumbnail&order=asc');

        return view('ecommerce.home', [ 'medician' => $medician->posts, 'odontologic' => $odontologic->posts, 'authors' => $authors->posts ]);
    }

    public function login() 
    {
        return view('ecommerce.login');
    }

    public function cart() 
    {

        if (!session('cart')) {
            return view('ecommerce.cart.empty');
        } else {

            $cart = session('cart');

            //Related posts
            $related = $this->posts->all("book", "orderby=title&order=asc&limit=8&random=1")->posts;

            return view('ecommerce.cart.index', [ 'cart' => $cart, 'related' => $related ]);

        }
    }
}
