<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Posts;
use App\Repositories\Lots;
use App\Repositories\Authors;
use App\Repositories\Sliders;
use App\Repositories\Banners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{

    protected $posts;
    protected $authors;
    protected $sliders;
    protected $lots;

    public function __construct(Posts $posts, Authors $authors, Sliders $sliders, Lots $lots, Banners $banners, Request $request) {

        $this->posts = $posts;
        $this->authors = $authors;
        $this->sliders = $sliders;
        $this->lots = $lots;
        $this->banners = $banners;

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

        $lot_books = $this->lots->findActiveLot();
        if( !isset($lot_books->id) ) {
            // Obtener los libros del ultimo lote
            if( isset($this->lots->findMostRecent()->books) ) {
                $releases_books = $this->lots->findMostRecent()->books;
            } else {
                $releases_books = [];
            }
        } else {
            $releases_books = $lot_books->books;
        }

        $medician = [];
        $odontologic = [];

        for ($i = 0; $i < count($releases_books); $i++) {

            $book = $releases_books[$i];

            for ($t=0; $t < count($releases_books[$i]->taxonomies); $t++) {
                if($releases_books[$i]->taxonomies[$t]->id == 1) {
                    array_push($medician, $book);
                } else if($releases_books[$i]->taxonomies[$t]->id == 2) {
                    array_push($odontologic, $book);
                }
            }
        }

        $info_send = [
            'medician' => $medician,
            'odontologic' => $odontologic,
            'authors' => [],
            'posts' => [],
            'slider' => [],
        ];

        // If isset authors posts
        if( isset($authors->posts) ) {
            $info_send['authors'] = $authors->posts;
        }

        // If isset blog posts
        if( isset($posts->posts) ) {
            $info_send['posts'] = $posts->posts;
        }

        // If isset slider items
        if( isset($slider->items) ) {
            $info_send['slider'] = $slider->items;
        }

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

        $page_id = 4;

        $banner = $this->banners->findByResource('page', $page_id);

        $send = [];

        if( isset($banner->id) ) {
            $send['banner'] = $banner;
        }

        return view('ecommerce.contact', $send);

    }

    public function termsandconditions()
    {

        $page_id = 3;

        $banner = $this->banners->findByResource('page', $page_id);

        $send = [];

        if( isset($banner->id) ) {
            $send['banner'] = $banner;
        }

        switch ( get_option('sitecountry') ) {

            case 'COLOMBIA':
                return view('ecommerce.terms-policy.colombia', $send);
                break;

            case 'ARGENTINA':
                return view('ecommerce.terms-policy.argentina', $send);
                break;

            case 'MEXICO':
                return view('ecommerce.terms-policy.mexico', $send);
                break;

            case 'DOMINICAN REPUBLIC':
                return view('ecommerce.terms-policy.dominican-republic', $send);
                break;

            default:
                return redirect('/');
                break;

        }

    }

}
