<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Books;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    
    protected $books;

    public function __construct(Books $books) {
        $this->books = $books;
    }

    public function index()
    {
        $odontologic = $this->books->all('skip=0&limit=8');
        $medician = $this->books->all('skip=8&limit=8');
        return view('ecommerce.home', [ 'medician' => $medician, 'odontologic' => $odontologic ]);
    }

    public function login() 
    {
        return view('ecommerce.login');
    }

    public function cart() 
    {
        return view('ecommerce.cart');
    }
}
