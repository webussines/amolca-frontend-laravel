<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Posts;
use App\Repositories\Authors;
use App\Repositories\Sliders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    
    protected $posts;
    protected $authors;
    protected $sliders;

    public function __construct(Posts $posts, Authors $authors, Sliders $sliders) {
        $this->posts = $posts;
        $this->authors = $authors;
        $this->sliders = $sliders;
    }

    public function index()
    {
        $odontologic = $this->posts->taxonomies(2, 'orderby=publication_year&order=desc&limit=8');
        $medician = $this->posts->taxonomies(1, 'orderby=publication_year&order=desc&limit=8');

        $authors = $this->authors->all('limit=8&orderby=thumbnail&order=asc');
        $posts = $this->posts->all("post", 'skip=0&limit=8&orderby=created_at&order=asc');
        $slider = $this->sliders->find('home-slider');

        $info_send = [
            'medician' => $medician->posts,
            'odontologic' => $odontologic->posts,
            'authors' => $authors->posts,
            'posts' => $posts->posts,
            'slider' => $slider->items,
        ];

        return view('ecommerce.home', $info_send);
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

            if(!isset(session('cart')->products)) {
                return view('ecommerce.cart.empty');
            }

            if(count(session('cart')->products) < 1) {
                return view('ecommerce.cart.empty');
            }

            //Related posts
            $related = $this->posts->all("book", "orderby=title&order=asc&limit=8&random=1")->posts;

            return view('ecommerce.cart.index', [ 'cart' => $cart, 'related' => $related ]);

        }
    }

    public function checkout() 
    {

        if (!session('cart')) {
            return view('ecommerce.cart.empty');
        } else {

            $cart = session('cart');
            return view('ecommerce.cart.checkout', [ 'cart' => $cart ]);

        }
    }

    public function contact() 
    {
        return view('ecommerce.contact');
    }

    public function termsandconditions() 
    {
        return view('ecommerce.terms-and-conditions');
    }
}
