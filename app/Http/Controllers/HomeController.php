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
        $this->books = $books;
    }

    public function index()
    {
        $books = $this->books->all();
        return view('home', ['books' => $books]);
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
