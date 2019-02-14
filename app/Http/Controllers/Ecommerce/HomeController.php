<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Posts;
use App\Repositories\Lots;
use App\Repositories\Authors;
use App\Repositories\Sliders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    
    protected $posts;
    protected $authors;
    protected $sliders;
    protected $lots;

    public function __construct(Posts $posts, Authors $authors, Sliders $sliders, Lots $lots) {
        $this->posts = $posts;
        $this->authors = $authors;
        $this->sliders = $sliders;
        $this->lots = $lots;
    }

    public function index()
    {
        $authors = $this->authors->all('limit=8&orderby=thumbnail&order=asc');
        $posts = $this->posts->all("post", 'skip=0&limit=8&orderby=created_at&order=asc');
        $slider = $this->sliders->find('home-slider');

        // Obtener los libros del ultimo lote
        $lot_books = $this->lots->findMostRecent()->books;

        $medician = [];
        $odontologic = [];

        for ($i = 0; $i < count($lot_books); $i++) { 

            $book = $lot_books[$i];

            for ($t=0; $t < count($lot_books[$i]->taxonomies); $t++) { 
                if($lot_books[$i]->taxonomies[$t]->id == 1) {
                    array_push($medician, $book);
                } else if($lot_books[$i]->taxonomies[$t]->id == 2) {
                    array_push($odontologic, $book);
                }
            }
        }

        $info_send = [
            'medician' => $medician,
            'odontologic' => $odontologic,
            'authors' => $authors->posts,
            'posts' => $posts->posts,
            'slider' => $slider->items,
        ];

        return view('ecommerce.home', $info_send);
    }

    public function login() 
    {

        if(session('user')) {
            return redirect('mi-cuenta');
        }

        return view('ecommerce.login');
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
