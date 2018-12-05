<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminAccountController extends Controller
{
    public function index() {
    	return view('admin.dashboard');
    }

    public function MyAccount() {
    	return view('admin.mi-cuenta');
    }
}
