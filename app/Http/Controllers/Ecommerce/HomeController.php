<?php

namespace App\Http\Controllers\Ecommerce;

use App\Repositories\Books;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    
    protected $books;

    public function __construct(Books $books)
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        return view('ecommerce.home');
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
