<?php

namespace App\Http\Controllers;

use App\Repositories\Books;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    protected $books;

    public function __construct(Books $books)
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function login() 
    {
        return view('login');
    }

    public function cart() 
    {
        return view('cart');
    }
}
