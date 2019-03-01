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

    public function __construct(Posts $posts, Authors $authors, Sliders $sliders, Lots $lots, Request $request) {

        $this->posts = $posts;
        $this->authors = $authors;
        $this->sliders = $sliders;
        $this->lots = $lots;

    }

    public function index()
    {

        $slider_name = 'casa-matriz-slider';

        switch (get_option('sitecountry')) {
            case 'COLOMBIA':
                $slider_name = 'home-slider';
                break;

            case 'PANAMA':
                $slider_name = 'panama-slider';
                break;

            case 'ARGENTINA':
                $slider_name = 'argentina-slider';
                break;

            case 'MEXICO':
                $slider_name = 'mexico-slider';
                break;

            case 'PERU':
                $slider_name = 'peru-slider';
                break;

            case 'DOMINICAN REPUBLIC':
                $slider_name = 'republica-dominicana-slider';
                break;
        }

        $authors = $this->authors->provisional('orderby=thumbnail&order=asc&limit=8');
        $posts = $this->posts->all("post", 'skip=0&limit=8&orderby=created_at&order=asc');
        $slider = $this->sliders->find($slider_name);

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

    public function contact() 
    {
        return view('ecommerce.contact');
    }

    public function termsandconditions() 
    {
        switch ( get_option('sitecountry') ) {

            case 'COLOMBIA':

                return view('ecommerce.terms-policy.colombia');

                break;

            case 'ARGENTINA':

                return view('ecommerce.terms-policy.argentina');
                
                break;

            case 'MEXICO':

                return view('ecommerce.terms-policy.mexico');
                
                break;

            case 'DOMINICAN REPUBLIC':

                return view('ecommerce.terms-policy.dominican-republic');
                
                break;

        }
    }

}
